<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Error Interno del Servidor | RedVel Framework</title>
    <link rel="shortcut icon" href="/logo/Redvel.svg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
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

        @keyframes glitch {
            0% {
                transform: translate(0);
            }

            20% {
                transform: translate(-2px, 2px);
            }

            40% {
                transform: translate(-2px, -2px);
            }

            60% {
                transform: translate(2px, 2px);
            }

            80% {
                transform: translate(2px, -2px);
            }

            100% {
                transform: translate(0);
            }
        }

        @keyframes pulse-danger {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(220, 38, 38, 0.4);
            }

            50% {
                box-shadow: 0 0 40px rgba(220, 38, 38, 0.8);
            }
        }

        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-2px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(2px);
            }
        }

        @keyframes spark {
            0% {
                opacity: 0;
                transform: scale(0) rotate(0deg);
            }

            50% {
                opacity: 1;
                transform: scale(1) rotate(180deg);
            }

            100% {
                opacity: 0;
                transform: scale(0) rotate(360deg);
            }
        }

        .glitch-animation {
            animation: glitch 0.5s ease-in-out infinite;
        }

        .pulse-danger {
            animation: pulse-danger 1.5s ease-in-out infinite;
        }

        .slide-in {
            animation: slide-in 0.8s ease-out forwards;
        }

        .shake-animation {
            animation: shake 2s ease-in-out infinite;
        }

        .spark-animation {
            animation: spark 2s ease-in-out infinite;
        }

        .gradient-bg {
            background: linear-gradient(-45deg, #1f1f1f, #0f0f0f, #1a0000, #2d1b1b);
            background-size: 400% 400%;
            animation: gradient-shift 8s ease infinite;
        }

        .error-number {
            background: linear-gradient(135deg, #dc2626, #b91c1c, #991b1b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 30px rgba(220, 38, 38, 0.5);
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(220, 38, 38, 0.3);
        }

        .logo-container {
            background: rgba(31, 31, 31, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(220, 38, 38, 0.3);
        }

        .danger-border {
            border: 2px solid rgba(220, 38, 38, 0.5);
            background: rgba(220, 38, 38, 0.1);
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Efectos de chispas flotantes -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-1 h-1 bg-red-600 rounded-full spark-animation"
            style="animation-delay: 0s;"></div>
        <div class="absolute top-1/3 right-1/4 w-2 h-2 bg-red-500 rounded-full spark-animation"
            style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/4 left-1/3 w-1 h-1 bg-red-700 rounded-full spark-animation"
            style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 right-1/3 w-1 h-1 bg-red-600 rounded-full spark-animation"
            style="animation-delay: 3s;"></div>
        <div class="absolute bottom-1/3 right-1/4 w-2 h-2 bg-red-500 rounded-full spark-animation"
            style="animation-delay: 4s;"></div>
        <div class="absolute top-3/4 left-1/2 w-1 h-1 bg-red-700 rounded-full spark-animation"
            style="animation-delay: 2.5s;"></div>
    </div>

    <div class="max-w-4xl w-full mx-auto text-center relative">
        <!-- Contenedor del Logo -->
        <div class="logo-container rounded-2xl p-2 mb-4 mx-auto w-fit slide-in" style="animation-delay: 0.2s;">


            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <!-- Creator: CorelDRAW 2019 (64-Bit) -->
            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="120px" height="120px" version="1.1"
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

        <!-- Número 500 -->
        <div class="slide-in" style="animation-delay: 0.4s;">
            <h1 class="error-number text-8xl md:text-9xl font-black mb-6 glitch-animation">
                500
            </h1>
        </div>

        <!-- Título y descripción -->
        <div class="slide-in" style="animation-delay: 0.6s;">
            <h2 class="text-white text-3xl md:text-4xl font-bold mb-4">
                Error Interno del Servidor
            </h2>
            <p class="text-gray-300 text-lg md:text-xl  max-w-2xl mx-auto leading-relaxed">
                Algo salió mal en <span class="titulo">Redvel
                </span>.
            </p>
            <p class="text-gray-300 text-lg md:text-xl mb-8 max-w-2xl mx-auto leading-relaxed">
                Verifica los logs del servidor.
            </p>
        </div>

        <!-- Botones de acción -->
        <div class="slide-in flex flex-col sm:flex-row gap-4 justify-center items-center"
            style="animation-delay: 0.8s;">
            <button onclick="reloadPage()"
                class="hover-lift bg-gradient-to-r from-red-700 to-red-800 text-white px-8 py-4 rounded-lg font-semibold text-lg shadow-lg pulse-danger flex items-center gap-3 min-w-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Intentar de Nuevo
            </button>

            <button onclick="goHome()"
                class="hover-lift bg-gray-800 hover:bg-gray-700 text-white px-8 py-4 rounded-lg font-semibold text-lg shadow-lg border border-gray-600 flex items-center gap-3 min-w-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Ir al Inicio
            </button>
        </div>

        <!-- Panel de estado del sistema -->
        <div class="slide-in mt-12 p-6 danger-border rounded-lg backdrop-blur-sm" style="animation-delay: 1s;">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-3 h-3 bg-red-500 rounded-full pulse-danger"></div>
                <h3 class="text-red-400 font-semibold text-lg">Estado del Sistema</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="bg-gray-800 bg-opacity-50 p-4 rounded-lg">
                    <div class="text-red-400 font-medium mb-1">Servidor Web</div>
                    <div class="text-gray-300">🔴 Degradado</div>
                </div>
                <div class="bg-gray-800 bg-opacity-50 p-4 rounded-lg">
                    <div class="text-red-400 font-medium mb-1">Base de Datos</div>
                    <div class="text-gray-300">🟡 Investigando...</div>
                </div>
                <div class="bg-gray-800 bg-opacity-50 p-4 rounded-lg">
                    <div class="text-red-400 font-medium mb-1">API</div>
                    <div class="text-gray-300">🔴 Fuera de Línea</div>
                </div>
            </div>
        </div>

        <!-- Información técnica -->
        <div class="slide-in mt-8 p-6 bg-gray-900 bg-opacity-50 rounded-lg border border-red-800"
            style="animation-delay: 1.2s;" id="error-box">
            <h3 class="text-red-400 font-semibold text-lg mb-3">Información Técnica</h3>
            <div class="text-gray-300 text-sm space-y-2 text-left max-w-2xl mx-auto">
                <p><span class="text-red-400">Error ID:</span> <span id="error-id"></span></p>
                <p><span class="text-red-400">Timestamp:</span> <span id="timestamp"></span></p>
                <p><span class="text-red-400">Servidor:</span> <span id="server-id"></span></p>
                <p class="text-gray-400 mt-4">
                    Si el problema persiste, por favor contacta al soporte técnico con el Error ID mostrado arriba.
                </p>
            </div>
        </div>

        <script>
            document.getElementById("error-id").textContent =
                "RV500-" + Math.random().toString(36).substr(2, 8).toUpperCase();
            document.getElementById("timestamp").textContent = new Date().toISOString();
            document.getElementById("server-id").textContent =
                "RedVel-prod-" + (Math.floor(Math.random() * 10) + 1);
        </script>


        <!-- Footer con detalles técnicos -->
        <div class="slide-in mt-8 text-gray-600 text-sm" style="animation-delay: 1.4s;">
            <p>Internal Server Error | RedVel Framework v1.0 | Status: Degraded</p>
        </div>
    </div>

    <script>
        function reloadPage() {
            // Añadir un pequeño delay para que se vea la animación del botón
            setTimeout(() => {
                window.location.reload();
            }, 200);
        }

        function goHome() {
            // Aquí puedes cambiar la URL por la de tu aplicación
            window.location.href = '/';
        }

        // Efecto de hover más dramático para error 500
        document.addEventListener('mousemove', (e) => {
            const sparks = document.querySelectorAll('.spark-animation');
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;

            sparks.forEach((spark, index) => {
                const speed = (index + 1) * 1.5; // Más velocidad que en 404
                const x = (mouseX - 0.5) * speed;
                const y = (mouseY - 0.5) * speed;

                spark.style.transform = `translate(${x}px, ${y}px) scale(${1 + mouseX * 0.5})`;
            });
        });

        // Actualizar información técnica cada 30 segundos
        setInterval(() => {
            const errorId = document.querySelector('[class*="Error ID"]');
            if (errorId) {
                const newId = 'RV500-' + Math.random().toString(36).substr(2, 8).toUpperCase();
                errorId.innerHTML = errorId.innerHTML.replace(/RV500-[A-Z0-9]+/, newId);
            }
        }, 30000);

        // Animación de entrada escalonada
        window.addEventListener('load', () => {
            const elements = document.querySelectorAll('.slide-in');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';

                setTimeout(() => {
                    el.style.transition = 'all 0.8s ease-out';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });

        // Efecto de glitch ocasional para mayor dramatismo
        setInterval(() => {
            const errorNumber = document.querySelector('.error-number');
            errorNumber.style.animation = 'none';
            setTimeout(() => {
                errorNumber.style.animation = 'glitch 0.5s ease-in-out infinite';
            }, 50);
        }, 10000);
    </script>
</body>

</html>
