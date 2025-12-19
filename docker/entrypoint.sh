#!/bin/sh
set -e

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
# ESPERAR SERVICIOS (BD y Redis)
# =====================================================

log_info "⏳ Esperando a que MySQL esté listo..."
log_info "   Host: $DB_HOST | BD: $DB_DATABASE"

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
        log_error "MySQL no responde."
        log_error "Detalles: $OUTPUT"
        exit 1
    fi
    sleep 5
done

log_info "⏳ Esperando a que Redis esté listo..."
attempt=0
while true; do
    if redis-cli -h "$REDIS_HOST" -p "${REDIS_PORT:-6379}" --no-auth-warning ping 2>/dev/null | grep -q PONG; then
        log_success "Redis está listo!"
        break
    fi
    attempt=$((attempt + 1))
    if [ $attempt -ge 30 ]; then
        log_error "Redis no responde"
        exit 1
    fi
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
    if [ "$DEPLOY_MODE" = "development" ] && [ -f ".env.developer" ]; then
        log_info "📄 Usando .env.developer"
        cp .env.developer .env
    elif [ "$DEPLOY_MODE" = "production" ] && [ -f ".env.production" ]; then
        log_info "📄 Usando .env.production"
        cp .env.production .env
    elif [ -f ".env.production" ]; then
        cp .env.production .env
    elif [ -f ".env.example" ]; then
        cp .env.example .env
    fi
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

# =====================================================
# MIGRACIONES Y SEEDS
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
    else
        log_warning "Tablas ya existen, saltando migración inicial."
    fi
else
    log_info "🔄 Modo Actualización: Ejecutando migraciones pendientes..."
    run_artisan "migrate --force" true
fi

# =====================================================
# OPTIMIZACIÓN Y LINK
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

log_section "REDVEL FRAMEWORK LISTO"
log_info "🌐 URL: $APP_URL"

exec "$@"
