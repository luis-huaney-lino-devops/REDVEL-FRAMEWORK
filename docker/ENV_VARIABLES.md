# Variables de Entorno Requeridas

## Archivos .env Necesarios

El proyecto requiere dos archivos de configuración de entorno:

1. **RedBack/.env.developer** - Para modo desarrollo
2. **RedBack/.env.production** - Para modo producción

## Variables Críticas (REQUERIDAS)

Estas variables DEBEN estar presentes en ambos archivos .env:

```env
# Base de Datos MySQL
DB_CONNECTION=mysql
DB_HOST=mysql-dev          # Para desarrollo: mysql-dev | Para producción: mysql-prod
DB_PORT=3306
DB_DATABASE=redvel_dev     # Para desarrollo: redvel_dev | Para producción: redvel_prod
DB_USERNAME=root
DB_PASSWORD=RedVelRootDev2025!  # Debe coincidir con MYSQL_ROOT_PASSWORD en docker-compose

# Redis
REDIS_HOST=redis-dev       # Para desarrollo: redis-dev | Para producción: redis-prod
REDIS_PORT=6379
REDIS_PASSWORD=null

# Aplicación
APP_NAME=REDVEL
APP_ENV=local              # Para desarrollo: local | Para producción: production
APP_KEY=                   # Se genera automáticamente si está vacío
APP_DEBUG=true             # Para desarrollo: true | Para producción: false
APP_URL=http://localhost:9091

# JWT
JWT_SECRET=                # Se genera con: php artisan jwt:secret
JWT_TTL=60

# API Documentation
API_DOC=true               # true para habilitar documentación, false para deshabilitar
```

## Variables Importantes (RECOMENDADAS)

```env
# Cache
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Mail (opcional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@redvel.dev
MAIL_FROM_NAME="${APP_NAME}"
```

## Configuración por Modo

### Desarrollo (.env.developer)

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:9091

DB_HOST=mysql-dev
DB_DATABASE=redvel_dev
DB_USERNAME=root
DB_PASSWORD=RedVelRootDev2025!

REDIS_HOST=redis-dev

API_DOC=true
```

### Producción (.env.production)

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=http://168.231.90.23:9091

DB_HOST=mysql-prod
DB_DATABASE=redvel_prod
DB_USERNAME=root
DB_PASSWORD=RedVelRootSecure2025!

REDIS_HOST=redis-prod

API_DOC=false
```

## Nombres de Servicios Docker

Los valores de `DB_HOST` y `REDIS_HOST` deben coincidir con los nombres de los servicios en docker-compose:

### Desarrollo (docker-compose.dev.yml)
- MySQL: `mysql-dev`
- Redis: `redis-dev`

### Producción (docker-compose.prod.yml)
- MySQL: `mysql-prod`
- Redis: `redis-prod`

## Verificación

Ejecuta el script de verificación:

```bash
./docker/verify-env.sh
```

Este script verificará que:
- Los archivos .env existen
- Las variables críticas están presentes
- Los valores son correctos

## Solución de Problemas

### Error: "DB_HOST no está definido"

**Causa**: La variable DB_HOST no está en el archivo .env

**Solución**: Añade `DB_HOST=mysql-dev` (o `mysql-prod` para producción) a tu archivo .env

### Error: "MySQL no responde"

**Causa**: El valor de DB_HOST no coincide con el nombre del servicio Docker

**Solución**: Verifica que:
- En desarrollo: `DB_HOST=mysql-dev`
- En producción: `DB_HOST=mysql-prod`

### Error: "Access denied for user"

**Causa**: La contraseña en .env no coincide con MYSQL_ROOT_PASSWORD en docker-compose

**Solución**: Verifica que `DB_PASSWORD` en .env coincida con `MYSQL_ROOT_PASSWORD` en docker-compose

### Error: "Redis no responde"

**Causa**: El valor de REDIS_HOST no coincide con el nombre del servicio Docker

**Solución**: Verifica que:
- En desarrollo: `REDIS_HOST=redis-dev`
- En producción: `REDIS_HOST=redis-prod`

## Generar APP_KEY y JWT_SECRET

Si estos valores están vacíos, se generan automáticamente en el entrypoint.sh. Pero puedes generarlos manualmente:

```bash
# Dentro del contenedor
docker exec redvel-app-prod php artisan key:generate
docker exec redvel-app-prod php artisan jwt:secret
```
