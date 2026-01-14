#!/bin/sh
# Script para ver logs del backend de forma clara

CONTAINER_NAME=""

# Detectar qué contenedor está corriendo
if docker ps | grep -q "redvel-app-prod"; then
    CONTAINER_NAME="redvel-app-prod"
    echo "📦 Modo: PRODUCCIÓN"
elif docker ps | grep -q "redvel-app-dev"; then
    CONTAINER_NAME="redvel-app-dev"
    echo "📦 Modo: DESARROLLO"
else
    echo "❌ No se encontró ningún contenedor de backend corriendo"
    echo ""
    echo "Contenedores disponibles:"
    docker ps -a | grep redvel
    exit 1
fi

echo "Contenedor: $CONTAINER_NAME"
echo "=========================================="
echo ""

# Opciones
case "${1:-all}" in
    "entrypoint"|"init")
        echo "📋 Logs del Entrypoint (inicialización):"
        echo "=========================================="
        docker logs "$CONTAINER_NAME" 2>&1 | grep -E "(INICIANDO|Verificando|Esperando|MySQL|Redis|Configurando|Ejecutando|REDVEL FRAMEWORK LISTO)" | tail -50
        ;;
    "nginx")
        echo "📋 Logs de Nginx:"
        echo "=========================================="
        docker exec "$CONTAINER_NAME" tail -50 /var/log/nginx/error.log 2>/dev/null || echo "No se pueden leer logs de Nginx"
        ;;
    "php")
        echo "📋 Logs de PHP-FPM:"
        echo "=========================================="
        docker exec "$CONTAINER_NAME" tail -50 /var/log/php-fpm.log 2>/dev/null || docker logs "$CONTAINER_NAME" 2>&1 | grep -i "php" | tail -50
        ;;
    "laravel")
        echo "📋 Logs de Laravel:"
        echo "=========================================="
        docker exec "$CONTAINER_NAME" tail -50 /var/www/html/storage/logs/laravel.log 2>/dev/null || echo "No se encontró archivo de log de Laravel"
        ;;
    "supervisor")
        echo "📋 Logs de Supervisord:"
        echo "=========================================="
        docker exec "$CONTAINER_NAME" tail -50 /var/log/supervisor/supervisord.log 2>/dev/null || echo "No se pueden leer logs de Supervisord"
        ;;
    "all"|*)
        echo "📋 Todos los logs (últimas 100 líneas):"
        echo "=========================================="
        docker logs --tail 100 "$CONTAINER_NAME" 2>&1
        ;;
esac

echo ""
echo "=========================================="
echo "Para ver logs en tiempo real:"
echo "  docker logs -f $CONTAINER_NAME"
echo ""
echo "Para ver logs específicos:"
echo "  ./docker/view-logs.sh entrypoint  # Logs de inicialización"
echo "  ./docker/view-logs.sh nginx       # Logs de Nginx"
echo "  ./docker/view-logs.sh php         # Logs de PHP-FPM"
echo "  ./docker/view-logs.sh laravel     # Logs de Laravel"
echo "  ./docker/view-logs.sh supervisor  # Logs de Supervisord"
echo "=========================================="
