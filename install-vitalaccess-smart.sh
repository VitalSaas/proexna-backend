#!/bin/bash

# VitalAccess Smart Installer
# Detecta automáticamente el entorno y configura VitalAccess

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
COMPOSER_FILE="$PROJECT_NAME/composer.json"

if [ -d "$LOCAL_REPO" ]; then
    echo "📦 Repositorio local detectado, usando versión de desarrollo..."

    # Configurar repositorio local
    if ! grep -q "vitalaccess-improved" "$COMPOSER_FILE"; then
        echo "🔧 Configurando repositorio local en composer.json..."

        # Backup del composer.json original
        cp "$COMPOSER_FILE" "$COMPOSER_FILE.backup"

        # Usar jq para modificar JSON de manera segura
        tmp_file=$(mktemp)
        jq '. + {
            "repositories": [
                {
                    "type": "path",
                    "url": "./packages/vitalaccess-improved"
                }
            ]
        } | .require["vitalsaas/vitalaccess"] = "dev-main"' "$COMPOSER_FILE" > "$tmp_file"

        mv "$tmp_file" "$COMPOSER_FILE"
        echo "✅ composer.json actualizado"
    fi

    # Copiar paquete al proyecto
    echo "📁 Copiando paquete local..."
    mkdir -p "$PROJECT_NAME/packages"
    cp -r "$LOCAL_REPO" "$PROJECT_NAME/packages/"

else
    echo "🌐 Repositorio local no encontrado, usando GitHub..."

    # Configurar repositorio VCS de GitHub
    if ! grep -q "github.com/VitalSaas/vitalaccess" "$COMPOSER_FILE"; then
        echo "🔧 Configurando repositorio GitHub en composer.json..."

        # Backup del composer.json original
        cp "$COMPOSER_FILE" "$COMPOSER_FILE.backup"

        # Usar jq para modificar JSON de manera segura
        tmp_file=$(mktemp)
        jq '. + {
            "repositories": [
                {
                    "type": "vcs",
                    "url": "https://github.com/VitalSaas/vitalaccess.git"
                }
            ]
        } | .require["vitalsaas/vitalaccess"] = "'$VITALACCESS_VERSION'"' "$COMPOSER_FILE" > "$tmp_file"

        mv "$tmp_file" "$COMPOSER_FILE"
        echo "✅ composer.json actualizado para GitHub"
    fi
fi

# Instalar VitalAccess
echo "📥 Instalando dependencias..."
make composer PROJECT_NAME="$PROJECT_NAME" cmd="update vitalsaas/vitalaccess"

# Ejecutar instalación de VitalAccess
echo "⚙️ Configurando VitalAccess..."
make artisan PROJECT_NAME="$PROJECT_NAME" cmd="vitalaccess:install --filament" || true

# Ejecutar seeders (evitando conflictos)
echo "🌱 Ejecutando seeders..."
# Eliminar seeder duplicado si existe
[ -f "$PROJECT_NAME/database/seeders/VitalAccessSeeder.php" ] && rm "$PROJECT_NAME/database/seeders/VitalAccessSeeder.php"

# Ejecutar seeder del paquete
make artisan PROJECT_NAME="$PROJECT_NAME" cmd="db:seed --class=VitalSaaS\\\\VitalAccess\\\\Database\\\\Seeders\\\\VitalAccessSeeder"

echo ""
echo "🎉 ¡VitalAccess instalado exitosamente!"
echo "📊 Panel disponible en: http://localhost:XXXX/admin"
echo "🔑 URLs RBAC:"
echo "   • Roles: /admin/access-roles"
echo "   • Permisos: /admin/access-permissions"
echo "   • Módulos: /admin/access-modules"
echo ""
echo "💡 Para crear usuario admin:"
echo "   make artisan PROJECT_NAME=$PROJECT_NAME cmd=\"make:filament-user\""
echo ""