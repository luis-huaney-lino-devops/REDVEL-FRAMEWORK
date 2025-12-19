-- Configuración inicial de MySQL para RedVel Framework
-- Este archivo se ejecuta automáticamente al iniciar el contenedor

-- Configurar timezone
SET GLOBAL time_zone = '-05:00';

-- Optimizaciones
SET GLOBAL innodb_file_per_table = 1;
SET GLOBAL innodb_stats_on_metadata = 0;

-- Crear base de datos si no existe (por seguridad)
CREATE DATABASE IF NOT EXISTS redvel_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- El root se configura por variable de entorno, aquí solo grants extra si fueran necesarios
FLUSH PRIVILEGES;
