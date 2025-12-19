-- =====================================================
-- CONFIGURACIÓN INICIAL DE MYSQL PARA PRODUCCIÓN (REDVEL)
-- Este archivo se ejecuta automáticamente al iniciar el contenedor
-- =====================================================

-- Configurar timezone
SET GLOBAL time_zone = '-05:00';

-- Optimizaciones para producción
SET GLOBAL innodb_file_per_table = 1;
SET GLOBAL innodb_stats_on_metadata = 0;
SET GLOBAL max_connections = 200;
SET GLOBAL general_log = 0;
SET GLOBAL slow_query_log = 1;
SET GLOBAL long_query_time = 1;

-- Crear base de datos de producción
CREATE DATABASE IF NOT EXISTS redvel_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear usuario root remoto para administración
-- La contraseña debe coincidir con MYSQL_ROOT_PASSWORD en docker-compose
CREATE USER IF NOT EXISTS 'root'@'%' IDENTIFIED BY 'RedVelRootSecure2025!';
ALTER USER 'root'@'%' IDENTIFIED BY 'RedVelRootSecure2025!';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;

-- Aplicar cambios
FLUSH PRIVILEGES;

-- Mostrar información de conexión
SELECT 'Base de datos de producción creada: redvel_prod' AS 'Estado';
SELECT 'Usuario: root' AS 'Credenciales';
SELECT 'Puerto externo: 3306' AS 'Conexión Externa';

