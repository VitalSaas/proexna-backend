#!/bin/bash

# Script para iniciar la aplicación de jardinería con Docker

echo "🌱 Iniciando Jardinería Verde..."

# Verificar si Docker está instalado
if ! command -v docker &> /dev/null; then
    echo "❌ Docker no está instalado. Por favor, instala Docker primero."
    exit 1
fi

# Verificar si Docker Compose está disponible
if ! docker compose version &> /dev/null; then
    echo "❌ Docker Compose no está disponible. Por favor, asegúrate de tener Docker con Compose plugin."
    exit 1
fi

# Función para mostrar ayuda
show_help() {
    echo "Uso: $0 [opción]"
    echo ""
    echo "Opciones:"
    echo "  prod    - Ejecutar en modo producción (puerto 3000)"
    echo "  dev     - Ejecutar en modo desarrollo con hot reload (puerto 3001)"
    echo "  build   - Construir la imagen de Docker"
    echo "  stop    - Detener todos los contenedores"
    echo "  clean   - Limpiar contenedores e imágenes"
    echo "  logs    - Ver logs de la aplicación"
    echo "  help    - Mostrar esta ayuda"
    echo ""
}

# Procesar argumentos
case "${1:-prod}" in
    "prod")
        echo "🚀 Iniciando en modo producción..."
        docker compose up --build -d jardineria-verde
        echo "✅ Aplicación disponible en: http://localhost:3000"
        ;;
    "dev")
        echo "🛠️  Iniciando en modo desarrollo..."
        docker compose --profile dev up --build -d jardineria-dev
        echo "✅ Aplicación disponible en: http://localhost:3001"
        echo "📝 Hot reload activado para desarrollo"
        ;;
    "build")
        echo "🔨 Construyendo imagen Docker..."
        docker compose build
        echo "✅ Imagen construida exitosamente"
        ;;
    "stop")
        echo "🛑 Deteniendo contenedores..."
        docker compose down
        echo "✅ Contenedores detenidos"
        ;;
    "clean")
        echo "🧹 Limpiando contenedores e imágenes..."
        docker compose down --rmi all --volumes --remove-orphans
        echo "✅ Limpieza completada"
        ;;
    "logs")
        echo "📋 Mostrando logs..."
        docker compose logs -f
        ;;
    "help"|"-h"|"--help")
        show_help
        ;;
    *)
        echo "❌ Opción no válida: $1"
        show_help
        exit 1
        ;;
esac