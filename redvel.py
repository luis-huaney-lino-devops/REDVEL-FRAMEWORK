import os 
import sys
import subprocess
import shutil
import zipfile
import requests
from time import sleep
from colorama import init, Fore
import itertools
import threading
import re
import winreg
import ctypes
import io
import tempfile

init(autoreset=True)
stop_animation = False

def show_title():
    print(Fore.RED + """
██████╗ ███████╗██████╗ ██╗   ██╗███████╗██╗     
██╔══██╗██╔════╝██╔══██╗██║   ██║██╔════╝██║     
██████╔╝█████╗  ██║  ██║██║   ██║█████╗  ██║     
██╔══██╗██╔══╝  ██║  ██║╚██╗ ██╔╝██╔══╝  ██║     
██║  ██║███████╗██████╔╝ ╚████╔╝ ███████╗███████╗
╚═╝  ╚═╝╚══════╝╚═════╝   ╚═══╝  ╚══════╝╚══════╝
    """)
    print(Fore.YELLOW + 'El framework que combina la potencia de')
    print(Fore.BLUE + 'React')
    print(Fore.YELLOW + 'con la elegancia de ')
    print(Fore.RED + 'Laravel\n')

def animation(message):
    for frame in itertools.cycle(['⠋','⠙','⠚','⠞','⠖','⠦','⠴','⠲','⠳','⠓']):
        if stop_animation: break
        sys.stdout.write(Fore.CYAN + f"\r{message} {frame}")
        sys.stdout.flush()
        sleep(0.1)

def run_command(command, cwd=None, description=""):
    global stop_animation
    print(Fore.CYAN + f"🔧 {description}...")
    stop_animation = False
    anim_thread = threading.Thread(target=animation, args=(description,))
    anim_thread.start()

    try:
        subprocess.run(command, shell=True, check=True, cwd=cwd)
        stop_animation = True
        anim_thread.join()
        print(Fore.GREEN + f"\n✅ {description} completado.\n")
        return True
    except subprocess.CalledProcessError:
        stop_animation = True
        anim_thread.join()
        print(Fore.RED + f"\n❌ Error al ejecutar: {description}\n")
        return False

def check_version(command, min_version, name):
    """Verifica si una herramienta está instalada y tiene la versión mínima requerida"""
    try:
        result = subprocess.run(command, shell=True, capture_output=True, text=True)
        if result.returncode != 0:
            return False, "No instalado"
        
        output = result.stdout.strip()
        # Extraer número de versión usando regex
        version_match = re.search(r'(\d+\.\d+)', output)
        if not version_match:
            return False, "Versión no detectada"
        
        current_version = float(version_match.group(1))
        required_version = float(min_version)
        
        if current_version >= required_version:
            return True, current_version
        else:
            return False, current_version
            
    except Exception as e:
        return False, str(e)

def check_dependencies():
    """Verifica las dependencias del sistema"""
    print(Fore.CYAN + "🔍 Verificando dependencias del sistema...\n")
    
    dependencies = [
        ("php --version", "8.2", "PHP"),
        ("composer --version", "2.0", "Composer"),
        ("node --version", "22.0", "Node.js")
    ]
    
    missing_deps = []
    
    for command, min_version, name in dependencies:
        is_valid, version = check_version(command, min_version, name)
        
        if is_valid:
            print(Fore.GREEN + f"✅ {name} {version} - OK")
        else:
            print(Fore.RED + f"❌ {name} - {version}")
            missing_deps.append(name)
    
    if missing_deps:
        print(Fore.YELLOW + f"\n⚠️ Dependencias faltantes o con versión insuficiente:")
        for dep in missing_deps:
            print(Fore.YELLOW + f"   - {dep}")
        
        print(Fore.CYAN + "\nPor favor instala las dependencias faltantes y agrégalas al PATH antes de continuar.")
        print(Fore.CYAN + "Requisitos mínimos:")
        print(Fore.CYAN + "  - PHP 8.2+")
        print(Fore.CYAN + "  - Composer 2.0+")
        print(Fore.CYAN + "  - Node.js 22.0+")
        return False
    
    print(Fore.GREEN + "\n✅ Todas las dependencias están correctas.\n")
    return True

def add_to_path():
    """Añade el directorio actual al PATH del sistema en Windows"""
    if os.name != 'nt':  # Si no es Windows
        print(Fore.YELLOW + "⚠️ Esta función solo está disponible en Windows")
        return False
        
    try:
        # Obtener la ruta absoluta del directorio actual
        current_dir = os.path.abspath(os.path.dirname(sys.executable if getattr(sys, 'frozen', False) else __file__))
        
        # Abrir la clave del registro
        key = winreg.OpenKey(winreg.HKEY_CURRENT_USER, 'Environment', 0, winreg.KEY_ALL_ACCESS)
        
        # Obtener el PATH actual
        path_value, _ = winreg.QueryValueEx(key, 'Path')
        
        # Verificar si el directorio ya está en el PATH
        if current_dir not in path_value:
            # Añadir el directorio al PATH
            new_path = f"{path_value};{current_dir}"
            winreg.SetValueEx(key, 'Path', 0, winreg.REG_EXPAND_SZ, new_path)
            
            # Notificar al sistema del cambio
            ctypes.windll.user32.SendMessageW(0xFFFF, 0x001A, 0, 'Environment')
            
            print(Fore.GREEN + "✅ Directorio añadido al PATH correctamente")
            print(Fore.YELLOW + "⚠️ Es posible que necesites reiniciar la terminal para que los cambios surtan efecto")
            return True
        else:
            print(Fore.YELLOW + "⚠️ El directorio ya está en el PATH")
            return True
            
    except Exception as e:
        print(Fore.RED + f"❌ Error al añadir al PATH: {str(e)}")
        return False

def is_admin():
    """Verifica si el programa se está ejecutando como administrador"""
    try:
        return ctypes.windll.shell32.IsUserAnAdmin()
    except:
        return False

def run_as_admin():
    """Reinicia el programa con permisos de administrador"""
    if not is_admin():
        print(Fore.YELLOW + "⚠️ Se requieren permisos de administrador")
        if input(Fore.CYAN + "¿Deseas reiniciar como administrador? (s/n): ").lower() == "s":
            ctypes.windll.shell32.ShellExecuteW(None, "runas", sys.executable, " ".join(sys.argv), None, 1)
            sys.exit()
        return False
    return True

def clean_cache():
    """Limpia los archivos temporales y caché"""
    try:
        # Limpiar directorio temporal
        temp_dir = os.path.join(os.environ.get('TEMP', os.path.dirname(os.path.abspath(__file__))), 'redvel_temp')
        if os.path.exists(temp_dir):
            shutil.rmtree(temp_dir)
            print(Fore.GREEN + "✅ Caché temporal limpiado correctamente")
        
        # Limpiar archivos temporales en el directorio actual
        for item in os.listdir('.'):
            if item.endswith('.zip') or item == 'REDVEL-FRAMEWORK-main':
                try:
                    if os.path.isdir(item):
                        shutil.rmtree(item)
                    else:
                        os.remove(item)
                except Exception as e:
                    print(Fore.YELLOW + f"⚠️ No se pudo eliminar {item}: {str(e)}")
        
        print(Fore.GREEN + "✅ Limpieza completada")
        return True
    except Exception as e:
        print(Fore.RED + f"❌ Error al limpiar caché: {str(e)}")
        return False

def download_repository():
    """Descarga el repositorio REDVEL-FRAMEWORK"""
    repo_url = "https://github.com/luis-huaney-lino-devops/REDVEL-FRAMEWORK"
    zip_url = f"{repo_url}/archive/refs/heads/main.zip"
    extract_folder = "REDVEL-FRAMEWORK-main"
    
    print(Fore.CYAN + f"📥 Descargando repositorio desde: {repo_url}")
    
    try:
        # Descargar archivo en memoria
        response = requests.get(zip_url, stream=True)
        response.raise_for_status()
        
        total_size = int(response.headers.get('content-length', 0))
        downloaded = 0
        
        # Crear un archivo temporal en memoria
        zip_content = io.BytesIO()
        
        for chunk in response.iter_content(chunk_size=8192):
            if chunk:
                zip_content.write(chunk)
                downloaded += len(chunk)
                
                if total_size > 0:
                    progress = (downloaded / total_size) * 100
                    print(f"\r{Fore.CYAN}📥 Descargando... {progress:.1f}% ({downloaded}/{total_size} bytes)", end='')
        
        print(Fore.GREEN + "\n✅ Descarga completada")
        
        # Descomprimir desde memoria
        print(Fore.CYAN + "📦 Descomprimiendo archivo...")
        zip_content.seek(0)
        
        # Usar un directorio temporal del sistema
        with tempfile.TemporaryDirectory() as temp_dir:
            with zipfile.ZipFile(zip_content) as zip_ref:
                zip_ref.extractall(temp_dir)
            
            # Mover contenido a directorio actual
            extracted_path = os.path.join(temp_dir, extract_folder)
            if os.path.exists(extracted_path):
                for item in os.listdir(extracted_path):
                    src = os.path.join(extracted_path, item)
                    dst = os.path.join('.', item)
                    if os.path.exists(dst):
                        if os.path.isdir(dst):
                            shutil.rmtree(dst)
                        else:
                            os.remove(dst)
                    shutil.move(src, dst)
        
        # Verificar si las carpetas se crearon correctamente
        if os.path.exists("RedBack") and os.path.exists("RedFront"):
            print(Fore.GREEN + "✅ Repositorio descomprimido correctamente.\n")
            return True
        else:
            print(Fore.RED + "❌ Error: No se pudieron crear las carpetas necesarias")
            return False
        
    except Exception as e:
        # Verificar si las carpetas se crearon a pesar del error
        if os.path.exists("RedBack") and os.path.exists("RedFront"):
            print(Fore.YELLOW + f"\n⚠️ Hubo un error durante el proceso: {str(e)}")
            print(Fore.GREEN + "✅ Sin embargo, las carpetas necesarias se crearon correctamente.")
            return True
        else:
            print(Fore.RED + f"\n❌ Error al descargar el repositorio: {str(e)}")
            return False

def initial_menu():
    """Muestra el menú inicial cuando se ejecuta sin parámetros"""
    show_title()
    print(Fore.CYAN + "¿Qué deseas hacer?\n")
    print("1. Instalar framework")
    print("2. Descargar framework")
    print("3. Verificar dependencias")
    print("4. Limpiar caché")
    print("5. Abrir terminal interactiva")
    print("6. Salir")
    
    while True:
        try:
            choice = input(Fore.GREEN + "\nSelecciona una opción (1-6): ")
            
            if choice == "1":
                install()
                break
            elif choice == "2":
                download()
                break
            elif choice == "3":
                check()
                break
            elif choice == "4":
                clean_cache()
                break
            elif choice == "5":
                terminal()
                break
            elif choice == "6":
                print(Fore.YELLOW + "👋 ¡Hasta pronto!")
                sys.exit(0)
            else:
                print(Fore.RED + "❌ Opción inválida. Por favor, selecciona una opción del 1 al 6.")
        except KeyboardInterrupt:
            print(Fore.YELLOW + "\n👋 ¡Hasta pronto!")
            sys.exit(0)

def install():
    show_title()
    sleep(1)
    print(Fore.MAGENTA + "🚀 Iniciando instalación...\n")

    # Verificar si existen las carpetas necesarias
    if not os.path.exists("RedBack") or not os.path.exists("RedFront"):
        print(Fore.YELLOW + "⚠️ No se encontraron las carpetas RedBack y/o RedFront")
        if input(Fore.CYAN + "¿Deseas descargar el framework? (s/n): ").lower() == "s":
            if not download_repository():
                print(Fore.RED + "❌ No se pudo completar la descarga. Instalación cancelada.")
                return
        else:
            print(Fore.RED + "❌ Instalación cancelada")
            return

    # Verificar dependencias antes de instalar
    if not check_dependencies():
        return

    # Copiar .env.example a .env en RedBack
    if os.path.exists("RedBack"):
        env_example = os.path.join("RedBack", ".env.example")
        env_file = os.path.join("RedBack", ".env")
        if os.path.exists(env_example):
            shutil.copy2(env_example, env_file)
            print(Fore.GREEN + "✅ Archivo .env creado correctamente")

    if os.path.exists("RedFront"):
        run_command("npm install", cwd="RedFront", description="Instalando dependencias de frontend")
    else:
        print(Fore.YELLOW + "⚠️ No se encontró la carpeta 'frontend'.")

    if os.path.exists("RedBack"):
        run_command("composer install", cwd="RedBack", description="Instalando dependencias de backend")
    else:
        print(Fore.YELLOW + "⚠️ No se encontró la carpeta 'backend'.")

    # Preguntas después de instalar dependencias
    if os.path.exists("RedBack"):
        # Preguntar por generar key de Laravel
        if input(Fore.CYAN + "¿Deseas generar una nueva key de Laravel? (s/n): ").lower() == "s":
            run_command("php artisan key:generate", cwd="RedBack", description="Generando key de Laravel")
        
        # Preguntar por generar JWT secret
        if input(Fore.CYAN + "¿Deseas generar un nuevo JWT secret? (recomendado) (s/n): ").lower() == "s":
            run_command("php artisan jwt:secret", cwd="RedBack", description="Generando JWT secret")

        if input(Fore.CYAN + "¿Deseas ejecutar las migraciones? (s/n): ").lower() == "s":
            run_command("php artisan migrate", cwd="RedBack", description="Migrando base de datos")

            if input(Fore.CYAN + "¿Deseas ejecutar los seeders? (s/n): ").lower() == "s":
                run_command("php artisan db:seed", cwd="RedBack", description="Ejecutando seeders")

        if input(Fore.CYAN + "¿Deseas crear el enlace del storage? (s/n): ").lower() == "s":
            run_command("php artisan storage:link", cwd="RedBack", description="Creando enlace simbólico")

    # Preguntar si quiere levantar servidores
    print(Fore.CYAN + "¿Quieres levantar los servidores ahora?")
    print(" 1. Sí")
    print(" 2. No")
    choice = input(Fore.CYAN + "Selecciona una opción (1/2): ")
    
    if choice == "1":
        print(Fore.YELLOW + "\nOpciones de servidor:")
        print(" 1. Backend y Frontend")
        print(" 2. Solo Backend")
        print(" 3. Solo Frontend")
        op = input(Fore.CYAN + "Elige una opción (1/2/3): ")
        if op == "1":
            serve(both=True)
        elif op == "2":
            serve(backend_only=True)
        elif op == "3":
            serve(frontend_only=True)

def serve(both=False, backend_only=False, frontend_only=False):
    show_title()
    print(Fore.CYAN + "🟢 Iniciando servidores...")
    if both or backend_only:
        if os.path.exists("RedBack"):
            subprocess.Popen("php artisan serve", shell=True, cwd="RedBack")
            print(Fore.GREEN + "🚀 Backend iniciado en http://localhost:8000")
    if both or frontend_only:
        if os.path.exists("RedFront"):
            subprocess.Popen("npm run dev", shell=True, cwd="RedFront")
            print(Fore.GREEN + "🚀 Frontend iniciado")
    print(Fore.GREEN + "✅ Servidores iniciados. Presiona Ctrl+C para detener.")
    try:
        while True: sleep(1)
    except KeyboardInterrupt:
        print(Fore.YELLOW + "\n🛑 Servidores detenidos.")

def clear():
    show_title()
    print(Fore.YELLOW + "\nOpciones:")
    print(" 1. Solo cache de Laravel")
    print(" 2. Solo dependencias")
    print(" 3. Ambas cosas")
    op = input(Fore.CYAN + "Selecciona una opción (1/2/3): ")
    
    if os.path.exists("RedBack") and op in ["1", "3"]:
        run_command("php artisan cache:clear", cwd="RedBack", description="Limpiando cache de Laravel")
        run_command("php artisan config:clear", cwd="RedBack", description="Limpiando configuración")

    if os.path.exists("RedFront") and op in ["2", "3"]:
        run_command("rm -rf node_modules", cwd="RedFront", description="Eliminando node_modules")

    if os.path.exists("RedBack") and op in ["2", "3"]:
        run_command("rm -rf vendor", cwd="RedBack", description="Eliminando vendor")

    print(Fore.GREEN + "✅ Limpieza completada.\n")

def download():
    """Función para descargar el repositorio"""
    show_title()
    print(Fore.MAGENTA + "📥 Iniciando descarga del repositorio REDVEL-FRAMEWORK...\n")
    
    # Intentar descargar el repositorio
    download_repository()
    
    # Verificar si las carpetas existen
    if os.path.exists("RedBack") and os.path.exists("RedFront"):
        print(Fore.GREEN + "✅ Las carpetas necesarias están presentes")
        print(Fore.CYAN + "¿Quieres instalar los paquetes ahora?")
        print(" 1. Sí")
        print(" 2. No")
        choice = input(Fore.CYAN + "Selecciona una opción (1/2): ")
        
        if choice == "1":
            install()
    else:
        print(Fore.RED + "❌ No se pudieron encontrar las carpetas necesarias")
        print(Fore.YELLOW + "⚠️ Por favor, intenta descargar el repositorio nuevamente")

def terminal():
    """Terminal interactiva"""
    show_title()
    print(Fore.CYAN + "🖥️ Terminal interactiva de REDVEL")
    print(Fore.YELLOW + "Escribe 'exit' para salir, 'help' para ver comandos disponibles\n")
    
    while True:
        try:
            command = input(Fore.GREEN + "REDVEL> ").strip()
            
            if command.lower() == 'exit':
                print(Fore.YELLOW + "👋 Saliendo de la terminal...")
                break
            elif command.lower() == 'help':
                help_menu()
            elif command.lower() == 'install':
                install()
            elif command.lower() == 'download':
                download()
            elif command.lower() == 'clear':
                clear()
            elif command.lower() == 'run':
                serve(both=True)
            elif command.lower() == 'run back':
                serve(backend_only=True)
            elif command.lower() == 'run front':
                serve(frontend_only=True)
            elif command.lower() == 'check':
                check()
            elif command.lower() == 'add path':
                add_to_path()
            elif command.lower() == 'clean':
                if len(sys.argv) > 2 and sys.argv[2] == "cache":
                    clean_cache()
                else:
                    print(Fore.RED + "❌ Comando inválido. Usa: clean cache")
            elif command == '':
                continue
            else:
                print(Fore.RED + "❌ Comando desconocido. Escribe 'help' para ver los comandos disponibles")
                    
        except KeyboardInterrupt:
            print(Fore.YELLOW + "\n👋 Saliendo de la terminal...")
            break
        except EOFError:
            break

def help_menu():
    show_title()
    print(Fore.YELLOW + "Comandos disponibles:\n")
    print("  install            → Instala dependencias y realiza configuración inicial")
    print("  download           → Descarga el repositorio REDVEL-FRAMEWORK")
    print("  clear              → Limpia cache o dependencias del proyecto")
    print("  run                → Levanta ambos servidores (Laravel + Frontend)")
    print("  run back           → Solo Laravel")
    print("  run front          → Solo Frontend")
    print("  terminal           → Abre terminal interactiva")
    print("  check              → Verifica dependencias del sistema")
    print("  add path           → Añade el directorio al PATH (solo Windows)")
    print("  clean cache        → Limpia archivos temporales y caché")
    print("  help               → Muestra este menú")

def check():
    """Verificar dependencias del sistema"""
    show_title()
    check_dependencies()

def main():
    # Si no hay argumentos, mostrar menú inicial
    if len(sys.argv) == 1:
        initial_menu()
        return

    cmd = sys.argv[1]

    if cmd == "install":
        install()
    elif cmd == "download":
        download()
    elif cmd == "clear":
        clear()
    elif cmd == "help":
        help_menu()
    elif cmd == "terminal":
        terminal()
    elif cmd == "check":
        check()
    elif cmd == "add":
        if len(sys.argv) > 2 and sys.argv[2] == "path":
            add_to_path()
        else:
            print(Fore.RED + "❌ Comando inválido. Usa: add path")
    elif cmd == "clean":
        if len(sys.argv) > 2 and sys.argv[2] == "cache":
            clean_cache()
        else:
            print(Fore.RED + "❌ Comando inválido. Usa: clean cache")
    elif cmd == "run":
        if len(sys.argv) == 2:
            serve(both=True)
        elif sys.argv[2] == "back":
            serve(backend_only=True)
        elif sys.argv[2] == "front":
            serve(frontend_only=True)
        else:
            print(Fore.RED + "❌ Comando inválido. Usa: run [back|front]")
    else:
        print(Fore.RED + f"❌ Comando desconocido: {cmd}")
        help_menu()

if __name__ == "__main__":
    main()