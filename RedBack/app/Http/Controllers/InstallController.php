<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Exception;

class InstallController extends Controller
{
    public function index()
    {
        return view('install');
    }

    public function install()
    {
        $steps = [];
        $currentStep = 0;

        try {
            // Paso 1: Verificar conexión a la base de datos
            $currentStep = 1;
            $steps[] = [
                'step' => $currentStep,
                'name' => 'Verificación de conexión a base de datos',
                'status' => 'processing'
            ];

            try {
                DB::connection()->getPdo();
                $steps[count($steps) - 1]['status'] = 'success';
                $steps[count($steps) - 1]['message'] = 'Conexión a la base de datos establecida correctamente';
            } catch (\Exception $e) {
                throw new Exception('Error de conexión a la base de datos: ' . $e->getMessage(), 0, $e);
            }

            // Paso 2: Ejecutar migraciones
            $currentStep = 2;
            $steps[] = [
                'step' => $currentStep,
                'name' => 'Ejecutando migraciones de base de datos',
                'status' => 'processing'
            ];

            try {
                $output = Artisan::call('migrate', ['--force' => true]);
                $outputText = Artisan::output();

                if ($output !== 0 && !empty($outputText)) {
                    throw new Exception('Error en migraciones: ' . $outputText);
                }

                $steps[count($steps) - 1]['status'] = 'success';
                $steps[count($steps) - 1]['message'] = 'Migraciones ejecutadas correctamente';
            } catch (\Exception $e) {
                $errorDetails = $this->getErrorDetails($e);
                $steps[count($steps) - 1]['status'] = 'error';
                $steps[count($steps) - 1]['message'] = $errorDetails['message'];
                $steps[count($steps) - 1]['error'] = $errorDetails;
                throw $e;
            }

            // Paso 3: Ejecutar seeders
            $currentStep = 3;
            $steps[] = [
                'step' => $currentStep,
                'name' => 'Ejecutando seeders (datos iniciales)',
                'status' => 'processing'
            ];

            try {
                $output = Artisan::call('db:seed', ['--force' => true]);
                $outputText = Artisan::output();

                if ($output !== 0 && !empty($outputText)) {
                    throw new Exception('Error en seeders: ' . $outputText);
                }

                $steps[count($steps) - 1]['status'] = 'success';
                $steps[count($steps) - 1]['message'] = 'Seeders ejecutados correctamente';
            } catch (\Exception $e) {
                $errorDetails = $this->getErrorDetails($e);
                $steps[count($steps) - 1]['status'] = 'error';
                $steps[count($steps) - 1]['message'] = $errorDetails['message'];
                $steps[count($steps) - 1]['error'] = $errorDetails;
                throw $e;
            }

            // Paso 4: Crear enlace simbólico de storage
            $currentStep = 4;
            $steps[] = [
                'step' => $currentStep,
                'name' => 'Creando enlace simbólico de storage',
                'status' => 'processing'
            ];

            try {
                Artisan::call('storage:link');
                $steps[count($steps) - 1]['status'] = 'success';
                $steps[count($steps) - 1]['message'] = 'Enlace simbólico creado correctamente';
            } catch (\Exception $e) {
                $errorDetails = $this->getErrorDetails($e);
                $steps[count($steps) - 1]['status'] = 'error';
                $steps[count($steps) - 1]['message'] = $errorDetails['message'];
                $steps[count($steps) - 1]['error'] = $errorDetails;
                throw $e;
            }

            // Paso 5: Marcar instalación como completada
            $currentStep = 5;
            $steps[] = [
                'step' => $currentStep,
                'name' => 'Finalizando instalación',
                'status' => 'processing'
            ];

            try {
                if (Schema::hasTable('instalacion')) {
                    DB::table('instalacion')->insert([
                        'estado_instalacion' => true,
                    ]);
                } else {
                    throw new Exception('La tabla instalacion no existe. Las migraciones no se ejecutaron correctamente.');
                }

                $steps[count($steps) - 1]['status'] = 'success';
                $steps[count($steps) - 1]['message'] = 'Instalación completada correctamente';
            } catch (\Exception $e) {
                $errorDetails = $this->getErrorDetails($e);
                $steps[count($steps) - 1]['status'] = 'error';
                $steps[count($steps) - 1]['message'] = $errorDetails['message'];
                $steps[count($steps) - 1]['error'] = $errorDetails;
                throw $e;
            }

            return response()->json([
                'success' => true,
                'message' => 'Instalación completada exitosamente',
                'steps' => $steps
            ], 200);
        } catch (\Throwable $th) {
            // Registrar el error completo en el log
            Log::error('Error en la instalación (Paso ' . $currentStep . '): ' . $th->getMessage());
            Log::error('Archivo: ' . $th->getFile() . ' Línea: ' . $th->getLine());
            Log::error('Stack trace: ' . $th->getTraceAsString());

            $errorDetails = $this->getErrorDetails($th);

            // Actualizar el último paso con error si no se actualizó
            if (!empty($steps) && end($steps)['status'] !== 'error') {
                $steps[count($steps) - 1]['status'] = 'error';
                $steps[count($steps) - 1]['message'] = $errorDetails['message'];
                $steps[count($steps) - 1]['error'] = $errorDetails;
            }

            return response()->json([
                'success' => false,
                'message' => 'Error en la instalación',
                'step' => $currentStep,
                'error' => $errorDetails,
                'steps' => $steps
            ], 500);
        }
    }

    /**
     * Obtiene detalles detallados del error
     */
    private function getErrorDetails(\Throwable $th): array
    {
        $errorType = get_class($th);
        $file = $th->getFile();
        $line = $th->getLine();
        $message = $th->getMessage();
        $code = $th->getCode();

        // Determinar el tipo de error
        $errorCategory = 'Desconocido';
        if (strpos($errorType, 'PDOException') !== false || strpos($errorType, 'QueryException') !== false) {
            $errorCategory = 'Error de Base de Datos';
        } elseif (strpos($errorType, 'MigrationException') !== false) {
            $errorCategory = 'Error de Migración';
        } elseif (strpos($errorType, 'FileException') !== false || strpos($errorType, 'FilesystemException') !== false) {
            $errorCategory = 'Error de Archivos';
        } elseif (strpos($message, 'SQLSTATE') !== false || strpos($message, 'SQL') !== false) {
            $errorCategory = 'Error SQL';
        } elseif (strpos($message, 'syntax') !== false || strpos($message, 'parse') !== false) {
            $errorCategory = 'Error de Sintaxis';
        } elseif (strpos($message, 'typo') !== false || strpos($message, 'undefined') !== false || strpos($message, 'not found') !== false) {
            $errorCategory = 'Error de Tipeo/Variable';
        }

        // Obtener contexto del archivo si es posible
        $context = '';
        if (file_exists($file)) {
            $lines = file($file);
            $startLine = max(0, $line - 5);
            $endLine = min(count($lines), $line + 5);
            $contextLines = array_slice($lines, $startLine, $endLine - $startLine);
            $context = implode('', $contextLines);
        }

        return [
            'type' => $errorType,
            'category' => $errorCategory,
            'message' => $message,
            'file' => $file,
            'line' => $line,
            'code' => $code,
            'context' => $context,
            'trace' => $th->getTraceAsString()
        ];
    }

    /**
     * Verifica el estado de la instalación para determinar si se puede hacer rollback
     */
    public function checkStatus()
    {
        try {
            // Verificar conexión a la base de datos
            $hasConnection = false;
            try {
                DB::connection()->getPdo();
                $hasConnection = true;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => true,
                    'has_connection' => false,
                    'can_rollback' => false,
                    'tables_count' => 0,
                    'message' => 'No hay conexión a la base de datos'
                ], 200);
            }

            // Contar tablas en la base de datos
            $tables = DB::select('SHOW TABLES');
            $databaseName = DB::connection()->getDatabaseName();
            $tableKey = 'Tables_in_' . $databaseName;

            $tableNames = [];
            foreach ($tables as $table) {
                $tableNames[] = $table->$tableKey;
            }

            // Verificar si hay al menos una tabla (excluyendo migrations si es la única)
            $tablesCount = count($tableNames);
            $canRollback = $tablesCount > 0;

            // Verificar si existe el enlace simbólico de storage
            $hasStorageLink = is_link(public_path('storage'));

            return response()->json([
                'success' => true,
                'has_connection' => true,
                'can_rollback' => $canRollback,
                'tables_count' => $tablesCount,
                'tables' => $tableNames,
                'has_storage_link' => $hasStorageLink
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error al verificar estado: ' . $th->getMessage());

            return response()->json([
                'success' => false,
                'has_connection' => false,
                'can_rollback' => false,
                'message' => 'Error al verificar el estado: ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Realiza rollback de la instalación (borra todas las tablas)
     */
    public function rollback()
    {
        try {
            // Verificar conexión
            DB::connection()->getPdo();

            // Obtener todas las tablas
            $tables = DB::select('SHOW TABLES');
            $databaseName = DB::connection()->getDatabaseName();
            $tableKey = 'Tables_in_' . $databaseName;

            // Desactivar verificación de claves foráneas
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $droppedTables = [];
            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                try {
                    DB::statement("DROP TABLE IF EXISTS `{$tableName}`");
                    $droppedTables[] = $tableName;
                } catch (\Exception $e) {
                    Log::warning("No se pudo eliminar la tabla {$tableName}: " . $e->getMessage());
                }
            }

            // Reactivar verificación de claves foráneas
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            // Eliminar el enlace simbólico de storage si existe
            try {
                $storageLink = public_path('storage');
                if (is_link($storageLink)) {
                    unlink($storageLink);
                }
            } catch (\Exception $e) {
                Log::warning("No se pudo eliminar el enlace simbólico: " . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Rollback completado. Todas las tablas han sido eliminadas.',
                'dropped_tables' => $droppedTables,
                'count' => count($droppedTables)
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error en rollback: ' . $th->getMessage());
            Log::error('Stack trace: ' . $th->getTraceAsString());

            $errorDetails = $this->getErrorDetails($th);

            return response()->json([
                'success' => false,
                'message' => 'Error durante el rollback',
                'error' => $errorDetails
            ], 500);
        }
    }
}
