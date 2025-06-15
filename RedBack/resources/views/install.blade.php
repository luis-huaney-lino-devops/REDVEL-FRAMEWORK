<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalador RedVel Framework</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Token CSRF para Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --font-sans: "Instrument Sans", ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            --font-mono: "Geist Mono", monospace;
            --color-red-500: oklch(63.7% 0.237 25.331);
            --font-sans--font-feature-settings: '"ss02", "ss05", "ss09"';
        }

        .titulo {
            color: var(--color-red-500);
            font-family: var(--font-sans);
            font-feature-settings: var(--font-sans--font-feature-settings);
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
            }

            50% {
                box-shadow: 0 0 40px rgba(239, 68, 68, 0.6);
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes typing {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        @keyframes blink {

            0%,
            50% {
                opacity: 1;
            }

            51%,
            100% {
                opacity: 0;
            }
        }

        @keyframes progress-flow {
            0% {
                background-position: 0% 0%;
            }

            100% {
                background-position: 100% 0%;
            }
        }

        .gradient-bg {
            background: linear-gradient(-45deg, #1f2937, #111827, #0f172a, #1e293b);
            background-size: 400% 400%;
            animation: gradient-shift 8s ease infinite;
        }

        .terminal {
            background: rgba(17, 24, 39, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(239, 68, 68, 0.2);
            font-family: 'Courier New', monospace;
        }

        .terminal-line {
            animation: slide-up 0.3s ease-out;
        }

        .progress-bar-animated {
            background: linear-gradient(90deg, #ef4444, #dc2626, #b91c1c, #ef4444);
            background-size: 200% 100%;
            animation: progress-flow 2s linear infinite;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            animation: pulse-glow 2s ease-in-out infinite;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(239, 68, 68, 0.4);
        }

        .btn-primary:disabled {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            animation: none;
            box-shadow: none;
            transform: none;
        }

        .logo-container {
            background: rgba(31, 41, 55, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .cursor-blink::after {
            content: '_';
            animation: blink 1s infinite;
        }

        .spark {
            position: absolute;
            width: 2px;
            height: 2px;
            background: #ef4444;
            border-radius: 50%;
            opacity: 0.6;
            animation: spark-float 4s ease-in-out infinite;
        }

        @keyframes spark-float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-15px) rotate(120deg);
            }

            66% {
                transform: translateY(10px) rotate(240deg);
            }
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Partículas flotantes de fondo -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="spark" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
        <div class="spark" style="top: 40%; right: 15%; animation-delay: 1s;"></div>
        <div class="spark" style="bottom: 30%; left: 20%; animation-delay: 2s;"></div>
        <div class="spark" style="top: 60%; right: 25%; animation-delay: 3s;"></div>
        <div class="spark" style="bottom: 15%; right: 10%; animation-delay: 4s;"></div>
    </div>

    <div class="max-w-4xl w-full mx-auto">
        <!-- Header con Logo -->
        <div class="text-center mb-8">
            <div class="logo-container rounded-2xl p-2 mb-4 mx-auto w-fit slide-in" style="animation-delay: 0.2s;">


                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                <!-- Creator: CorelDRAW 2019 (64-Bit) -->
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="120px" height="120px"
                    version="1.1"
                    style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                    viewBox="0 0 800 800" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <style type="text/css">
                            <![CDATA[
                            .fil1 {
                                fill: #FF2D20
                            }

                            .fil0 {
                                fill: #FF2D20
                            }
                            ]]>
                        </style>
                    </defs>
                    <g id="Capa_x0020_1">
                        <metadata id="CorelCorpID_0Corel-Layer" />
                        <path class="fil0"
                            d="M193.62 385.59c0.05,-16.45 -0.37,-16.44 6.33,-17.01 11.81,-1 52.54,0.42 63.79,0.75 1.23,1.79 0.56,0.09 1.27,3.11l0.12 103.86c-6.75,86.93 -14.94,95.64 -40,183.99l-31.56 0.16 0.05 -274.86zm95.04 99.91c0.99,-19.42 0.52,-38.92 0.22,-58.51 -0.24,-15.66 -2.28,-43.55 0,-58.09 18.73,-2.85 74.77,1.21 97.99,0.42l-0.23 150.74c-8.6,-4.93 -36.97,-13.58 -48.61,-17.45 -15.74,-5.22 -34.44,-11.08 -49.37,-17.11zm125.33 174.81c-0.03,-46.31 -2.55,-92.61 -2.69,-138.54l-1.15 -279.04c-0.09,-51.21 -5.19,-81.9 13.92,-125.63l2.86 10.8c12.67,3.18 10.11,-1.72 17.12,-0.79l44.79 16.56c10.15,3.25 20.34,6.79 31.06,10.32 9.82,3.24 21.79,5.49 30.87,8.78 -10.57,31.71 -7.01,29.34 -21.69,32.38 -14.45,2.99 -32.09,4 -40,13.46 -8.49,10.14 -0.58,33.97 0.89,47.33 1.77,15.98 3.34,32.06 5.37,48.1 2.71,21.32 22.49,189.23 19.32,196.58 -3.93,3.82 -10.6,7.05 -15.7,10.22 -38.06,23.65 -33.32,17.35 -33.35,45.64 -0.02,20.22 4.7,88.37 0.4,102.28 -1.65,2.35 -9.1,1.76 -12.2,1.71l-39.82 -0.16zm19.25 -592.21l-0.66 3.16 -3.26 -13.62 -7.72 -1.16c-0.92,3.76 -1.54,11.96 -3.4,7.19 -3.65,3.63 -17.28,47.41 -21.01,57.15 -11.75,30.61 -10.35,32.92 -10.35,68.5 0.01,52 0.02,103.99 0.02,155.99 -23.65,0.15 -205.4,-1.9 -212.52,1.13 -6.9,2.94 -5.15,12.98 -5.12,21.79l-0.01 292.39c-0.06,29.32 1.77,23.8 56.28,24.21 20.17,0.15 17.47,0.76 32.29,-48.1 5.75,-18.99 35.17,-116.35 38.46,-121.21 12.88,3.63 83.64,26.49 92.63,31.12 3.52,161.78 -10.67,136.09 52.9,137.4 31.27,0.65 50.57,9.5 49.15,-44.63 -0.82,-31.45 -2.15,-62.71 -2.3,-94.28l30.18 -18.38c13.03,-7.61 19.16,-11.8 19.75,-31.63 0.68,-23.32 -19.26,-187.25 -24.14,-227.49l-4.46 -43.8c7.77,-2.7 21.99,-4 30.82,-6.16 13.91,-3.41 17.54,-3.8 21.96,-16.94 6.17,-18.31 21.05,-45.08 2.4,-57.35 -7.35,-4.82 -18.53,-6.32 -27.92,-9.54 -19.16,-6.59 -72.16,-24.37 -84.33,-30.96l17.04 -56.57c-31.77,13.64 -25.42,23.07 -33.68,32.46 -0.83,-5.14 -0.04,-7.45 -3,-10.67z" />
                        <path class="fil0"
                            d="M437.58 152.7c12.8,7.23 9.86,5.38 25.14,9.35l4.58 -7.5 -30.4 -10.95 0.68 9.1z" />
                        <path class="fil1"
                            d="M418.2 63.67c1.86,4.77 2.48,-3.43 3.4,-7.19l7.72 1.16 3.26 13.62 0.66 -3.16c0.4,-5.99 -0.95,-6.53 -2.45,-11.99l-10.32 -1.89 -2.27 9.45z" />
                    </g>
                </svg>

            </div>
            <h1 class="text-4xl md:text-5xl  text-white mb-4">
                Instalador de <span class="titulo">Redvel</span>
            </h1>
            <p class="text-gray-300 text-lg">
                Configuración automática del framework
            </p>
        </div>

        <!-- Botón de Instalación -->
        <div class="text-center mb-8">
            <button id="startInstallBtn"
                class="btn-primary text-white px-12 py-4 rounded-lg font-bold text-xl shadow-lg hover:shadow-2xl disabled:cursor-not-allowed">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span id="btnText">COMENZAR INSTALACIÓN</span>
                </div>
            </button>
        </div>

        <!-- Terminal -->
        <div class="terminal rounded-xl p-6 mb-6 h-80 overflow-y-auto shadow-2xl">
            <div id="installTerminal" class="text-green-400 text-sm font-mono">
                <div class="flex items-center text-green-400 mb-2">
                    <span class="text-red-400">redvel@installer</span>
                    <span class="text-white">:</span>
                    <span class="text-blue-400">~</span>
                    <span class="text-white">$ </span>
                    <span class="cursor-blink">Sistema listo para iniciar la instalación...</span>
                </div>
            </div>
        </div>

        <!-- Barra de Progreso -->
        <div class="bg-gray-800 rounded-lg p-1 mb-6 border border-gray-700">
            <div id="progressBar"
                class="progress-bar-animated h-8 rounded-md flex items-center justify-center text-white font-bold transition-all duration-500 ease-out"
                style="width: 0%;">
                <span id="progressText">0%</span>
            </div>
        </div>

        <!-- Panel de Estado -->
        <div id="statusPanel"
            class="bg-gray-800 bg-opacity-50 backdrop-blur-sm rounded-xl p-6 border border-gray-700 mb-6 hidden">
            <h3 class="text-red-400 font-semibold text-lg mb-4 text-center">Estado de la Instalación</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="bg-gray-900 bg-opacity-50 p-4 rounded-lg text-center">
                    <div class="text-gray-400 font-medium mb-2">Base de Datos</div>
                    <div id="dbStatus" class="text-yellow-400">⏳ Esperando</div>
                </div>
                <div class="bg-gray-900 bg-opacity-50 p-4 rounded-lg text-center">
                    <div class="text-gray-400 font-medium mb-2">Configuración</div>
                    <div id="configStatus" class="text-yellow-400">⏳ Esperando</div>
                </div>
                <div class="bg-gray-900 bg-opacity-50 p-4 rounded-lg text-center">
                    <div class="text-gray-400 font-medium mb-2">Sistema</div>
                    <div id="systemStatus" class="text-yellow-400">⏳ Esperando</div>
                </div>
            </div>
        </div>

        <!-- Contador de Redirección -->
        <div id="redirectCounter" class="text-center text-white text-2xl font-bold hidden">
            <div class="bg-green-600 bg-opacity-20 backdrop-blur-sm rounded-xl p-6 border border-green-500">
                <div class="text-green-400 mb-2">✅ Instalación Completada</div>
                <div id="countdownText" class="text-xl"></div>
            </div>
        </div>
    </div>

    <script>
        // Obtiene el token CSRF desde la metaetiqueta
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.getElementById('startInstallBtn').addEventListener('click', function() {
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');
            const terminal = document.getElementById('installTerminal');
            const startInstallBtn = document.getElementById('startInstallBtn');
            const btnText = document.getElementById('btnText');
            const redirectCounter = document.getElementById('redirectCounter');
            const statusPanel = document.getElementById('statusPanel');

            // Deshabilitamos el botón y cambiamos el texto
            startInstallBtn.disabled = true;
            btnText.textContent = 'INSTALANDO...';
            statusPanel.classList.remove('hidden');

            // Limpiar terminal
            terminal.innerHTML = '';
            addTerminalLine('Iniciando el proceso de instalación del RedVel Framework...', 'text-green-400');

            // Realizamos la petición POST a la ruta /install
            fetch('/install', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la conexión con el servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    addTerminalLine(
                        `✅ Servidor respondió: ${data.message || 'Instalación iniciada correctamente'}`,
                        'text-green-400');
                    // Si el servidor responde correctamente, completamos la instalación
                    completeInstallation();
                })
                .catch(error => {
                    addTerminalLine(`❌ Error: ${error.message}`, 'text-red-400');
                    updateStatus('systemStatus', '🔴 Error', 'text-red-400');
                    // Permitir reintentar en caso de error
                    startInstallBtn.disabled = false;
                    btnText.textContent = 'REINTENTAR INSTALACIÓN';
                });

            // Configuración del progreso y pasos
            let progress = 0;
            let steps = [{
                    text: '🔍 Verificando requisitos del sistema...',
                    status: 'systemStatus',
                    value: '🔄 Verificando'
                },
                {
                    text: '📦 Descargando dependencias del framework...',
                    status: 'systemStatus',
                    value: '⬇️ Descargando'
                },
                {
                    text: '🗄️ Creando estructura de la base de datos...',
                    status: 'dbStatus',
                    value: '🔄 Creando'
                },
                {
                    text: '📊 Insertando datos de configuración inicial...',
                    status: 'dbStatus',
                    value: '📝 Configurando'
                },
                {
                    text: '⚙️ Configurando variables del entorno...',
                    status: 'configStatus',
                    value: '🔧 Configurando'
                },
                {
                    text: '🔐 Estableciendo permisos y seguridad...',
                    status: 'configStatus',
                    value: '🔒 Seguridad'
                },
                {
                    text: '🚀 Optimizando rendimiento del sistema...',
                    status: 'systemStatus',
                    value: '⚡ Optimizando'
                },
                {
                    text: '🧪 Ejecutando pruebas de integridad...',
                    status: 'systemStatus',
                    value: '✅ Probando'
                },
                {
                    text: '🧹 Limpieza de archivos temporales...',
                    status: 'configStatus',
                    value: '🗑️ Limpiando'
                }
            ];
            let stepIndex = 0;

            // Función para añadir líneas al terminal
            function addTerminalLine(text, className = 'text-green-400') {
                const line = document.createElement('div');
                line.className = `terminal-line ${className} mb-1`;
                line.innerHTML = `
          <span class="text-red-400">redvel@installer</span>
          <span class="text-white">:</span>
          <span class="text-blue-400">~</span>
          <span class="text-white">$ </span>
          <span>${text}</span>
        `;
                terminal.appendChild(line);
                terminal.scrollTop = terminal.scrollHeight;
            }

            // Función para actualizar el estado
            function updateStatus(elementId, text, className) {
                const element = document.getElementById(elementId);
                element.textContent = text;
                element.className = className;
            }

            // Función para completar la instalación
            function completeInstallation() {
                // Completa la barra de progreso
                progress = 100;
                progressBar.style.width = '100%';
                progressText.textContent = '¡Instalación Completa!';

                // Actualizar todos los estados a completado
                updateStatus('dbStatus', '✅ Completado', 'text-green-400');
                updateStatus('configStatus', '✅ Completado', 'text-green-400');
                updateStatus('systemStatus', '✅ Completado', 'text-green-400');

                addTerminalLine('🎉 ¡RedVel Framework instalado exitosamente!', 'text-green-400 font-bold');
                addTerminalLine('🌐 Preparando redirección a la aplicación...', 'text-blue-400');

                // Mostrar contador de redirección
                redirectCounter.classList.remove('hidden');

                // Iniciar cuenta regresiva
                let countdown = 5;
                const countdownText = document.getElementById('countdownText');
                countdownText.textContent = `Redirigiendo en ${countdown} segundos...`;

                const countdownInterval = setInterval(() => {
                    countdown--;
                    countdownText.textContent = `Redirigiendo en ${countdown} segundos...`;

                    if (countdown <= 0) {
                        clearInterval(countdownInterval);
                        // Configurar la URL de redirección
                        const baseUrl = '{{ env('APP_URL_FRONTEND', 'http://localhost:3000') }}';
                        window.location.href = baseUrl;
                    }
                }, 1000);
            }

            // Simular progreso de instalación
            let interval = setInterval(() => {
                if (progress >= 90 || stepIndex >= steps.length) {
                    clearInterval(interval);
                    return;
                }

                progress += Math.floor(90 / steps.length);
                if (progress > 90) progress = 90;

                progressBar.style.width = progress + '%';
                progressText.textContent = progress + '%';

                if (stepIndex < steps.length) {
                    const step = steps[stepIndex];
                    addTerminalLine(step.text);
                    if (step.status) {
                        updateStatus(step.status, step.value, 'text-yellow-400');
                    }
                    stepIndex++;
                }
            }, 3000); // Cada 3 segundos para dar tiempo a leer
        });

        // Efecto de partículas que responden al mouse
        document.addEventListener('mousemove', (e) => {
            const sparks = document.querySelectorAll('.spark');
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;

            sparks.forEach((spark, index) => {
                const speed = (index + 1) * 0.5;
                const x = (mouseX - 0.5) * speed * 20;
                const y = (mouseY - 0.5) * speed * 20;

                spark.style.transform = `translate(${x}px, ${y}px)`;
            });
        });
    </script>
</body>

</html>
