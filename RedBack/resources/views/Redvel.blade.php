<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redvel - Modulo(Backend)</title>
    <link rel="shortcut icon" href="/logo/Redvel.svg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    animation: {
                        'slide-in-left': 'slideInLeft 0.6s ease-out forwards',
                        'slide-in-up': 'slideInUp 0.6s ease-out forwards',
                        'fade-in': 'fadeIn 0.6s ease-out forwards',
                        'bounce-in': 'bounceIn 0.8s ease-out forwards',
                        'pulse': 'pulse 2s infinite'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

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

        .dark .titulo {
            background: linear-gradient(135deg, #f87171 0%, #dc2626 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }

            50% {
                opacity: 1;
                transform: scale(1.1);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
        }

        .animation-delay-600 {
            animation-delay: 0.6s;
        }

        .animation-delay-700 {
            animation-delay: 0.7s;
        }

        .animation-delay-800 {
            animation-delay: 0.8s;
        }

        .animation-delay-1000 {
            animation-delay: 1.0s;
        }

        .animation-delay-1100 {
            animation-delay: 1.1s;
        }

        .animation-delay-1200 {
            animation-delay: 1.2s;
        }

        .animation-delay-1300 {
            animation-delay: 1.3s;
        }

        .animation-delay-1400 {
            animation-delay: 1.4s;
        }

        .animation-delay-1500 {
            animation-delay: 1.5s;
        }

        .pattern-bg {
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4gPGcgZmlsbD0ibm9uZSIgZmlsbFJ1bGU9ImV2ZW5vZGQiPiA8ZyBmaWxsPSIjZmZmZmZmIiBmaWxsT3BhY2l0eT0iMC4xIj4gPGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMiIvPiA8L2c+IDwvZz4gPC9zdmc+');
        }

        .dark .pattern-bg {
            opacity: 0.3;
        }

        .icon-hover {
            transition: transform 0.3s ease;
        }

        .icon-hover:hover {
            transform: scale(1.1);
        }

        /* SVG Icons as Data URLs */
        .react-icon {
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDkuODYxQzEzLjE0NiA5Ljg2MSAxNC4wNzYgMTAuNzkxIDE0LjA3NiAxMS45MzdDMTQuMDc2IDEzLjA4MyAxMy4xNDYgMTQuMDEzIDEyIDE0LjAxM0MxMC44NTQgMTQuMDEzIDkuOTI0IDEzLjA4MyA5LjkyNCAxMS45MzdDOS45MjQgMTAuNzkxIDEwLjg1NCA5Ljg2MSAxMiA5Ljg2MVoiIGZpbGw9IiM2MUREQkYiLz4KPHBhdGggZD0iTTEyIDJDMTMuODUgMiAxNy4yIDMuOTggMTguNjggNi44MkMxOS4xNiA3LjY5IDE5LjUgOC42MSAxOS43NSA5LjU1QzIwLjUgMTIuMTcgMjAuNSAxNC42MyAxOS43NSAxNy4yNUMxOS41IDE4LjE5IDE5LjE1IDI5LjEwNCAxOC42OCAxOS45OEMxNy4yIDIwLjAyIDEzLjg1IDIyIDEyIDIyUzYuOCAyMC4wMiA1LjMyIDE5Ljk4QzQuODQgMTkuMTA0IDQuNSAxOC4xOSA0LjI1IDE3LjI1QzMuNSAxNC42MyAzLjUgMTIuMTcgNC4yNSA5LjU1QzQuNSA4LjYxIDQuODQgNy42OSA1LjMyIDYuODJDNi44IDMuOTggMTAuMTUgMiAxMiAyWiIgc3Ryb2tlPSIjNjFEREJGIiBzdHJva2Utd2lkdGg9IjEuNSIgZmlsbD0ibm9uZSIvPgo8L3N2Zz4K');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .laravel-icon {
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTIuNCA0LjhMMTIgMi40TDIxLjYgNC44TDEyIDcuMkwyLjQgNC44WiIgZmlsbD0iI0ZGMkQyMCIvPgo8cGF0aCBkPSJNMi40IDEyTDEyIDkuNkwyMS42IDEyTDEyIDE0LjRMMi40IDEyWiIgZmlsbD0iI0ZGMkQyMCIvPgo8cGF0aCBkPSJNMi40IDE5LjJMMTIgMTYuOEwyMS42IDE5LjJMMTIgMjEuNkwyLjQgMTkuMloiIGZpbGw9IiNGRjJEMjAiLz4KPC9zdmc+Cg==');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .mysql-icon {
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJDMTYuNDE4IDIgMjAgNS4xMzQgMjAgOS4ydjUuNkMyMCAxOC44NjYgMTYuNDE4IDIyIDEyIDIyUzcuNTgyIDE4Ljg2NiA3LjU4MiAxNC44VjkuMkM3LjU4MiA1LjEzNCA3Ljk5NiAyIDEyIDJaIiBzdHJva2U9IiMwMDc1OEYiIHN0cm9rZS13aWR0aD0iMS41IiBmaWxsPSJub25lIi8+CjxwYXRoIGQ9Ik0xMiA5LjJIMTZDMTcuMTA0IDkuMiAxOCAxMC4wOTYgMTggMTEuMlYxNC44IiBzdHJva2U9IiMwMDc1OEYiIHN0cm9rZS13aWR0aD0iMS41IiBmaWxsPSJub25lIi8+CjxwYXRoIGQ9Ik0xMiA5LjJIOEM2Ljg5NiA5LjIgNiAxMC4wOTYgNiAxMS4yVjE0LjgiIHN0cm9rZT0iIzAwNzU4RiIgc3Ryb2tlLXdpZHRoPSIxLjUiIGZpbGw9Im5vbmUiLz4KPC9zdmc+Cg==');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .axios-icon {
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTIgMTJMMTIgMkwyMiAxMkwxMiAyMkwyIDEyWiIgZmlsbD0iIzY3MUREQiIvPgo8cGF0aCBkPSJNOCA5TDE2IDE1TTEyIDEySDEyLjAxIiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPgo8L3N2Zz4K');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .query-icon {
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTggNkMxMCA2IDEyIDQgMTIgNC4zMDk5NEMxMiAyLjYzNzQgMTAuMjA5MyAyIDggMkM1Ljc5MDY5IDIgNCAyLjYzNzQgNCA0LjMwOTk0QzQgNiA2IDYgOCA2WiIgZmlsbD0iI0ZBQ0MxNSIvPgo8cGF0aCBkPSJNMTYgMTJDMTguMjA5MyAxMiAyMCAxMS4zNjI2IDIwIDkuNjkwMDZDMjAgOCAyMC4yMDkzIDggMTggOEMxNS43OTA3IDggMTQgOC42Mzc0IDE0IDEwLjMwOTlDMTQgMTIgMTYgMTIgMTYgMTJaIiBmaWxsPSIjRkFDQzE1Ii8+CjxwYXRoIGQ9Ik04IDE4QzEwLjIwOTMgMTggMTIgMTcuMzYyNiAxMiAxNS42OTAxQzEyIDE0IDEwIDEwIDggMTBDNiAxMCA0IDE0IDQgMTUuNjkwMUM0IDE3LjM2MjYgNS43OTA2OSAxOCA4IDE4WiIgZmlsbD0iI0ZBQ0MxNSIvPgo8L3N2Zz4K');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .router-icon {
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTkgOUwyMSA5VjE1SDlWOVoiIGZpbGw9IiNEQTFENDIiLz4KPHBhdGggZD0iTTMgOUgyMUgzWiIgc3Ryb2tlPSIjREExRTQyIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPgo8cGF0aCBkPSJNOSAxMkwxMiA5TDkgNiIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPC9zdmc+Cg==');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .redvel-logo {
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMzIiIGN5PSIzMiIgcj0iMzAiIGZpbGw9IndoaXRlIiBmaWxsLW9wYWNpdHk9IjAuOSIvPgo8cGF0aCBkPSJNMjAgMTZIMjhDMzAgMTYgMzEuNSAxNi41IDMyLjUgMTguNUwzNiAyNkw0MiAzOEM0MyAzOS41IDQ0IDE0LjUgNDQgNDZIMzZMMzIgMzRMMjggNDZIMjBWMTZaIiBmaWxsPSIjRUY0NDQ0Ii8+Cjx0ZXh0IHg9IjMyIiB5PSI0NCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZm9udC1mYW1pbHk9IkludGVyIiBmb250LXNpemU9IjI0IiBmb250LXdlaWdodD0iYm9sZCIgZmlsbD0iI0VGNDRINCI+UjwvdGV4dD4KPC9zdmc+Cg==');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800">
    <!-- Theme Toggle Button -->
    <button id="theme-toggle"
        class="fixed top-4 left-4 z-50 p-2 rounded-lg bg-white dark:bg-slate-800 shadow-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
        <svg class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path class="sun-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
            </path>
            <path class="moon-icon hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
    </button>

    <!-- Main Content -->
    <section class="min-h-screen flex items-center justify-center p-4">
        <div class="container max-w-7xl mx-auto">
            <div
                class="overflow-hidden shadow-2xl bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm rounded-2xl border border-slate-200/50 dark:border-slate-700/50">
                <!-- Main Card Content -->
                <div class="grid lg:grid-cols-2 gap-0 min-h-[450px]">
                    <!-- Left Content -->
                    <div class="flex flex-col justify-center p-4 lg:p-8 space-y-4">
                        <div class="space-y-4">
                            <div class="space-y-3">
                                <!-- Badge -->
                                <div
                                    class="inline-flex items-center gap-2 px-3 py-1 bg-red-50 dark:bg-red-950/50 rounded-full border border-red-100 dark:border-red-800">
                                    <span class="text-xs font-medium text-red-700 dark:text-red-300">
                                        <a href="https://github.com/luis-huaney-lino-devops" target="_blank">
                                            Desarrollado por ...</a>
                                    </span>
                                </div>

                                <!-- Title -->
                                <h1 class="text-3xl lg:text-5xl tracking-tight animate-slide-in-left">
                                    <span class="titulo">Redvel</span>
                                </h1>

                                <!-- Subtitle -->
                                <p
                                    class="text-lg lg:text-xl text-slate-600 dark:text-slate-300 font-light leading-relaxed animate-slide-in-left animation-delay-200">
                                    El framework que combina la potencia de
                                    <span class="font-semibold text-blue-600 dark:text-blue-400">React</span>
                                    con la elegancia de
                                    <span class="font-semibold text-red-500 dark:text-red-400">Laravel</span>
                                </p>
                            </div>

                            <!-- Description -->
                            <p
                                class="text-base text-slate-500 dark:text-slate-400 leading-relaxed animate-fade-in animation-delay-300">
                                Desarrolla aplicaciones web modernas con la mejor experiencia de desarrollador.
                            </p>

                            <!-- Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3 animate-slide-in-up animation-delay-400">
                                <button
                                    class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                                    Comenzar Ahora
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                                <a target="_blank" href="https://github.com/luis-huaney-lino-devops/REDVEL-FRAMEWORK"
                                    class="border border-slate-300 dark:border-slate-600 dark:bg-slate-800/50 dark:text-slate-200 dark:hover:bg-slate-700 hover:bg-slate-50 px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                    </svg>
                                    Ver en GitHub
                                </a>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3 animate-slide-in-up animation-delay-400">
                                <button
                                    class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center gap-2"
                                    onclick="document.getElementById('miIframe').contentWindow.location.reload();">
                                    Actualizar Estado
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-refresh-cw-icon lucide-refresh-cw">
                                        <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8" />
                                        <path d="M21 3v5h-5" />
                                        <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16" />
                                        <path d="M8 16H3v5" />
                                    </svg>
                                </button>
                                <a href="{{ env('APP_URL_FRONTEND') }}" target="_blank"
                                    class="bg-orange-600 hover:bg-orange-700 dark:bg-orange-700 dark:hover:bg-orange-800 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                                    Ver Frontend
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-app-window-icon lucide-app-window">
                                        <rect x="2" y="4" width="20" height="16" rx="2" />
                                        <path d="M10 4v4" />
                                        <path d="M2 8h20" />
                                        <path d="M6 4v4" />
                                    </svg>
                                </a>
                            </div>

                            <iframe id="miIframe" src="/up" frameborder="0"
                                style="border-radius: 25px !important; " width="100%"></iframe>
                            <script>
                                setInterval(function() {
                                    document.getElementById('miIframe').contentWindow.location.reload();
                                }, 10000);
                            </script>
                        </div>
                    </div>

                    <!-- Right Visual -->
                    <div
                        class="relative bg-gradient-to-br from-red-500 to-red-700 dark:from-red-600 dark:to-red-800 flex items-center justify-center p-2 lg:p-4">
                        <div class="absolute inset-0 pattern-bg opacity-20 dark:opacity-30"></div>

                        <div class="relative z-10 text-center space-y-4">
                            <!-- Logo -->
                            <div
                                class="w-20 h-20 lg:w-24 lg:h-24 mx-auto bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 dark:border-white/20 animate-bounce-in animation-delay-200">
                                <?xml ?>
                                <!DOCTYPE svg
                                    PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                <!-- Creator: CorelDRAW 2019 (64-Bit) -->
                                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="800px"
                                    height="800px" version="1.1"
                                    style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                                    viewBox="0 0 800 800" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <defs>
                                        <style type="text/css">
                                            <![CDATA[
                                            .fil1 {
                                                fill: #c1babac4
                                            }

                                            .fil0 {
                                                fill: #c1babac4
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

                            <!-- Text -->
                            <div class="space-y-2 animate-fade-in animation-delay-400">
                                <h2 class="text-xl lg:text-2xl font-bold text-white">React + Laravel</h2>
                                <p class="text-red-100 dark:text-red-200 text-sm lg:text-base max-w-xs mx-auto">
                                    La combinación perfecta para aplicaciones modernas
                                </p>
                            </div>

                            <!-- Tech Icons -->
                            <div class="flex justify-center gap-3 animate-slide-in-up animation-delay-600">
                                <div
                                    class="w-12 h-12 bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30 dark:border-white/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="25px" height="25px" viewBox="0 -14 256 256" version="1.1"
                                        preserveAspectRatio="xMidYMid">
                                        <g>
                                            <path
                                                d="M210.483381,73.8236374 C207.827698,72.9095503 205.075867,72.0446761 202.24247,71.2267368 C202.708172,69.3261098 203.135596,67.4500894 203.515631,65.6059664 C209.753843,35.3248922 205.675082,10.9302478 191.747328,2.89849283 C178.392359,-4.80289661 156.551327,3.22703567 134.492936,22.4237776 C132.371761,24.2697233 130.244662,26.2241201 128.118477,28.2723861 C126.701777,26.917204 125.287358,25.6075897 123.876584,24.3549348 C100.758745,3.82852863 77.5866802,-4.82157937 63.6725966,3.23341515 C50.3303869,10.9571328 46.3792156,33.8904224 51.9945178,62.5880206 C52.5367729,65.3599011 53.1706189,68.1905639 53.8873982,71.068617 C50.6078941,71.9995641 47.4418534,72.9920277 44.4125156,74.0478303 C17.3093297,83.497195 0,98.3066828 0,113.667995 C0,129.533287 18.5815786,145.446423 46.8116526,155.095373 C49.0394553,155.856809 51.3511025,156.576778 53.7333796,157.260293 C52.9600965,160.37302 52.2875179,163.423318 51.7229345,166.398431 C46.3687351,194.597975 50.5500231,216.989464 63.8566899,224.664425 C77.6012619,232.590464 100.66852,224.443422 123.130185,204.809231 C124.905501,203.257196 126.687196,201.611293 128.472081,199.886102 C130.785552,202.113904 133.095375,204.222319 135.392897,206.199955 C157.14963,224.922338 178.637969,232.482469 191.932332,224.786092 C205.663234,216.837268 210.125675,192.78347 204.332202,163.5181 C203.88974,161.283006 203.374826,158.99961 202.796573,156.675661 C204.416503,156.196743 206.006814,155.702335 207.557482,155.188332 C236.905331,145.46465 256,129.745175 256,113.667995 C256,98.2510906 238.132466,83.3418093 210.483381,73.8236374 L210.483381,73.8236374 Z M204.118035,144.807565 C202.718197,145.270987 201.281904,145.718918 199.818271,146.153177 C196.578411,135.896354 192.205739,124.989735 186.854729,113.72131 C191.961041,102.721277 196.164656,91.9540963 199.313837,81.7638014 C201.93261,82.5215915 204.474374,83.3208483 206.923636,84.1643056 C230.613348,92.3195488 245.063763,104.377206 245.063763,113.667995 C245.063763,123.564379 229.457753,136.411268 204.118035,144.807565 L204.118035,144.807565 Z M193.603754,165.642007 C196.165567,178.582766 196.531475,190.282717 194.834536,199.429057 C193.309843,207.64764 190.243595,213.12715 186.452366,215.321689 C178.384612,219.991462 161.131788,213.921395 142.525146,197.909832 C140.392124,196.074366 138.243609,194.114502 136.088259,192.040261 C143.301619,184.151133 150.510878,174.979732 157.54698,164.793993 C169.922699,163.695814 181.614905,161.900447 192.218042,159.449363 C192.740247,161.555956 193.204126,163.621993 193.603754,165.642007 L193.603754,165.642007 Z M87.2761866,214.514686 C79.3938934,217.298414 73.1160375,217.378157 69.3211631,215.189998 C61.2461189,210.532528 57.8891498,192.554265 62.4682434,168.438039 C62.9927272,165.676183 63.6170041,162.839142 64.3365173,159.939216 C74.8234575,162.258154 86.4299951,163.926841 98.8353334,164.932519 C105.918826,174.899534 113.336329,184.06091 120.811247,192.08264 C119.178102,193.65928 117.551336,195.16028 115.933685,196.574699 C106.001303,205.256705 96.0479605,211.41654 87.2761866,214.514686 L87.2761866,214.514686 Z M50.3486141,144.746959 C37.8658105,140.48046 27.5570398,134.935332 20.4908634,128.884403 C14.1414664,123.446815 10.9357817,118.048415 10.9357817,113.667995 C10.9357817,104.34622 24.8334611,92.4562517 48.0123604,84.3748281 C50.8247961,83.3942121 53.7689223,82.4701001 56.8242337,81.6020363 C60.0276398,92.0224477 64.229889,102.917218 69.3011135,113.93411 C64.1642716,125.11459 59.9023288,136.182975 56.6674809,146.725506 C54.489347,146.099407 52.3791089,145.440499 50.3486141,144.746959 L50.3486141,144.746959 Z M62.7270678,60.4878073 C57.9160346,35.9004118 61.1112387,17.3525532 69.1516515,12.6982729 C77.7160924,7.74005624 96.6544653,14.8094222 116.614922,32.5329619 C117.890816,33.6657739 119.171723,34.8514442 120.456275,36.0781256 C113.018267,44.0647686 105.66866,53.1573386 98.6480514,63.0655695 C86.6081646,64.1815215 75.0831931,65.9741531 64.4868907,68.3746571 C63.8206914,65.6948233 63.2305903,63.0619242 62.7270678,60.4878073 L62.7270678,60.4878073 Z M173.153901,87.7550367 C170.620796,83.3796304 168.020249,79.1076627 165.369124,74.9523483 C173.537126,75.9849113 181.362914,77.3555864 188.712066,79.0329319 C186.505679,86.1041206 183.755673,93.4974728 180.518546,101.076741 C178.196419,96.6680702 175.740322,92.2229454 173.153901,87.7550367 L173.153901,87.7550367 Z M128.122121,43.8938899 C133.166461,49.3588189 138.218091,55.4603279 143.186789,62.0803968 C138.179814,61.8439007 133.110868,61.720868 128.000001,61.720868 C122.937434,61.720868 117.905854,61.8411667 112.929865,62.0735617 C117.903575,55.515009 122.99895,49.4217021 128.122121,43.8938899 L128.122121,43.8938899 Z M82.8018984,87.830679 C80.2715265,92.2183886 77.8609975,96.6393627 75.5753239,101.068539 C72.3906004,93.5156998 69.6661103,86.0886276 67.440586,78.9171899 C74.7446255,77.2826781 82.5335049,75.9461789 90.6495601,74.9332099 C87.9610684,79.1268011 85.3391054,83.4302106 82.8018984,87.8297677 L82.8018984,87.830679 L82.8018984,87.830679 Z M90.8833221,153.182899 C82.4979621,152.247395 74.5919739,150.979704 67.289757,149.390303 C69.5508242,142.09082 72.3354636,134.505173 75.5876271,126.789657 C77.8792246,131.215644 80.2993228,135.638441 82.8451877,140.03572 L82.8456433,140.03572 C85.4388987,144.515476 88.1255676,148.90364 90.8833221,153.182899 L90.8833221,153.182899 Z M128.424691,184.213105 C123.24137,178.620587 118.071264,172.434323 113.021912,165.780078 C117.923624,165.972373 122.921029,166.0708 128.000001,166.0708 C133.217953,166.0708 138.376211,165.953235 143.45336,165.727219 C138.468257,172.501308 133.434855,178.697141 128.424691,184.213105 L128.424691,184.213105 Z M180.622896,126.396409 C184.044571,134.195313 186.929004,141.741317 189.219234,148.9164 C181.796719,150.609693 173.782736,151.973534 165.339049,152.986959 C167.996555,148.775595 170.619884,144.430263 173.197646,139.960532 C175.805484,135.438399 178.28163,130.90943 180.622896,126.396409 L180.622896,126.396409 Z M163.724586,134.496971 C159.722835,141.435557 155.614455,148.059271 151.443648,154.311611 C143.847063,154.854776 135.998946,155.134562 128.000001,155.134562 C120.033408,155.134562 112.284171,154.887129 104.822013,154.402745 C100.48306,148.068386 96.285368,141.425078 92.3091341,134.556664 L92.3100455,134.556664 C88.3442923,127.706935 84.6943232,120.799333 81.3870228,113.930466 C84.6934118,107.045648 88.3338117,100.130301 92.276781,93.292874 L92.2758697,93.294241 C96.2293193,86.4385872 100.390102,79.8276317 104.688954,73.5329157 C112.302398,72.9573964 120.109505,72.6571055 127.999545,72.6571055 L128.000001,72.6571055 C135.925583,72.6571055 143.742714,72.9596746 151.353879,73.5402067 C155.587114,79.7888993 159.719645,86.3784378 163.688588,93.2350031 C167.702644,100.168578 171.389978,107.037901 174.724618,113.77508 C171.400003,120.627999 167.720871,127.566587 163.724586,134.496971 L163.724586,134.496971 Z M186.284677,12.3729198 C194.857321,17.3165548 198.191049,37.2542268 192.804953,63.3986692 C192.461372,65.0669011 192.074504,66.7661189 191.654369,68.4881206 C181.03346,66.0374921 169.500286,64.2138746 157.425315,63.0810626 C150.391035,53.0639249 143.101577,43.9572289 135.784778,36.073113 C137.751934,34.1806885 139.716356,32.3762092 141.672575,30.673346 C160.572216,14.2257007 178.236518,7.73185406 186.284677,12.3729198 L186.284677,12.3729198 Z M128.000001,90.8080696 C140.624975,90.8080696 150.859926,101.042565 150.859926,113.667995 C150.859926,126.292969 140.624975,136.527922 128.000001,136.527922 C115.375026,136.527922 105.140075,126.292969 105.140075,113.667995 C105.140075,101.042565 115.375026,90.8080696 128.000001,90.8080696 L128.000001,90.8080696 Z"
                                                fill="#c1babac4">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div
                                    class="w-12 h-12 bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30 dark:border-white/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="-4 0 264 264" version="1.1"
                                        preserveAspectRatio="xMidYMid">
                                        <g>
                                            <path
                                                d="M255.855641,59.619717 C255.950565,59.9710596 256,60.3333149 256,60.6972536 L256,117.265345 C256,118.743206 255.209409,120.108149 253.927418,120.843385 L206.448786,148.178786 L206.448786,202.359798 C206.448786,203.834322 205.665123,205.195421 204.386515,205.937838 L105.27893,262.990563 C105.05208,263.119455 104.804608,263.201946 104.557135,263.289593 C104.464333,263.320527 104.376687,263.377239 104.278729,263.403017 C103.585929,263.58546 102.857701,263.58546 102.164901,263.403017 C102.051476,263.372083 101.948363,263.310215 101.840093,263.26897 C101.613244,263.186479 101.376082,263.1143 101.159544,262.990563 L2.07258227,205.937838 C0.7913718,205.201819 0,203.837372 0,202.359798 L0,32.6555248 C0,32.2843161 0.0515567729,31.9234187 0.144358964,31.5728326 C0.175293028,31.454252 0.24747251,31.3459828 0.288717928,31.2274022 C0.366053087,31.0108638 0.438232569,30.7891697 0.55165747,30.5880982 C0.628992629,30.4540506 0.742417529,30.3457814 0.83521972,30.2220451 C0.953800298,30.0570635 1.06206952,29.8869261 1.20127281,29.7425672 C1.31985339,29.6239866 1.4745237,29.5363401 1.60857131,29.4332265 C1.75808595,29.3094903 1.89213356,29.1754427 2.06227091,29.0774848 L2.06742659,29.0774848 L51.6134853,0.551122364 C52.8901903,-0.183535768 54.4613221,-0.183535768 55.7380271,0.551122364 L105.284086,29.0774848 L105.294397,29.0774848 C105.459379,29.1805983 105.598582,29.3094903 105.748097,29.4280708 C105.882144,29.5311844 106.031659,29.6239866 106.15024,29.7374115 C106.294599,29.8869261 106.397712,30.0570635 106.521448,30.2220451 C106.609095,30.3457814 106.727676,30.4540506 106.799855,30.5880982 C106.918436,30.7943253 106.985459,31.0108638 107.06795,31.2274022 C107.109196,31.3459828 107.181375,31.454252 107.212309,31.5779883 C107.307234,31.9293308 107.355765,32.2915861 107.356668,32.6555248 L107.356668,138.651094 L148.643332,114.878266 L148.643332,60.6920979 C148.643332,60.3312005 148.694889,59.9651474 148.787691,59.619717 C148.823781,59.4959808 148.890804,59.3877116 148.93205,59.269131 C149.014541,59.0525925 149.08672,58.8308984 149.200145,58.629827 C149.27748,58.4957794 149.390905,58.3875102 149.478552,58.2637739 C149.602288,58.0987922 149.705401,57.9286549 149.84976,57.7842959 C149.968341,57.6657153 150.117856,57.5780688 150.251903,57.4749553 C150.406573,57.351219 150.540621,57.2171714 150.705603,57.1192136 L150.710758,57.1192136 L200.261973,28.5928511 C201.538395,27.8571345 203.110093,27.8571345 204.386515,28.5928511 L253.932573,57.1192136 C254.107866,57.2223271 254.241914,57.351219 254.396584,57.4697996 C254.525476,57.5729132 254.674991,57.6657153 254.793572,57.7791402 C254.93793,57.9286549 255.041044,58.0987922 255.16478,58.2637739 C255.257582,58.3875102 255.371007,58.4957794 255.443187,58.629827 C255.561767,58.8308984 255.628791,59.0525925 255.711282,59.269131 C255.757683,59.3877116 255.824707,59.4959808 255.855641,59.619717 Z M247.740605,114.878266 L247.740605,67.8378666 L230.402062,77.8192579 L206.448786,91.6106946 L206.448786,138.651094 L247.745761,114.878266 L247.740605,114.878266 Z M198.194546,199.97272 L198.194546,152.901386 L174.633101,166.357704 L107.351512,204.757188 L107.351512,252.27191 L198.194546,199.97272 Z M8.25939501,39.7961379 L8.25939501,199.97272 L99.0921175,252.266755 L99.0921175,204.762344 L51.6392637,177.906421 L51.6237967,177.89611 L51.603174,177.885798 C51.443348,177.792996 51.3093004,177.658949 51.1597857,177.545524 C51.0308938,177.44241 50.8813791,177.359919 50.7679542,177.246494 L50.7576429,177.231027 C50.6235953,177.102135 50.5307931,176.942309 50.4173682,176.79795 C50.3142546,176.658747 50.1905184,176.540167 50.1080276,176.395808 L50.1028719,176.380341 C50.0100697,176.22567 49.9533572,176.040066 49.8863334,175.864773 C49.8193096,175.710103 49.7316631,175.565744 49.6904177,175.400762 L49.6904177,175.395606 C49.6388609,175.19969 49.6285496,174.993463 49.6079269,174.792392 C49.5873041,174.637722 49.5460587,174.483051 49.5460587,174.328381 L49.5460587,174.31807 L49.5460587,63.5689658 L25.5979377,49.7723734 L8.25939501,39.8012935 L8.25939501,39.7961379 Z M53.6809119,8.89300821 L12.3994039,32.6555248 L53.6706006,56.4180414 L94.9469529,32.6503692 L53.6706006,8.89300821 L53.6809119,8.89300821 Z M75.1491521,157.19091 L99.0972731,143.404629 L99.0972731,39.7961379 L81.7587304,49.7775291 L57.8054537,63.5689658 L57.8054537,167.177457 L75.1491521,157.19091 Z M202.324244,36.934737 L161.047891,60.6972536 L202.324244,84.4597702 L243.59544,60.6920979 L202.324244,36.934737 Z M198.194546,91.6106946 L174.24127,77.8192579 L156.902727,67.8378666 L156.902727,114.878266 L180.850848,128.664547 L198.194546,138.651094 L198.194546,91.6106946 Z M103.216659,197.616575 L163.759778,163.052915 L194.023603,145.781396 L152.778185,122.034346 L105.289242,149.374903 L62.0073307,174.292291 L103.216659,197.616575 Z"
                                                fill="#c1babac4">
                                            </path>
                                        </g>
                                    </svg>

                                </div>
                            </div>

                            <!-- Documentation Button -->
                            <button
                                class="bg-white dark:bg-slate-800 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-slate-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center gap-2 mx-auto animate-fade-in animation-delay-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                Documentación
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Footer - Architecture -->
                <div
                    class="px-4 lg:px-8 py-4 dark:bg-slate-900/50 border-t border-slate-200/50 dark:border-slate-700/50">
                    <div class="w-full">
                        <h3
                            class="text-base lg:text-lg font-semibold mb-4 text-slate-700 dark:text-slate-200 text-center animate-fade-in animation-delay-800">
                            Arquitectura Redvel
                        </h3>

                        <div class="flex justify-center">
                            <div class="relative overflow-x-auto pb-2">
                                <div class="flex flex-nowrap items-center justify-center gap-1 lg:gap-3 px-2">
                                    <!-- Database -->
                                    <div
                                        class="flex flex-col items-center gap-1 w-16 lg:w-20 animate-slide-in-up animation-delay-1000">
                                        <div
                                            class="w-10 h-10 lg:w-12 lg:h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center icon-hover">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                viewBox="0 0 32 32">
                                                <title>file_type_mysql</title>
                                                <path
                                                    d="M8.785,6.865a3.055,3.055,0,0,0-.785.1V7h.038a6.461,6.461,0,0,0,.612.785c.154.306.288.611.441.917.019-.019.038-.039.038-.039a1.074,1.074,0,0,0,.4-.957,4.314,4.314,0,0,1-.23-.4c-.115-.191-.364-.287-.517-.44"
                                                    style="fill:#5d87a1;fill-rule:evenodd" />
                                                <path
                                                    d="M27.78,23.553a8.849,8.849,0,0,0-3.712.536c-.287.115-.745.115-.785.478.154.153.172.4.307.613a4.467,4.467,0,0,0,.995,1.167c.4.306.8.611,1.225.879.745.461,1.588.728,2.314,1.187.422.268.842.612,1.264.9.21.153.343.4.611.5v-.058a3.844,3.844,0,0,0-.291-.613c-.191-.19-.383-.363-.575-.554a9.118,9.118,0,0,0-1.99-1.932c-.613-.422-1.953-1-2.2-1.7l-.039-.039a7.69,7.69,0,0,0,1.321-.308c.65-.172,1.243-.133,1.912-.3.307-.077.862-.268.862-.268v-.3c-.342-.34-.587-.795-.947-1.116a25.338,25.338,0,0,0-3.122-2.328c-.587-.379-1.344-.623-1.969-.946-.226-.114-.6-.17-.737-.36a7.594,7.594,0,0,1-.776-1.457c-.548-1.04-1.079-2.193-1.551-3.293a20.236,20.236,0,0,0-.965-2.157A19.078,19.078,0,0,0,11.609,5a9.07,9.07,0,0,0-2.421-.776c-.474-.02-.946-.057-1.419-.075A7.55,7.55,0,0,1,6.9,3.485C5.818,2.8,3.038,1.328,2.242,3.277,1.732,4.508,3,5.718,3.435,6.343A8.866,8.866,0,0,1,4.4,7.762c.133.322.171.663.3,1A22.556,22.556,0,0,0,5.687,11.3a8.946,8.946,0,0,0,.7,1.172c.153.209.417.3.474.645a5.421,5.421,0,0,0-.436,1.419,8.336,8.336,0,0,0,.549,6.358c.3.473,1.022,1.514,1.987,1.116.851-.34.662-1.419.908-2.364.056-.229.019-.379.132-.53V19.3s.483,1.061.723,1.6a10.813,10.813,0,0,0,2.4,2.59A3.514,3.514,0,0,1,14,24.657V25h.427A1.054,1.054,0,0,0,14,24.212a9.4,9.4,0,0,1-.959-1.16,24.992,24.992,0,0,1-2.064-3.519c-.3-.6-.553-1.258-.793-1.857-.11-.231-.11-.58-.295-.7a7.266,7.266,0,0,0-.884,1.313,11.419,11.419,0,0,0-.517,2.921c-.073.02-.037,0-.073.038-.589-.155-.792-.792-1.014-1.332a8.756,8.756,0,0,1-.166-5.164c.128-.405.683-1.681.461-2.068-.111-.369-.48-.58-.682-.871a7.767,7.767,0,0,1-.663-1.237C5.912,9.5,5.69,8.3,5.212,7.216a10.4,10.4,0,0,0-.921-1.489A9.586,9.586,0,0,1,3.276,4.22c-.092-.213-.221-.561-.074-.793a.3.3,0,0,1,.259-.252c.238-.212.921.058,1.16.174a9.2,9.2,0,0,1,1.824.967c.258.194.866.685.866.685h.18c.612.133,1.3.037,1.876.21a12.247,12.247,0,0,1,2.755,1.32,16.981,16.981,0,0,1,5.969,6.545c.23.439.327.842.537,1.3.4.94.9,1.9,1.3,2.814a12.578,12.578,0,0,0,1.36,2.564c.286.4,1.435.612,1.952.822a13.7,13.7,0,0,1,1.32.535c.651.4,1.3.861,1.913,1.3.305.23,1.262.708,1.32,1.091"
                                                    style="fill:#00758f;fill-rule:evenodd" />
                                            </svg>
                                        </div>
                                        <div class="text-center">
                                            <p
                                                class="font-medium text-slate-800 dark:text-slate-200 text-xs lg:text-sm">
                                                Database</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 hidden lg:block">
                                                MySQL,
                                                PostgreSQL</p>
                                        </div>
                                    </div>

                                    <!-- Arrow 1 -->
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 text-slate-400 dark:text-slate-500 animate-pulse animation-delay-1200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m8 12 4 4 4-4"></path>
                                    </svg>

                                    <!-- Laravel -->
                                    <div
                                        class="flex flex-col items-center gap-1 w-16 lg:w-20 animate-slide-in-up animation-delay-1100">
                                        <div
                                            class="w-10 h-10 lg:w-12 lg:h-12 bg-red-100 dark:bg-red-900/50 rounded-lg flex items-center justify-center icon-hover">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                height="24px" viewBox="-4 0 264 264" version="1.1"
                                                preserveAspectRatio="xMidYMid">
                                                <g>
                                                    <path
                                                        d="M255.855641,59.619717 C255.950565,59.9710596 256,60.3333149 256,60.6972536 L256,117.265345 C256,118.743206 255.209409,120.108149 253.927418,120.843385 L206.448786,148.178786 L206.448786,202.359798 C206.448786,203.834322 205.665123,205.195421 204.386515,205.937838 L105.27893,262.990563 C105.05208,263.119455 104.804608,263.201946 104.557135,263.289593 C104.464333,263.320527 104.376687,263.377239 104.278729,263.403017 C103.585929,263.58546 102.857701,263.58546 102.164901,263.403017 C102.051476,263.372083 101.948363,263.310215 101.840093,263.26897 C101.613244,263.186479 101.376082,263.1143 101.159544,262.990563 L2.07258227,205.937838 C0.7913718,205.201819 0,203.837372 0,202.359798 L0,32.6555248 C0,32.2843161 0.0515567729,31.9234187 0.144358964,31.5728326 C0.175293028,31.454252 0.24747251,31.3459828 0.288717928,31.2274022 C0.366053087,31.0108638 0.438232569,30.7891697 0.55165747,30.5880982 C0.628992629,30.4540506 0.742417529,30.3457814 0.83521972,30.2220451 C0.953800298,30.0570635 1.06206952,29.8869261 1.20127281,29.7425672 C1.31985339,29.6239866 1.4745237,29.5363401 1.60857131,29.4332265 C1.75808595,29.3094903 1.89213356,29.1754427 2.06227091,29.0774848 L2.06742659,29.0774848 L51.6134853,0.551122364 C52.8901903,-0.183535768 54.4613221,-0.183535768 55.7380271,0.551122364 L105.284086,29.0774848 L105.294397,29.0774848 C105.459379,29.1805983 105.598582,29.3094903 105.748097,29.4280708 C105.882144,29.5311844 106.031659,29.6239866 106.15024,29.7374115 C106.294599,29.8869261 106.397712,30.0570635 106.521448,30.2220451 C106.609095,30.3457814 106.727676,30.4540506 106.799855,30.5880982 C106.918436,30.7943253 106.985459,31.0108638 107.06795,31.2274022 C107.109196,31.3459828 107.181375,31.454252 107.212309,31.5779883 C107.307234,31.9293308 107.355765,32.2915861 107.356668,32.6555248 L107.356668,138.651094 L148.643332,114.878266 L148.643332,60.6920979 C148.643332,60.3312005 148.694889,59.9651474 148.787691,59.619717 C148.823781,59.4959808 148.890804,59.3877116 148.93205,59.269131 C149.014541,59.0525925 149.08672,58.8308984 149.200145,58.629827 C149.27748,58.4957794 149.390905,58.3875102 149.478552,58.2637739 C149.602288,58.0987922 149.705401,57.9286549 149.84976,57.7842959 C149.968341,57.6657153 150.117856,57.5780688 150.251903,57.4749553 C150.406573,57.351219 150.540621,57.2171714 150.705603,57.1192136 L150.710758,57.1192136 L200.261973,28.5928511 C201.538395,27.8571345 203.110093,27.8571345 204.386515,28.5928511 L253.932573,57.1192136 C254.107866,57.2223271 254.241914,57.351219 254.396584,57.4697996 C254.525476,57.5729132 254.674991,57.6657153 254.793572,57.7791402 C254.93793,57.9286549 255.041044,58.0987922 255.16478,58.2637739 C255.257582,58.3875102 255.371007,58.4957794 255.443187,58.629827 C255.561767,58.8308984 255.628791,59.0525925 255.711282,59.269131 C255.757683,59.3877116 255.824707,59.4959808 255.855641,59.619717 Z M247.740605,114.878266 L247.740605,67.8378666 L230.402062,77.8192579 L206.448786,91.6106946 L206.448786,138.651094 L247.745761,114.878266 L247.740605,114.878266 Z M198.194546,199.97272 L198.194546,152.901386 L174.633101,166.357704 L107.351512,204.757188 L107.351512,252.27191 L198.194546,199.97272 Z M8.25939501,39.7961379 L8.25939501,199.97272 L99.0921175,252.266755 L99.0921175,204.762344 L51.6392637,177.906421 L51.6237967,177.89611 L51.603174,177.885798 C51.443348,177.792996 51.3093004,177.658949 51.1597857,177.545524 C51.0308938,177.44241 50.8813791,177.359919 50.7679542,177.246494 L50.7576429,177.231027 C50.6235953,177.102135 50.5307931,176.942309 50.4173682,176.79795 C50.3142546,176.658747 50.1905184,176.540167 50.1080276,176.395808 L50.1028719,176.380341 C50.0100697,176.22567 49.9533572,176.040066 49.8863334,175.864773 C49.8193096,175.710103 49.7316631,175.565744 49.6904177,175.400762 L49.6904177,175.395606 C49.6388609,175.19969 49.6285496,174.993463 49.6079269,174.792392 C49.5873041,174.637722 49.5460587,174.483051 49.5460587,174.328381 L49.5460587,174.31807 L49.5460587,63.5689658 L25.5979377,49.7723734 L8.25939501,39.8012935 L8.25939501,39.7961379 Z M53.6809119,8.89300821 L12.3994039,32.6555248 L53.6706006,56.4180414 L94.9469529,32.6503692 L53.6706006,8.89300821 L53.6809119,8.89300821 Z M75.1491521,157.19091 L99.0972731,143.404629 L99.0972731,39.7961379 L81.7587304,49.7775291 L57.8054537,63.5689658 L57.8054537,167.177457 L75.1491521,157.19091 Z M202.324244,36.934737 L161.047891,60.6972536 L202.324244,84.4597702 L243.59544,60.6920979 L202.324244,36.934737 Z M198.194546,91.6106946 L174.24127,77.8192579 L156.902727,67.8378666 L156.902727,114.878266 L180.850848,128.664547 L198.194546,138.651094 L198.194546,91.6106946 Z M103.216659,197.616575 L163.759778,163.052915 L194.023603,145.781396 L152.778185,122.034346 L105.289242,149.374903 L62.0073307,174.292291 L103.216659,197.616575 Z"
                                                        fill="#FF2D20">

                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="text-center">
                                            <p
                                                class="font-medium text-slate-800 dark:text-slate-200 text-xs lg:text-sm">
                                                Laravel</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 hidden lg:block">
                                                Backend API</p>
                                        </div>
                                    </div>

                                    <!-- Arrow 2 -->
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 text-slate-400 dark:text-slate-500 animate-pulse animation-delay-1300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m8 12 4 4 4-4"></path>
                                    </svg>

                                    <!-- Axios -->
                                    <div
                                        class="flex flex-col items-center gap-1 w-16 lg:w-20 animate-slide-in-up animation-delay-1200">
                                        <div
                                            class="w-10 h-10 lg:w-12 lg:h-12 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center icon-hover">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" height="25px"
                                                width="168px" viewBox="0 0.28100000000000047 187.975 27.399">
                                                <g fill="#5a29e4">
                                                    <path
                                                        d="M93.295 3.652l-6.939 5.653h4.532V27.68l2.407-1.939zM95.295 24.1l7.061-5.795h-4.659V.35l-2.402 1.673zM182.695 6.953c.8.416 1.376.768 1.728 1.056l2.496-4.752c-1.248-.768-2.752-1.456-4.512-2.064-1.728-.608-3.6-.912-5.616-.912-1.92 0-3.696.32-5.328.96-1.6.64-2.88 1.584-3.84 2.832-.928 1.248-1.392 2.8-1.392 4.656 0 2.08.656 3.68 1.968 4.8 1.344 1.088 3.392 1.984 6.144 2.688 2.208.576 3.984 1.104 5.328 1.584 1.376.448 2.064 1.2 2.064 2.256 0 1.568-1.472 2.352-4.416 2.352-1.472 0-2.864-.176-4.176-.528s-2.464-.784-3.456-1.296c-.96-.512-1.648-.976-2.064-1.392l-2.592 5.04c1.664 1.056 3.568 1.888 5.712 2.496s4.304.912 6.48.912c1.888 0 3.648-.256 5.28-.768 1.632-.544 2.944-1.408 3.936-2.592 1.024-1.216 1.536-2.816 1.536-4.8 0-1.632-.384-2.944-1.152-3.936-.736-1.024-1.808-1.84-3.216-2.448-1.376-.608-3.008-1.152-4.896-1.632-2.144-.512-3.776-.976-4.896-1.392-1.088-.416-1.632-1.12-1.632-2.112 0-1.696 1.504-2.544 4.512-2.544 1.12 0 2.208.16 3.264.48 1.056.288 1.968.64 2.736 1.056z" />
                                                    <path clip-rule="evenodd"
                                                        d="M132.182 27.497c-2.112 0-4.032-.368-5.76-1.104-1.728-.768-3.217-1.792-4.465-3.072a14.22 14.22 0 0 1-2.88-4.416 13.138 13.138 0 0 1-1.008-5.04c0-1.76.352-3.456 1.056-5.088a13.385 13.385 0 0 1 2.977-4.32 14.148 14.148 0 0 1 4.511-3.024c1.728-.736 3.616-1.104 5.664-1.104 2.112 0 4.033.4 5.761 1.2 1.728.768 3.2 1.808 4.416 3.12a13.649 13.649 0 0 1 2.879 4.368 13.003 13.003 0 0 1 1.009 4.992c0 1.76-.352 3.456-1.056 5.088a14.11 14.11 0 0 1-2.977 4.32c-1.248 1.248-2.735 2.24-4.463 2.976s-3.616 1.104-5.664 1.104zm-8.257-13.584c0 1.44.337 2.816 1.009 4.128a8.284 8.284 0 0 0 2.831 3.12c1.248.8 2.736 1.2 4.464 1.2 1.76 0 3.248-.416 4.464-1.248 1.217-.864 2.144-1.936 2.784-3.216.64-1.312.961-2.656.961-4.032 0-1.44-.336-2.8-1.008-4.08a7.812 7.812 0 0 0-2.881-3.072c-1.216-.8-2.671-1.2-4.367-1.2-1.76 0-3.265.416-4.513 1.248a8.276 8.276 0 0 0-2.784 3.168 8.804 8.804 0 0 0-.96 3.984zM0 27.305L11.712.473h4.752l11.664 26.832h-6.144l-2.688-6.288H8.88l-2.688 6.288zM14.112 7.529l-3.936 8.448h7.728z"
                                                        fill-rule="evenodd" />
                                                    <path
                                                        d="M50.821.473l7.392 9.504L65.605.473h6.288L61.285 14.057l10.272 13.248H65.27l-7.056-9.12-7.008 9.12h-6.384l10.32-13.248L44.485.473z" />
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="text-center">
                                            <p
                                                class="font-medium text-slate-800 dark:text-slate-200 text-xs lg:text-sm">
                                                Axios</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 hidden lg:block">HTTP
                                                Client</p>
                                        </div>
                                    </div>

                                    <!-- Arrow 3 -->
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 text-slate-400 dark:text-slate-500 animate-pulse animation-delay-1400"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m8 12 4 4 4-4"></path>
                                    </svg>

                                    <!-- TanStack Query -->
                                    <div
                                        class="flex flex-col items-center gap-1 w-16 lg:w-20 animate-slide-in-up animation-delay-1300">
                                        <div
                                            class="w-10 h-10 lg:w-12 lg:h-12 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center icon-hover">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="25px"
                                                height="25px" viewBox="0 0 256 230" version="1.1"
                                                preserveAspectRatio="xMidYMid">
                                                <title>React Query</title>
                                                <g>
                                                    <path
                                                        d="M157.980086,142.487022 L153.069644,151.013778 C151.590359,153.58242 148.851879,155.165468 145.887725,155.165468 L108.270548,155.165468 C105.306395,155.165468 102.567914,153.58242 101.088629,151.013778 L96.1777266,142.487022 L157.980086,142.487022 Z M171.727194,118.616863 L163.068777,133.650878 L91.0890359,133.650878 L82.4310791,118.616863 L171.727194,118.616863 Z M163.386935,95.2748201 L171.741007,109.78118 L82.4172662,109.78118 L90.7713381,95.2748201 L163.386935,95.2748201 Z M145.887725,73.2086331 C148.851879,73.2086331 151.590359,74.7916804 153.069644,77.3603227 L158.298245,86.4386762 L95.8600287,86.4386762 L101.088629,77.3603227 C102.567914,74.7916804 105.306395,73.2086331 108.270548,73.2086331 L145.887725,73.2086331 Z"
                                                        fill="#00435B" />
                                                    <path
                                                        d="M53.5228243,69.2519666 C49.3557543,49.046027 48.4614888,33.5482436 51.1550425,22.2946934 C52.7570141,15.6017254 55.6858056,10.1416955 60.1392594,6.20237896 C64.8409457,2.0434872 70.7853914,0.00271399669 77.464599,0.00271399669 C88.4833026,0.00271399669 100.066708,5.02738845 112.445608,14.5729445 C117.494731,18.4663991 122.735073,23.1593458 128.177383,28.6544179 C128.610547,28.0967615 129.100183,27.5707574 129.645716,27.0846114 C145.032058,13.3732532 157.986014,4.85421104 169.065645,1.56952494 C175.653591,-0.383548437 181.838857,-0.569619914 187.471409,1.32590625 C193.416935,3.32675759 198.15432,7.46280771 201.496675,13.2560937 C207.012767,22.8171061 208.467426,35.3803455 206.410907,50.8927245 C205.572649,57.2157177 204.139587,64.103296 202.114822,71.5660814 C202.878713,71.6583298 203.644518,71.8277005 204.402582,72.078912 C223.924455,78.5481835 237.747984,85.5050986 246.117081,93.455615 C251.09648,98.1859692 254.348089,103.452282 255.523523,109.281738 C256.764195,115.434739 255.554443,121.606357 252.21598,127.395333 C246.710179,136.942525 236.586635,144.472296 222.164328,150.436421 C216.37329,152.831216 209.821074,155.000103 202.500392,156.950715 C202.834427,157.704922 203.093586,158.505888 203.266881,159.346186 C207.433951,179.552126 208.328217,195.049909 205.634663,206.303459 C204.032691,212.996427 201.1039,218.456457 196.650446,222.395774 C191.94876,226.554666 186.004314,228.595439 179.325107,228.595439 C168.306403,228.595439 156.722997,223.570764 144.344098,214.025209 C139.241235,210.090314 133.943061,205.338818 128.438479,199.768003 C127.872101,200.653965 127.176715,201.477453 126.354284,202.210353 C110.967942,215.921711 98.0139856,224.440753 86.9343548,227.725439 C80.3464094,229.678512 74.1611432,229.864584 68.5285912,227.969058 C62.5830653,225.968206 57.8456799,221.832156 54.5033245,216.03887 C48.9872327,206.477858 47.5325739,193.914618 49.5890933,178.402239 C50.4576511,171.850687 51.9647931,164.692994 54.1070674,156.917346 C53.2696983,156.832501 52.4289017,156.65542 51.5974183,156.379879 C32.0755448,149.910607 18.2520163,142.953692 9.88291895,135.003176 C4.90351995,130.272821 1.65191076,125.006509 0.476476948,119.177053 C-0.76419548,113.024052 0.445556656,106.852434 3.78402002,101.063457 C9.28982045,91.5162659 19.4133646,83.9864941 33.8356726,78.0223691 C39.7992613,75.556218 46.5700659,73.3296382 54.1560449,71.3342936 C53.8857623,70.6726423 53.6723366,69.9769434 53.5228243,69.2519666 Z"
                                                        fill="#002B3B" />
                                                    <path
                                                        d="M189.647082,161.332552 C191.588117,160.988559 193.448154,162.232965 193.881519,164.142164 L193.905355,164.25523 L194.112185,165.329619 C200.82206,200.606276 196.095493,218.244604 179.932483,218.244604 C164.118603,218.244604 143.987753,203.193799 119.539933,173.09219 C118.999764,172.427101 118.70835,171.594508 118.715576,170.737729 C118.733331,168.741874 120.335,167.130688 122.316684,167.087425 L122.431425,167.086678 L123.718886,167.095808 C134.00664,167.151581 144.007879,166.792879 153.722602,166.019701 C165.1903,165.107007 177.165126,163.544623 189.647082,161.332552 Z M78.6458633,134.666898 L78.7078446,134.771519 L79.3538232,135.898918 C84.5306616,144.89904 89.9242479,153.441244 95.5345809,161.52553 C102.141724,171.04618 109.571769,180.684341 117.824717,190.440012 C119.101455,191.949222 118.955699,194.189372 117.515334,195.521636 L117.421639,195.605425 L116.591258,196.320149 C89.2852865,219.716955 71.5374632,224.387736 63.3477884,210.332492 C55.3313515,196.574563 58.2377577,171.558816 72.0670066,135.285251 C72.3708961,134.488162 72.9420247,133.821259 73.6828929,133.398394 C75.4143371,132.410139 77.6096238,132.980798 78.6458633,134.666898 Z M203.503403,82.6131343 L203.615296,82.6495484 L204.643048,83.0044846 C238.347807,94.729024 251.153123,107.613829 243.058996,121.658899 C235.142689,135.395415 212.128983,145.396769 174.017881,151.66296 C173.167999,151.802697 172.296021,151.640191 171.553528,151.203694 C169.79981,150.172718 169.213912,147.915277 170.244889,146.16156 C175.703461,136.876387 180.619696,127.637538 184.993594,118.445014 C189.954111,108.019605 194.609306,96.8294082 198.959178,84.8744237 C199.618683,83.061871 201.556008,82.0774197 203.391185,82.580471 L203.503403,82.6131343 Z M84.4464723,76.7099745 C86.2001901,77.740951 86.7860876,79.9983917 85.7551111,81.7521091 C80.2965391,91.0372816 75.3803041,100.27613 71.006406,109.468655 C66.0458889,119.894064 61.3906942,131.084261 57.0408219,143.039245 C56.3678577,144.888789 54.3643854,145.876086 52.4965968,145.300535 L52.384704,145.264121 L51.3569514,144.909184 C17.6521928,133.184645 4.84687687,120.29984 12.9410033,106.25477 C20.8573114,92.5182536 43.8710165,82.5168999 81.9821186,76.2507092 C82.8320004,76.1109723 83.7039793,76.2734775 84.4464723,76.7099745 Z M192.652212,18.9624716 C200.668648,32.7204007 197.762242,57.7361478 183.932993,94.0097128 C183.629104,94.8068024 183.057975,95.4737045 182.317107,95.8965695 C180.585663,96.8848251 178.390376,96.3141662 177.354137,94.6280655 L177.292155,94.5234449 L176.646177,93.396046 C171.469338,84.3959235 166.075752,75.8537196 160.465419,67.7694342 C153.858276,58.2487836 146.428231,48.6106226 138.175283,38.8549521 C136.898545,37.3457421 137.044301,35.1055922 138.484666,33.7733281 L138.578361,33.6895387 L139.408742,32.9748146 C166.714713,9.5780092 184.462537,4.90722821 192.652212,18.9624716 Z M77.4488122,10.5899281 C93.2626919,10.5899281 113.393541,25.6407329 137.841362,55.7423424 C138.381531,56.4074313 138.672945,57.2400244 138.665719,58.0968034 C138.647964,60.0926579 137.046295,61.7038447 135.064611,61.7471068 L134.94987,61.7478547 L133.662408,61.7387247 C123.374654,61.6829511 113.373416,62.0416532 103.658693,62.8148314 C92.1909953,63.7275257 80.2161685,65.2899089 67.7342126,67.5019801 C65.7931775,67.8459735 63.933141,66.601567 63.4997758,64.6923678 L63.4759394,64.5793022 L63.2691102,63.5049136 C56.5592347,28.2282565 61.285802,10.5899281 77.4488122,10.5899281 Z"
                                                        fill="#FF4154" />
                                                    <g transform="translate(80.575540, 73.669065)" fill="#FFD94C">
                                                        <path
                                                            d="M30.7189861,-1.39989681e-23 L62.2949309,-1.39989681e-23 C66.9127505,-1.39989681e-23 71.1778947,2.46984572 73.4764482,6.47495629 L89.3310931,34.1008556 C91.6118515,38.0749594 91.6118515,42.9610118 89.3310931,46.9351155 L73.4764482,74.5610148 C71.1778947,78.5661256 66.9127505,81.0359712 62.2949309,81.0359712 L30.7189861,81.0359712 C26.1011664,81.0359712 21.8360221,78.5661256 19.5374686,74.5610148 L3.68282375,46.9351155 C1.40206522,42.9610118 1.40206522,38.0749594 3.68282375,34.1008556 L19.5374686,6.47495629 C21.8360221,2.46984572 26.1011664,-1.39989681e-23 30.7189861,-1.39989681e-23 Z M57.4824555,8.33810638 C62.102714,8.33810638 66.369722,10.8105395 68.667368,14.818982 L79.7231631,34.106775 C81.999395,38.0778585 81.999395,42.9581127 79.7231631,46.9291962 L68.667368,66.216989 C66.369722,70.2254319 62.102714,72.6978647 57.4824555,72.6978647 L35.5314612,72.6978647 C30.9112026,72.6978647 26.6441947,70.2254319 24.3465487,66.216989 L13.2907533,46.9291962 C11.0145216,42.9581127 11.0145216,38.0778585 13.2907533,34.106775 L24.3465487,14.818982 C26.6441947,10.8105395 30.9112026,8.33810638 35.5314612,8.33810638 L57.4824555,8.33810638 Z M52.295383,17.4579102 L40.7185336,17.4579102 C36.1030177,17.4579102 31.8396344,19.925313 29.5402263,23.9272762 L29.5402263,23.9272762 L23.6980045,34.0952652 C21.4129658,38.0722196 21.4129658,42.9637516 23.6980045,46.9407061 L23.6980045,46.9407061 L29.5402263,57.108695 C31.8396344,61.1106583 36.1030177,63.5780609 40.7185336,63.5780609 L40.7185336,63.5780609 L52.295383,63.5780609 C56.9108991,63.5780609 61.1742821,61.1106583 63.4736902,57.108695 L63.4736902,57.108695 L69.3159123,46.9407061 C71.6009508,42.9637516 71.6009508,38.0722196 69.3159123,34.0952652 L69.3159123,34.0952652 L63.4736902,23.9272762 C61.1742821,19.925313 56.9108991,17.4579102 52.295383,17.4579102 L52.295383,17.4579102 Z M47.3007539,26.1868653 C51.9128126,26.1868653 56.1735523,28.6506045 58.4742386,32.6478447 L59.3025013,34.0868787 C61.5939706,38.0681056 61.5939706,42.9678656 59.3025013,46.9490924 L58.4742386,48.3881264 C56.1735523,52.3853665 51.9128126,54.8491059 47.3007539,54.8491059 L45.7131627,54.8491059 C41.101104,54.8491059 36.8403644,52.3853665 34.5396783,48.3881264 L33.7114156,46.9490924 C31.4199463,42.9678656 31.4199463,38.0681056 33.7114156,34.0868787 L34.5396783,32.6478447 C36.8403644,28.6506045 41.101104,26.1868653 45.7131627,26.1868653 L47.3007539,26.1868653 Z M46.5090408,34.7855375 C44.4563249,34.7855375 42.5632677,35.8780363 41.5383478,37.6517615 C40.5136007,39.4251878 40.5136007,41.6107834 41.5383478,43.3842097 C42.5632677,45.1579349 44.4563249,46.2504338 46.5048762,46.2504338 L46.5048762,46.2504338 C48.5575919,46.2504338 50.4506488,45.1579349 51.4755688,43.3842097 C52.5003161,41.6107834 52.5003161,39.4251878 51.4755688,37.6517615 C50.4506488,35.8780363 48.5575919,34.7855375 46.5090408,34.7855375 L46.5090408,34.7855375 Z M2.01124849e-22,40.5179856 L10.3208271,40.5179856" />
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="text-center">
                                            <p
                                                class="font-medium text-slate-800 dark:text-slate-200 text-xs lg:text-sm">
                                                TanStack</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 hidden lg:block">Data
                                                Fetching</p>
                                        </div>
                                    </div>

                                    <!-- Arrow 4 -->
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 text-slate-400 dark:text-slate-500 animate-pulse animation-delay-1500"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m8 12 4 4 4-4"></path>
                                    </svg>

                                    <!-- React + Router -->
                                    <div
                                        class="flex flex-col items-center gap-1 w-16 lg:w-20 animate-slide-in-up animation-delay-1400">
                                        <div
                                            class="w-10 h-10 lg:w-12 lg:h-12 bg-gray-100 dark:bg-gray-800/50 rounded-lg flex items-center justify-center icon-hover">
                                            <div class="flex items-center gap-0.5">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    xmlns:serif="http://www.serif.com/" width="24px" height="24px"
                                                    viewBox="0 0 64 64" version="1.1" xml:space="preserve"
                                                    style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">

                                                    <rect id="Icons" x="-1088" y="-64" width="1280"
                                                        height="800" style="fill:none;" />

                                                    <g id="Icons1" serif:id="Icons">

                                                        <g id="Strike">

                                                        </g>

                                                        <g id="H1">

                                                        </g>

                                                        <g id="H2">

                                                        </g>

                                                        <g id="H3">

                                                        </g>

                                                        <g id="list-ul">

                                                        </g>

                                                        <g id="hamburger-1">

                                                        </g>

                                                        <g id="hamburger-2">

                                                        </g>

                                                        <g id="list-ol">

                                                        </g>

                                                        <g id="list-task">

                                                        </g>

                                                        <g id="trash">

                                                        </g>

                                                        <g id="vertical-menu">

                                                        </g>

                                                        <g id="horizontal-menu">

                                                        </g>

                                                        <g id="sidebar-2">

                                                        </g>

                                                        <g id="Pen">

                                                        </g>

                                                        <g id="Pen1" serif:id="Pen">

                                                        </g>

                                                        <g id="clock">

                                                        </g>

                                                        <g id="external-link">

                                                        </g>

                                                        <g id="hr">

                                                        </g>

                                                        <g id="info">

                                                        </g>

                                                        <g id="warning">

                                                        </g>

                                                        <g id="plus-circle">

                                                        </g>

                                                        <g id="minus-circle">

                                                        </g>

                                                        <g id="vue">

                                                        </g>

                                                        <g id="cog">

                                                        </g>

                                                        <g id="logo">

                                                        </g>

                                                        <g id="radio-check">

                                                        </g>

                                                        <g id="eye-slash">

                                                        </g>

                                                        <g id="eye">

                                                        </g>

                                                        <g id="toggle-off">

                                                        </g>

                                                        <g id="shredder">

                                                        </g>

                                                        <g id="spinner--loading--dots-"
                                                            serif:id="spinner [loading, dots]">

                                                        </g>

                                                        <g id="react">

                                                            <circle cx="32.001" cy="31.955" r="4.478"
                                                                style="fill:#00d8ff;" />

                                                            <path
                                                                d="M32.33,22.516c7.635,0.052 15.965,0.609 21.683,5.708c0.168,0.15 0.33,0.306 0.488,0.467c1.349,1.375 2.054,3.595 0.965,5.422c-2.234,3.751 -7.23,5.387 -12.067,6.394c-7.234,1.506 -14.798,1.518 -22.029,0.192c-4.161,-0.764 -8.416,-2.103 -11.373,-4.904c-1.151,-1.09 -2.135,-2.524 -1.981,-4.12c0.25,-2.582 2.727,-4.239 4.812,-5.361c5.791,-3.116 12.847,-3.813 19.502,-3.798Zm-0.554,1.173c-7.224,0.049 -15.043,0.51 -20.621,5.129c-0.195,0.161 -0.383,0.33 -0.564,0.507c-0.117,0.114 -0.23,0.233 -0.339,0.355c-0.979,1.1 -1.316,2.867 -0.392,4.188c0.93,1.329 2.342,2.288 3.796,3.07c5.438,2.924 11.864,3.443 18.129,3.465c6.343,0.023 12.884,-0.555 18.487,-3.452c2.232,-1.155 4.744,-2.851 4.655,-5.035c-0.082,-2.004 -2.036,-3.242 -3.499,-4.126c-0.396,-0.239 -0.803,-0.46 -1.216,-0.668c-5.562,-2.787 -12.08,-3.447 -18.436,-3.433Z"
                                                                style="fill:#00d8ff;" />

                                                            <path
                                                                d="M42.115,10.703c2.793,0.071 4.24,3.429 4.431,5.909c0.038,0.493 0.052,0.988 0.046,1.483c-0.006,0.536 -0.035,1.072 -0.082,1.606c-0.589,6.612 -3.608,12.909 -7.163,18.724c-3.477,5.688 -7.717,11.36 -13.485,13.996c-1.907,0.872 -4.175,1.41 -5.863,0.437c-2.314,-1.333 -2.567,-4.451 -2.524,-6.816c0.011,-0.581 0.049,-1.162 0.109,-1.741c0.889,-8.56 5.228,-16.669 10.658,-23.655c3.168,-4.076 6.937,-8.119 11.632,-9.583c0.739,-0.231 1.326,-0.371 2.241,-0.36Zm-0.134,1.172c-3.279,0.052 -6.223,2.482 -8.83,5.007c-6.854,6.637 -11.905,15.464 -13.937,24.721c-0.157,0.717 -0.289,1.439 -0.386,2.166c-0.075,0.563 -0.13,1.129 -0.159,1.697c-0.023,0.452 -0.031,0.905 -0.017,1.358c0.01,0.354 0.033,0.708 0.072,1.06c0.029,0.269 0.068,0.537 0.117,0.803c0.037,0.197 0.08,0.393 0.13,0.588c0.041,0.158 0.087,0.315 0.139,0.471c0.409,1.233 1.463,2.411 2.878,2.45c3.301,0.09 6.409,-2.317 9.096,-4.933c4.717,-4.591 8.232,-10.36 10.978,-16.424c2.216,-4.896 4.243,-10.218 3.111,-15.607c-0.043,-0.204 -0.093,-0.406 -0.15,-0.606c-0.047,-0.163 -0.1,-0.324 -0.158,-0.483c-0.44,-1.199 -1.475,-2.271 -2.884,-2.268Z"
                                                                style="fill:#00d8ff;" />

                                                            <path
                                                                d="M22.109,10.747c3.564,0.069 6.765,2.488 9.607,5.197c5.186,4.943 9.011,11.231 11.913,17.849c2.248,5.127 4.316,10.882 2.478,16.292c-0.579,1.705 -2.044,3.265 -3.997,3.305c-3.581,0.072 -6.9,-2.532 -9.78,-5.335c-7.225,-7.034 -12.589,-16.32 -14.427,-26.168c-0.132,-0.704 -0.237,-1.414 -0.309,-2.127c-0.059,-0.582 -0.096,-1.167 -0.106,-1.752c-0.008,-0.472 0.002,-0.944 0.035,-1.414c0.022,-0.314 0.054,-0.626 0.097,-0.937c0.041,-0.292 0.093,-0.583 0.158,-0.871c0.043,-0.191 0.091,-0.38 0.146,-0.568c0.539,-1.843 1.941,-3.485 4.185,-3.471Zm-0.135,1.173c-2.087,0.046 -3.042,2.507 -3.234,4.234c-0.039,0.354 -0.063,0.711 -0.074,1.068c-0.014,0.456 -0.008,0.913 0.015,1.369c0.328,6.599 3.278,12.979 6.838,18.821c3.352,5.5 7.4,10.978 12.968,13.794c1.608,0.813 3.562,1.452 4.951,0.684c1.742,-0.964 1.956,-3.261 2.049,-4.973c0.025,-0.466 0.028,-0.934 0.013,-1.401c-0.018,-0.586 -0.064,-1.171 -0.133,-1.753c-0.642,-5.437 -3.05,-10.582 -5.816,-15.444c-3.442,-6.048 -7.659,-12.076 -13.627,-15.225c-1.236,-0.652 -2.574,-1.185 -3.95,-1.174Z"
                                                                style="fill:#00d8ff;" />

                                                        </g>

                                                        <g id="check-selected">

                                                        </g>

                                                        <g id="turn-off">

                                                        </g>

                                                        <g id="code-block">

                                                        </g>

                                                        <g id="user">

                                                        </g>

                                                        <g id="coffee-bean">

                                                        </g>

                                                        <g id="coffee-beans">

                                                            <g id="coffee-bean1" serif:id="coffee-bean">

                                                            </g>

                                                        </g>

                                                        <g id="coffee-bean-filled">

                                                        </g>

                                                        <g id="coffee-beans-filled">

                                                            <g id="coffee-bean2" serif:id="coffee-bean">

                                                            </g>

                                                        </g>

                                                        <g id="clipboard">

                                                        </g>

                                                        <g id="clipboard-paste">

                                                        </g>

                                                        <g id="clipboard-copy">

                                                        </g>

                                                        <g id="Layer1">

                                                        </g>

                                                    </g>

                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 -58 256 256" version="1.1"
                                                    preserveAspectRatio="xMidYMid">
                                                    <g>
                                                        <path
                                                            d="M78.0659341,92.5875806 C90.8837956,92.5875806 101.274726,82.1966508 101.274726,69.3787894 C101.274726,56.5609279 90.8837956,46.1699982 78.0659341,46.1699982 C65.2480726,46.1699982 54.8571429,56.5609279 54.8571429,69.3787894 C54.8571429,82.1966508 65.2480726,92.5875806 78.0659341,92.5875806 Z M23.2087913,139.005163 C36.0266526,139.005163 46.4175825,128.614233 46.4175825,115.796372 C46.4175825,102.97851 36.0266526,92.5875806 23.2087913,92.5875806 C10.3909298,92.5875806 0,102.97851 0,115.796372 C0,128.614233 10.3909298,139.005163 23.2087913,139.005163 Z M232.791209,139.005163 C245.60907,139.005163 256,128.614233 256,115.796372 C256,102.97851 245.60907,92.5875806 232.791209,92.5875806 C219.973347,92.5875806 209.582418,102.97851 209.582418,115.796372 C209.582418,128.614233 219.973347,139.005163 232.791209,139.005163 Z"
                                                            fill="#000000">

                                                        </path>
                                                        <path
                                                            d="M156.565464,70.3568084 C155.823426,62.6028163 155.445577,56.1490255 149.505494,51.6131676 C141.982638,45.8687002 133.461166,49.5960243 122.964463,45.8072968 C112.650326,43.3121427 105,34.1545727 105,23.2394367 C105,10.4046502 115.577888,0 128.626373,0 C138.29063,0 146.599638,5.70747659 150.259573,13.8825477 C155.861013,24.5221258 152.220489,35.3500418 159.258242,40.8041273 C167.591489,47.2621895 178.826167,42.5329154 191.362109,48.6517412 C195.390112,50.5026944 198.799584,53.4384578 201.202056,57.0769224 C203.604528,60.7153869 205,65.0565524 205,69.7183101 C205,80.633446 197.349674,89.7910161 187.035538,92.2861702 C176.538834,96.0748977 168.017363,92.3475736 160.494506,98.092041 C152.03503,104.551712 156.563892,115.358642 149.669352,126.774447 C145.756163,134.291567 137.802119,139.43662 128.626373,139.43662 C115.577888,139.43662 105,129.03197 105,116.197184 C105,106.873668 110.581887,98.832521 118.637891,95.1306146 C131.173833,89.0117889 142.408511,93.7410629 150.741758,87.2830007 C155.549106,83.5574243 156.565464,77.8102648 156.565464,70.3568084 Z"
                                                            fill="#D0021B">

                                                        </path>
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <p
                                                class="font-medium text-slate-800 dark:text-slate-200 text-xs lg:text-sm">
                                                React</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 hidden lg:block">UI &
                                                Router</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Theme Toggle Functionality
        const themeToggle = document.getElementById('theme-toggle');
        const sunIcon = document.querySelector('.sun-icon');
        const moonIcon = document.querySelector('.moon-icon');

        // Check for saved theme preference or default to light mode
        const currentTheme = localStorage.getItem('theme') || 'light';

        if (currentTheme === 'dark') {
            document.documentElement.classList.add('dark');
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
        }

        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');

            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            } else {
                localStorage.setItem('theme', 'light');
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            }
        });

        // Add smooth scroll behavior for buttons
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function(e) {
                // Add ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('[class*="animate-"]').forEach(el => {
            observer.observe(el);
        });
    </script>

    <style>
        /* Ripple effect for buttons */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        button {
            position: relative;
            overflow: hidden;
        }

        /* Smooth transitions for all interactive elements */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
</body>

</html>
