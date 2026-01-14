#!/bin/sh
# Script de diagnóstico para problemas de conexión MySQL en Docker

echo "=========================================="
echo "DIAGNÓSTICO DE CONEXIÓN MYSQL"
echo "=========================================="
echo ""

# Detectar modo de despliegue
if [ -f ".deploy-mode" ]; then
    DEPLOY_MODE=$(grep "^DEPLOY_MODE=" .deploy-mode | cut -d '=' -f2)
    echo "📋 Modo de despliegue detectado: ${DEPLOY_MODE:-NO DEFINIDO}"
else
    echo "⚠️  Archivo .deploy-mode no encontrado"
    DEPLOY_MODE="development"
fi

if [ "$DEPLOY_MODE" = "development" ]; then
    MYSQL_SERVICE="mysql-dev"
    MYSQL_CONTAINER="redvel-mysql-dev"
    APP_CONTAINER="redvel-app-dev"
    NETWORK="redvel-network-dev"
    COMPOSE_FILE="docker-compose.dev.yml"
else
    MYSQL_SERVICE="mysql-prod"
    MYSQL_CONTAINER="redvel-mysql-prod"
    APP_CONTAINER="redvel-app-prod"
    NETWORK="redvel-network-prod"
    COMPOSE_FILE="docker-compose.prod.yml"
fi

echo "🔍 Configuración detectada:"
echo "   Servicio MySQL: $MYSQL_SERVICE"
echo "   Contenedor MySQL: $MYSQL_CONTAINER"
echo "   Contenedor App: $APP_CONTAINER"
echo "   Red: $NETWORK"
echo "   Archivo Compose: $COMPOSE_FILE"
echo ""

# 1. Verificar contenedor MySQL
echo "1. Verificando contenedor MySQL..."
if docker ps -a | grep -q "$MYSQL_CONTAINER"; then
    if docker ps | grep -q "$MYSQL_CONTAINER"; then
        echo "✅ Contenedor MySQL está corriendo"
        docker ps | grep "$MYSQL_CONTAINER"
    else
        echo "❌ Contenedor MySQL existe pero NO está corriendo"
        echo "   Estado:"
        docker ps -a | grep "$MYSQL_CONTAINER"
        echo ""
        echo "💡 Intenta iniciarlo con:"
        echo "   docker-compose -f $COMPOSE_FILE up -d $MYSQL_SERVICE"
    fi
else
    echo "❌ Contenedor MySQL NO existe"
    echo "💡 Intenta crearlo con:"
    echo "   docker-compose -f $COMPOSE_FILE up -d $MYSQL_SERVICE"
fi
echo ""

# 2. Verificar contenedor App
echo "2. Verificando contenedor App..."
if docker ps -a | grep -q "$APP_CONTAINER"; then
    if docker ps | grep -q "$APP_CONTAINER"; then
        echo "✅ Contenedor App está corriendo"
        docker ps | grep "$APP_CONTAINER"
    else
        echo "⚠️  Contenedor App existe pero NO está corriendo"
        docker ps -a | grep "$APP_CONTAINER"
    fi
else
    echo "⚠️  Contenedor App NO existe"
fi
echo ""

# 3. Verificar red Docker
echo "3. Verificando red Docker..."
if docker network ls | grep -q "$NETWORK"; then
    echo "✅ Red $NETWORK existe"
    echo "   Contenedores conectados a la red:"
    docker network inspect "$NETWORK" --format '{{range .Containers}}{{.Name}} {{end}}' 2>/dev/null || echo "   (No se pudo obtener información)"
    
    # Verificar si MySQL está en la red
    if docker network inspect "$NETWORK" 2>/dev/null | grep -q "$MYSQL_CONTAINER"; then
        echo "✅ Contenedor MySQL está en la red $NETWORK"
    else
        echo "❌ Contenedor MySQL NO está en la red $NETWORK"
        echo "💡 Intenta reconectar con:"
        echo "   docker network connect $NETWORK $MYSQL_CONTAINER"
    fi
    
    # Verificar si App está en la red
    if docker network inspect "$NETWORK" 2>/dev/null | grep -q "$APP_CONTAINER"; then
        echo "✅ Contenedor App está en la red $NETWORK"
    else
        echo "⚠️  Contenedor App NO está en la red $NETWORK"
    fi
else
    echo "❌ Red $NETWORK NO existe"
    echo "💡 Intenta crearla con:"
    echo "   docker-compose -f $COMPOSE_FILE up -d"
fi
echo ""

# 4. Verificar resolución DNS desde el contenedor App
echo "4. Verificando resolución DNS desde contenedor App..."
if docker ps | grep -q "$APP_CONTAINER"; then
    echo "   Intentando resolver $MYSQL_SERVICE desde $APP_CONTAINER..."
    DNS_RESULT=$(docker exec "$APP_CONTAINER" getent hosts "$MYSQL_SERVICE" 2>&1)
    if [ $? -eq 0 ]; then
        echo "✅ DNS resuelto correctamente:"
        echo "   $DNS_RESULT"
    else
        echo "❌ DNS NO se puede resolver"
        echo "   Error: $DNS_RESULT"
        echo ""
        echo "   Verificando conectividad de red..."
        if docker exec "$APP_CONTAINER" ping -c 1 "$MYSQL_SERVICE" >/dev/null 2>&1; then
            echo "✅ Ping exitoso a $MYSQL_SERVICE"
        else
            echo "❌ Ping falló a $MYSQL_SERVICE"
        fi
    fi
else
    echo "⚠️  Contenedor App no está corriendo, no se puede verificar DNS"
fi
echo ""

# 5. Verificar logs de MySQL
echo "5. Últimos logs del contenedor MySQL (últimas 10 líneas):"
docker logs --tail 10 "$MYSQL_CONTAINER" 2>&1 || echo "   No se pudieron obtener logs"
echo ""

# 6. Verificar healthcheck de MySQL
echo "6. Verificando healthcheck de MySQL..."
if docker ps | grep -q "$MYSQL_CONTAINER"; then
    HEALTH=$(docker inspect --format='{{.State.Health.Status}}' "$MYSQL_CONTAINER" 2>/dev/null)
    if [ -n "$HEALTH" ]; then
        echo "   Estado de health: $HEALTH"
        if [ "$HEALTH" = "healthy" ]; then
            echo "✅ MySQL está saludable"
        elif [ "$HEALTH" = "unhealthy" ]; then
            echo "❌ MySQL está NO saludable"
            echo "   Revisa los logs con: docker logs $MYSQL_CONTAINER"
        else
            echo "⚠️  MySQL está en estado: $HEALTH"
        fi
    else
        echo "⚠️  No se pudo obtener el estado de health"
    fi
else
    echo "⚠️  Contenedor MySQL no está corriendo"
fi
echo ""

# 7. Verificar variables de entorno
echo "7. Verificando variables de entorno en contenedor App..."
if docker ps | grep -q "$APP_CONTAINER"; then
    DB_HOST=$(docker exec "$APP_CONTAINER" printenv DB_HOST 2>/dev/null)
    DB_DATABASE=$(docker exec "$APP_CONTAINER" printenv DB_DATABASE 2>/dev/null)
    DB_USERNAME=$(docker exec "$APP_CONTAINER" printenv DB_USERNAME 2>/dev/null)
    
    echo "   DB_HOST: ${DB_HOST:-NO DEFINIDO}"
    echo "   DB_DATABASE: ${DB_DATABASE:-NO DEFINIDO}"
    echo "   DB_USERNAME: ${DB_USERNAME:-NO DEFINIDO}"
    
    if [ -z "$DB_HOST" ]; then
        echo "❌ DB_HOST no está definido en el contenedor"
    elif [ "$DB_HOST" != "$MYSQL_SERVICE" ]; then
        echo "⚠️  DB_HOST ($DB_HOST) no coincide con el servicio MySQL ($MYSQL_SERVICE)"
        echo "💡 Debería ser: DB_HOST=$MYSQL_SERVICE"
    else
        echo "✅ DB_HOST coincide con el servicio MySQL"
    fi
else
    echo "⚠️  Contenedor App no está corriendo"
fi
echo ""

# 8. Recomendaciones
echo "=========================================="
echo "RECOMENDACIONES:"
echo "=========================================="
echo ""
echo "Si el contenedor MySQL no está corriendo:"
echo "   docker-compose -f $COMPOSE_FILE up -d $MYSQL_SERVICE"
echo ""
echo "Si los contenedores no están en la misma red:"
echo "   docker-compose -f $COMPOSE_FILE down"
echo "   docker-compose -f $COMPOSE_FILE up -d"
echo ""
echo "Para ver logs en tiempo real:"
echo "   docker logs -f $APP_CONTAINER"
echo "   docker logs -f $MYSQL_CONTAINER"
echo ""
echo "Para reiniciar todo:"
echo "   docker-compose -f $COMPOSE_FILE restart"
echo ""
echo "Para verificar la red manualmente:"
echo "   docker network inspect $NETWORK"
echo ""
