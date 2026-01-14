#!/bin/sh
# No usar set -e para permitir que el contenedor inicie incluso con errores menores
set +e

# =====================================================
# REDVEL FRAMEWORK - ENTRYPOINT GENÉRICO
# =====================================================

log_info() {
    echo "ℹ️  $1"
}

log_success() {
    echo "✅ $1"
}

log_warning() {
    echo "⚠️  $1"
}

log_error() {
    echo "❌ $1"
}

log_section() {
    echo ""
    echo "=============================================="
    echo "   $1"
    echo "=============================================="
    echo ""
}

# Ejecutar comando PHP con manejo de errores
run_artisan() {
    local cmd="$1"
    local ignore_error="${2:-false}"

    if [ "$ignore_error" = "true" ]; then
        php artisan $cmd 2>/dev/null || true
    else
        if ! php artisan $cmd; then
            log_warning "Comando falló: php artisan $cmd"
            return 1
        fi
    fi
    return 0
}

# =====================================================
# INICIO
# =====================================================

log_section "INICIANDO REDVEL FRAMEWORK"

# =====================================================
# DETECTAR ROL DEL CONTENEDOR (app/queue/scheduler)
# =====================================================
#
# Este mismo ENTRYPOINT se usa para varios servicios (app, queue-worker, scheduler).
# En workers/scheduler NO conviene ejecutar migraciones/seeds/optimize/scribe en cada arranque,
# porque:
# - si el comando falla, el contenedor entra en bucle de restart
# - se repiten migraciones/optimización innecesariamente
#
CMDLINE="$*"
ROLE="app"
case "$CMDLINE" in
    *"queue:work"*|*"queue:listen"*)
        ROLE="queue"
        ;;
    *"schedule:run"*)
        ROLE="scheduler"
        ;;
esac

log_info "🧩 Rol detectado: $ROLE"

# =====================================================
# VERIFICAR VARIABLES DE ENTORNO CRÍTICAS
# =====================================================

log_info "🔍 Verificando variables de entorno..."

# Cargar variables desde .env si existen
if [ -f ".env" ]; then
    log_info "📄 Cargando variables desde .env..."
    set -a
    . ./.env
    set +a
fi

# Verificar variables críticas
if [ -z "$DB_HOST" ]; then
    log_error "❌ DB_HOST no está definido"
    log_info "💡 Asegúrate de que DB_HOST esté en tu archivo .env"
fi

if [ -z "$DB_DATABASE" ]; then
    log_error "❌ DB_DATABASE no está definido"
    log_info "💡 Asegúrate de que DB_DATABASE esté en tu archivo .env"
fi

if [ -z "$DB_USERNAME" ]; then
    log_error "❌ DB_USERNAME no está definido"
    log_info "💡 Asegúrate de que DB_USERNAME esté en tu archivo .env"
fi

if [ -z "$DB_PASSWORD" ]; then
    log_warning "⚠️  DB_PASSWORD no está definido (puede ser intencional)"
fi

if [ -z "$REDIS_HOST" ]; then
    log_warning "⚠️  REDIS_HOST no está definido, usando valor por defecto: redis"
    REDIS_HOST="${REDIS_HOST:-redis}"
fi

# Mostrar información de conexión (sin contraseña)
log_info "📊 Configuración detectada:"
log_info "   DB_HOST: ${DB_HOST:-NO DEFINIDO}"
log_info "   DB_DATABASE: ${DB_DATABASE:-NO DEFINIDO}"
log_info "   DB_USERNAME: ${DB_USERNAME:-NO DEFINIDO}"
log_info "   DB_PORT: ${DB_PORT:-3306}"
log_info "   REDIS_HOST: ${REDIS_HOST:-redis}"
log_info "   REDIS_PORT: ${REDIS_PORT:-6379}"
log_info "   APP_ENV: ${APP_ENV:-NO DEFINIDO}"

# =====================================================
# ESPERAR SERVICIOS (BD y Redis)
# =====================================================

log_info "⏳ Esperando a que MySQL esté listo..."
log_info "   Host: ${DB_HOST:-NO DEFINIDO} | BD: ${DB_DATABASE:-NO DEFINIDO}"

max_attempts=30
attempt=0
sleep 5

if command -v mariadb >/dev/null 2>&1; then
    MYSQL_CMD="mariadb"
    SSL_ARGS="--skip-ssl"
elif mysql --version 2>&1 | grep -q "MariaDB"; then
    MYSQL_CMD="mysql"
    SSL_ARGS="--skip-ssl"
else
    MYSQL_CMD="mysql"
    SSL_ARGS="--ssl-mode=DISABLED"
fi

if [ -z "$DB_HOST" ] || [ -z "$DB_DATABASE" ] || [ -z "$DB_USERNAME" ]; then
    log_error "❌ Variables de base de datos incompletas. No se puede conectar a MySQL."
    log_error "   Verifica que DB_HOST, DB_DATABASE y DB_USERNAME estén definidos en tu .env"
else
    # Verificar resolución DNS primero
    log_info "🔍 Verificando resolución DNS para ${DB_HOST}..."
    DNS_RESOLVED=false
    if getent hosts "$DB_HOST" >/dev/null 2>&1; then
        DNS_RESOLVED=true
        RESOLVED_IP=$(getent hosts "$DB_HOST" | awk '{print $1}' | head -1)
        log_success "✅ DNS resuelto: ${DB_HOST} -> ${RESOLVED_IP}"
    elif command -v nslookup >/dev/null 2>&1 && nslookup "$DB_HOST" >/dev/null 2>&1; then
        DNS_RESOLVED=true
        log_success "✅ DNS resuelto: ${DB_HOST}"
    else
        log_warning "⚠️  No se puede resolver DNS para ${DB_HOST}"
        log_warning "   Esto puede indicar que:"
        log_warning "   1. El contenedor MySQL no está corriendo"
        log_warning "   2. Los contenedores no están en la misma red Docker"
        log_warning "   3. El nombre del servicio no coincide con DB_HOST"
        log_warning "   Verifica con: docker ps | grep mysql"
        log_warning "   Y: docker network inspect redvel-network-dev (o redvel-network-prod)"
    fi
    
    # Verificar conectividad de red si DNS está resuelto
    if [ "$DNS_RESOLVED" = "true" ]; then
        log_info "🔍 Verificando conectividad de red..."
        if command -v nc >/dev/null 2>&1; then
            if nc -z -w 2 "$DB_HOST" "${DB_PORT:-3306}" 2>/dev/null; then
                log_success "✅ Puerto ${DB_PORT:-3306} accesible en ${DB_HOST}"
            else
                log_warning "⚠️  Puerto ${DB_PORT:-3306} no accesible en ${DB_HOST}"
            fi
        elif command -v timeout >/dev/null 2>&1 && timeout 2 bash -c "echo > /dev/tcp/$DB_HOST/${DB_PORT:-3306}" 2>/dev/null; then
            log_success "✅ Puerto ${DB_PORT:-3306} accesible en ${DB_HOST}"
        else
            log_warning "⚠️  No se pudo verificar conectividad de red (puede ser normal si MySQL aún no está listo)"
        fi
    fi
    
    while true; do
        set +e
        OUTPUT=$($MYSQL_CMD -h"$DB_HOST" -P"${DB_PORT:-3306}" -u"$DB_USERNAME" -p"$DB_PASSWORD" \
            --connect-timeout=5 \
            $SSL_ARGS \
            -e "SELECT 1" "$DB_DATABASE" 2>&1)
        EXIT_CODE=$?
        set -e

        if [ $EXIT_CODE -eq 0 ]; then
            log_success "MySQL está listo!"
            break
        fi

        attempt=$((attempt + 1))
        if [ $attempt -ge $max_attempts ]; then
            log_warning "MySQL no responde después de $max_attempts intentos."
            log_warning "Detalles: $OUTPUT"
            if echo "$OUTPUT" | grep -q "getaddrinfo\|Unknown server host"; then
                log_error "❌ Error de resolución DNS detectado"
                log_error "   El hostname '${DB_HOST}' no se puede resolver"
                log_error "   Verifica que:"
                log_error "   1. El contenedor MySQL esté corriendo: docker ps | grep mysql"
                log_error "   2. Ambos contenedores estén en la misma red Docker"
                log_error "   3. El nombre del servicio en docker-compose coincida con DB_HOST"
                log_error "   4. Para desarrollo: DB_HOST debe ser 'mysql-dev'"
                log_error "   5. Para producción: DB_HOST debe ser 'mysql-prod'"
            fi
            log_warning "Continuando de todas formas (puede fallar más adelante)..."
            break
        fi
        log_info "   Intento $attempt/$max_attempts - Esperando MySQL..."
        sleep 5
    done
fi

log_info "⏳ Esperando a que Redis esté listo..."
log_info "   Host: ${REDIS_HOST:-redis} | Puerto: ${REDIS_PORT:-6379}"
attempt=0
while true; do
    if redis-cli -h "${REDIS_HOST:-redis}" -p "${REDIS_PORT:-6379}" --no-auth-warning ping 2>/dev/null | grep -q PONG; then
        log_success "Redis está listo!"
        break
    fi
    attempt=$((attempt + 1))
    if [ $attempt -ge 30 ]; then
        log_warning "Redis no responde después de 30 intentos, continuando de todas formas..."
        break
    fi
    log_info "   Intento $attempt/30 - Esperando Redis..."
    sleep 2
done

# =====================================================
# CONFIGURAR DIRECTORIOS
# =====================================================

log_info "📁 Configurando directorios y permisos..."
mkdir -p storage/framework/{sessions,views,cache,testing}
mkdir -p storage/logs
mkdir -p storage/app/public
mkdir -p bootstrap/cache
mkdir -p public/storage

chown -R www-data:www-data storage bootstrap/cache public/storage 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# =====================================================
# CONFIGURACIÓN DE ENTORNO
# =====================================================

# =====================================================
# LECTURA DE CONFIGURACIÓN (.deploy-mode)
# =====================================================

DEPLOY_MODE_FILE="/etc/redvel/.deploy-mode"

if [ -f "$DEPLOY_MODE_FILE" ]; then
    log_info "📄 Leyendo configuración de $DEPLOY_MODE_FILE"
    
    # Leer variables del archivo ignorando comentarios
    FILE_DEPLOY_MODE=$(grep "^DEPLOY_MODE=" "$DEPLOY_MODE_FILE" | cut -d '=' -f2)
    FILE_FIRST_INSTALL=$(grep "^PRIMERA_INSTALACION=" "$DEPLOY_MODE_FILE" | cut -d '=' -f2)
    
    if [ -n "$FILE_DEPLOY_MODE" ]; then
        DEPLOY_MODE="$FILE_DEPLOY_MODE"
    fi
    
    if [ -n "$FILE_FIRST_INSTALL" ]; then
        PRIMERA_INSTALACION="$FILE_FIRST_INSTALL"
    fi
else
    log_warning "⚠️ Archivo .deploy-mode no encontrado en $DEPLOY_MODE_FILE"
fi

if [ ! -f ".env" ]; then
    DEPLOY_MODE="${DEPLOY_MODE:-production}"
    log_info "📄 Archivo .env no existe, creando desde template..."
    
    if [ "$DEPLOY_MODE" = "development" ] && [ -f ".env.developer" ]; then
        log_info "📄 Usando .env.developer"
        cp .env.developer .env
    elif [ "$DEPLOY_MODE" = "production" ] && [ -f ".env.production" ]; then
        log_info "📄 Usando .env.production"
        cp .env.production .env
    elif [ -f ".env.production" ]; then
        log_info "📄 Usando .env.production (fallback)"
        cp .env.production .env
    elif [ -f ".env.example" ]; then
        log_warning "⚠️  Usando .env.example (configuración por defecto)"
        cp .env.example .env
    else
        log_error "❌ No se encontró ningún archivo .env, .env.production, .env.developer o .env.example"
        log_error "   El contenedor no puede continuar sin un archivo .env"
        exit 1
    fi
    
    # Cargar variables desde el .env recién creado
    set -a
    . ./.env
    set +a
else
    log_info "✅ Archivo .env existe"
fi

# Generar Key si falta
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    if ! grep -q "^APP_KEY=" .env || [ "$(grep "^APP_KEY=" .env | cut -d '=' -f2)" = "" ]; then
        log_info "🔑 Generando APP_KEY..."
        NEW_KEY="base64:$(openssl rand -base64 32)"
        echo "APP_KEY=$NEW_KEY" >> .env
        export APP_KEY="$NEW_KEY"
    fi
fi

if [ "$ROLE" = "app" ]; then
    # =====================================================
    # MIGRACIONES Y SEEDS (solo contenedor app)
    # =====================================================

    # Verificar instalación inicial
    if [ "$PRIMERA_INSTALACION" = "true" ]; then
        log_section "PRIMERA INSTALACIÓN DETECTADA"
        
        # Revisar si hay tablas
        TABLES_EXIST=$($MYSQL_CMD -h"$DB_HOST" -P"${DB_PORT:-3306}" -u"$DB_USERNAME" -p"$DB_PASSWORD" \
            $SSL_ARGS -D"$DB_DATABASE" -e "SHOW TABLES LIKE 'migrations';" 2>/dev/null | wc -l)
            
        if [ "$TABLES_EXIST" -le 1 ]; then
            log_info "📦 Ejecutando migraciones..."
            run_artisan "migrate --force"
            
            log_info "🌱 Ejecutando seeders..."
            run_artisan "db:seed --force" || log_warning "Error en seeders, continuando..."

            log_info "📝 Registrando instalación en base de datos..."
            # Insertar registro de instalación para evitar redirección a /install
            $MYSQL_CMD -h"$DB_HOST" -P"${DB_PORT:-3306}" -u"$DB_USERNAME" -p"$DB_PASSWORD" \
                 $SSL_ARGS -D"$DB_DATABASE" \
                 -e "INSERT INTO instalacion (estado_instalacion) VALUES (1);" || log_warning "No se pudo registrar la instalación en la tabla 'instalacion'."
        else
            log_warning "Tablas ya existen, saltando migración inicial."
        fi
    else
        log_info "🔄 Modo Actualización: Ejecutando migraciones pendientes..."
        run_artisan "migrate --force" true
    fi

    # =====================================================
    # OPTIMIZACIÓN Y LINK (solo contenedor app)
    # =====================================================

    log_info "🔗 Configurando Storage Link..."
    if [ ! -L "public/storage" ]; then
        rm -rf public/storage
        run_artisan "storage:link" true
    fi

    log_info "⚡ Limpiando y Cacheando Configuración..."
    run_artisan "optimize:clear" true

    if [ "$APP_ENV" = "production" ]; then
        log_info "⚡ Optimizando para Producción..."
        run_artisan "config:cache" true
        run_artisan "route:cache" true
        run_artisan "view:cache" true
        run_artisan "event:cache" true
    fi

    # =====================================================
    # GENERACIÓN DE DOCUMENTACIÓN API (SOLO EN DESARROLLO)
    # =====================================================

    if [ "$DEPLOY_MODE" = "development" ] || [ "$APP_ENV" = "local" ]; then
        log_info "📚 Generando documentación API (Scribe)..."
        run_artisan "scribe:generate" true
        if [ $? -eq 0 ]; then
            log_success "Documentación API generada exitosamente"
        else
            log_warning "No se pudo generar la documentación API (puede ser normal si no hay rutas configuradas)"
        fi
    fi
else
    log_info "⏭️  Saltando migraciones/optimizaciones (rol: $ROLE)"
fi

log_section "REDVEL FRAMEWORK LISTO"
log_info "🌐 URL: $APP_URL"
log_info "🚀 Iniciando servicios (Nginx + PHP-FPM)..."

# Asegurar que los servicios se inicien correctamente
# Verificar que Nginx puede iniciar
log_info "🔍 Verificando configuración de Nginx..."
if nginx -t 2>/dev/null; then
    log_success "Configuración de Nginx OK"
else
    log_warning "Advertencia en configuración de Nginx (continuando de todas formas)"
    nginx -t || true
fi

# Verificar que PHP-FPM puede iniciar
log_info "🔍 Verificando configuración de PHP-FPM..."
if php-fpm -t 2>/dev/null; then
    log_success "Configuración de PHP-FPM OK"
else
    log_warning "Advertencia en configuración de PHP-FPM (continuando de todas formas)"
    php-fpm -t || true
fi

# Asegurar permisos correctos
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# Ejecutar el comando pasado (normalmente supervisord)
# Esto debe ser la última línea y usar exec para reemplazar el proceso
log_info "▶️  Ejecutando: $@"
log_info "📝 Los logs de Nginx y PHP-FPM aparecerán a continuación..."
log_info "💡 Si no ves logs, verifica con: docker logs -f redvel-app-prod"
echo ""

# Ejecutar supervisord que manejará Nginx y PHP-FPM
exec "$@"
