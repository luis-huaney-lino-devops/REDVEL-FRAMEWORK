#!/bin/sh
# Script para verificar que los archivos .env tienen las variables necesarias

echo "=========================================="
echo "VERIFICACIÓN DE ARCHIVOS .ENV"
echo "=========================================="
echo ""

check_env_file() {
    local file=$1
    local name=$2
    
    echo "Verificando $name ($file)..."
    
    if [ ! -f "$file" ]; then
        echo "❌ Archivo $file NO EXISTE"
        return 1
    fi
    
    echo "✅ Archivo existe"
    
    # Variables críticas requeridas
    local required_vars="DB_HOST DB_DATABASE DB_USERNAME DB_PASSWORD"
    local missing_vars=""
    
    for var in $required_vars; do
        if ! grep -q "^${var}=" "$file" 2>/dev/null; then
            missing_vars="$missing_vars $var"
        fi
    done
    
    if [ -n "$missing_vars" ]; then
        echo "⚠️  Variables faltantes:$missing_vars"
        return 1
    else
        echo "✅ Todas las variables críticas están presentes"
    fi
    
    # Mostrar valores (sin contraseña)
    echo "   DB_HOST: $(grep "^DB_HOST=" "$file" | cut -d '=' -f2)"
    echo "   DB_DATABASE: $(grep "^DB_DATABASE=" "$file" | cut -d '=' -f2)"
    echo "   DB_USERNAME: $(grep "^DB_USERNAME=" "$file" | cut -d '=' -f2)"
    echo "   DB_PASSWORD: $(if grep -q "^DB_PASSWORD=" "$file"; then echo "[DEFINIDO]"; else echo "[NO DEFINIDO]"; fi)"
    
    # Variables opcionales pero recomendadas
    if grep -q "^REDIS_HOST=" "$file"; then
        echo "   REDIS_HOST: $(grep "^REDIS_HOST=" "$file" | cut -d '=' -f2)"
    else
        echo "   REDIS_HOST: [NO DEFINIDO - se usará 'redis' por defecto]"
    fi
    
    if grep -q "^APP_KEY=" "$file"; then
        local key=$(grep "^APP_KEY=" "$file" | cut -d '=' -f2)
        if [ -z "$key" ] || [ "$key" = "" ]; then
            echo "   APP_KEY: [VACÍO - se generará automáticamente]"
        else
            echo "   APP_KEY: [DEFINIDO]"
        fi
    else
        echo "   APP_KEY: [NO DEFINIDO - se generará automáticamente]"
    fi
    
    echo ""
    return 0
}

# Verificar archivos
check_env_file "RedBack/.env.developer" ".env.developer"
check_env_file "RedBack/.env.production" ".env.production"

echo "=========================================="
echo "RECOMENDACIONES:"
echo "=========================================="
echo ""
echo "1. Asegúrate de que ambos archivos .env existan"
echo "2. Verifica que DB_HOST apunte al nombre del servicio de MySQL:"
echo "   - Desarrollo: mysql-dev"
echo "   - Producción: mysql-prod"
echo "3. Verifica que REDIS_HOST apunte al nombre del servicio de Redis:"
echo "   - Desarrollo: redis-dev"
echo "   - Producción: redis-prod"
echo "4. Asegúrate de que las contraseñas coincidan con las configuradas en docker-compose"
echo ""
