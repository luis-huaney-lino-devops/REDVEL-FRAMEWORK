#!/bin/sh
# Script para verificar el estado del backend

echo "=========================================="
echo "VERIFICACIÓN DEL BACKEND REDVEL"
echo "=========================================="
echo ""

echo "1. Verificando contenedor..."
if docker ps | grep -q redvel-app; then
    echo "✅ Contenedor está corriendo"
    docker ps | grep redvel-app
else
    echo "❌ Contenedor NO está corriendo"
    echo "Intenta: docker-compose up -d app"
    exit 1
fi

echo ""
echo "2. Verificando logs del contenedor..."
docker logs --tail 50 redvel-app-prod 2>&1 | tail -20

echo ""
echo "3. Verificando puerto 9091..."
if netstat -tuln 2>/dev/null | grep -q ":9091" || ss -tuln 2>/dev/null | grep -q ":9091"; then
    echo "✅ Puerto 9091 está escuchando"
else
    echo "⚠️  Puerto 9091 no está escuchando (puede ser normal si Docker maneja el puerto)"
fi

echo ""
echo "4. Verificando conectividad desde el contenedor..."
docker exec redvel-app-prod curl -f http://localhost/health 2>/dev/null && echo "✅ Health check OK" || echo "❌ Health check FALLÓ"

echo ""
echo "5. Verificando servicios dentro del contenedor..."
docker exec redvel-app-prod ps aux | grep -E "(nginx|php-fpm|supervisord)" | head -5

echo ""
echo "6. Verificando configuración de Nginx..."
docker exec redvel-app-prod nginx -t 2>&1

echo ""
echo "7. Verificando firewall (si es root)..."
if [ "$(id -u)" = "0" ]; then
    if command -v ufw >/dev/null 2>&1; then
        ufw status | grep 9091 || echo "⚠️  Puerto 9091 no encontrado en UFW"
    elif command -v firewall-cmd >/dev/null 2>&1; then
        firewall-cmd --list-ports | grep 9091 || echo "⚠️  Puerto 9091 no encontrado en firewalld"
    fi
else
    echo "ℹ️  Ejecuta como root para verificar firewall"
fi

echo ""
echo "=========================================="
echo "Para ver logs en tiempo real:"
echo "docker logs -f redvel-app-prod"
echo ""
echo "Para reiniciar el contenedor:"
echo "docker-compose restart app"
echo "=========================================="
