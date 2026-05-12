#!/bin/bash

# VitalAccess Simple Installer
# Instalador simplificado que evita manipulación manual de composer.json

set -e

PROJECT_NAME=$1
VITALACCESS_VERSION=${2:-"^2.1"}

if [ -z "$PROJECT_NAME" ]; then
    echo "❌ Error: PROJECT_NAME requerido"
    echo "Uso: $0 PROJECT_NAME [VERSION]"
    echo "Ejemplo: $0 mi-proyecto v2.1.0"
    exit 1
fi

if [ ! -d "$PROJECT_NAME" ]; then
    echo "❌ Error: Proyecto $PROJECT_NAME no encontrado"
    exit 1
fi

echo "🚀 Instalando VitalAccess en $PROJECT_NAME..."

# Detectar si existe repositorio local
LOCAL_REPO="../packages/vitalaccess-improved"

if [ -d "$LOCAL_REPO" ]; then
    echo "📦 Repositorio local detectado, usando versión de desarrollo..."

    # Copiar paquete al proyecto
    echo "📁 Copiando paquete local..."
    mkdir -p "$PROJECT_NAME/packages"
    cp -r "$LOCAL_REPO" "$PROJECT_NAME/packages/" || true

    # Configurar repositorio local usando composer
    echo "🔧 Configurando repositorio local..."
    make composer PROJECT_NAME="$PROJECT_NAME" cmd="config repositories.vitalaccess-local path ./packages/vitalaccess-improved"

    # Requerir el paquete
    make composer PROJECT_NAME="$PROJECT_NAME" cmd="require vitalsaas/vitalaccess:dev-main"

else
    echo "🌐 Repositorio local no encontrado, usando GitHub..."

    # Configurar repositorio GitHub usando composer
    echo "🔧 Configurando repositorio GitHub..."
    make composer PROJECT_NAME="$PROJECT_NAME" cmd="config repositories.vitalaccess-github vcs https://github.com/VitalSaas/vitalaccess.git"

    # Requerir el paquete
    make composer PROJECT_NAME="$PROJECT_NAME" cmd="require vitalsaas/vitalaccess:$VITALACCESS_VERSION"
fi

# Ejecutar instalación de VitalAccess
echo "⚙️ Configurando VitalAccess..."
make artisan PROJECT_NAME="$PROJECT_NAME" cmd="vitalaccess:install --filament" || true

# Ejecutar seeders (evitando conflictos)
echo "🌱 Ejecutando seeders..."
# Eliminar seeder duplicado si existe usando make
make shell PROJECT_NAME="$PROJECT_NAME" cmd="rm -f database/seeders/VitalAccessSeeder.php" 2>/dev/null || true

# Ejecutar seeder del paquete
make artisan PROJECT_NAME="$PROJECT_NAME" cmd="db:seed --class=VitalSaaS\\\\VitalAccess\\\\Database\\\\Seeders\\\\VitalAccessSeeder"

# Obtener puerto del proyecto
HASH=$(echo "$PROJECT_NAME" | tr '[:upper:]' '[:lower:]' | sed 's/[^a-z0-9_-]//g' | shasum | cut -c1-3)
BASE_PORT=$((0x$HASH % 900 + 8100))

echo ""
echo "🎉 ¡VitalAccess instalado exitosamente!"
echo "📊 Panel disponible en: http://localhost:$BASE_PORT/admin"
echo "🔑 URLs RBAC:"
echo "   • Roles: /admin/access-roles"
echo "   • Permisos: /admin/access-permissions"
echo "   • Módulos: /admin/access-modules"
echo ""
echo "💡 Para crear usuario admin:"
echo "   make artisan PROJECT_NAME=$PROJECT_NAME cmd=\"make:filament-user\""
echo ""