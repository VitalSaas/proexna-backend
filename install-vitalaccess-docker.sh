#!/bin/bash

# VitalAccess Docker-Aware Smart Installer
# Detecta automáticamente el entorno y configura VitalAccess para proyectos Docker

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

# Función para ejecutar comandos en el contenedor Docker
docker_exec() {
    APP_PORT=8254 MYSQL_PORT=8255 PHPMYADMIN_PORT=8256 POSTGRES_PORT=8257 REDIS_PORT=8258 \
    docker compose -f "$PROJECT_NAME/docker-compose.yml" -p "$(echo "$PROJECT_NAME" | tr '[:upper:]' '[:lower:]' | sed 's/[^a-z0-9_-]//g')" \
    exec app "$@"
}

if [ -d "$LOCAL_REPO" ]; then
    echo "📦 Repositorio local detectado, usando versión de desarrollo..."

    # Verificar si ya está configurado
    if ! grep -q "vitalaccess-improved" "$COMPOSER_FILE"; then
        echo "🔧 Configurando repositorio local en composer.json..."

        # Usar Docker para modificar el archivo de manera segura
        docker_exec bash -c "
        # Crear backup
        cp composer.json composer.json.backup

        # Usar jq para modificar JSON de manera segura
        jq '. + {
            \"repositories\": [
                {
                    \"type\": \"path\",
                    \"url\": \"./packages/vitalaccess-improved\"
                }
            ]
        } | .require[\"vitalsaas/vitalaccess\"] = \"dev-main\"' composer.json > composer.tmp

        mv composer.tmp composer.json
        "
        echo "✅ composer.json actualizado"
    fi

    # Copiar paquete al proyecto
    echo "📁 Copiando paquete local..."
    mkdir -p "$PROJECT_NAME/packages"
    cp -r "$LOCAL_REPO" "$PROJECT_NAME/packages/" || true

    # Ajustar permisos usando Docker
    docker_exec chown -R 1000:1000 packages/

else
    echo "🌐 Repositorio local no encontrado, usando GitHub..."

    # Verificar si ya está configurado
    if ! grep -q "github.com/VitalSaas/vitalaccess" "$COMPOSER_FILE"; then
        echo "🔧 Configurando repositorio GitHub en composer.json..."

        # Usar Docker para modificar el archivo de manera segura
        docker_exec bash -c "
        # Crear backup
        cp composer.json composer.json.backup

        # Usar jq para modificar JSON de manera segura
        jq '. + {
            \"repositories\": [
                {
                    \"type\": \"vcs\",
                    \"url\": \"https://github.com/VitalSaas/vitalaccess.git\"
                }
            ]
        } | .require[\"vitalsaas/vitalaccess\"] = \"$VITALACCESS_VERSION\"' composer.json > composer.tmp

        mv composer.tmp composer.json
        "
        echo "✅ composer.json actualizado para GitHub"
    fi
fi

# Instalar VitalAccess usando make commands
echo "📥 Instalando dependencias..."
make composer PROJECT_NAME="$PROJECT_NAME" cmd="update vitalsaas/vitalaccess"

# Ejecutar instalación de VitalAccess
echo "⚙️ Configurando VitalAccess..."
make artisan PROJECT_NAME="$PROJECT_NAME" cmd="vitalaccess:install --filament" || true

# Ejecutar seeders (evitando conflictos)
echo "🌱 Ejecutando seeders..."
# Eliminar seeder duplicado si existe
docker_exec rm -f database/seeders/VitalAccessSeeder.php 2>/dev/null || true

# Ejecutar seeder del paquete
make artisan PROJECT_NAME="$PROJECT_NAME" cmd="db:seed --class=VitalSaaS\\\\VitalAccess\\\\Database\\\\Seeders\\\\VitalAccessSeeder"

echo ""
echo "🎉 ¡VitalAccess instalado exitosamente!"
echo "📊 Panel disponible en: http://localhost:8254/admin"
echo "🔑 URLs RBAC:"
echo "   • Roles: /admin/access-roles"
echo "   • Permisos: /admin/access-permissions"
echo "   • Módulos: /admin/access-modules"
echo ""
echo "💡 Para crear usuario admin:"
echo "   make artisan PROJECT_NAME=$PROJECT_NAME cmd=\"make:filament-user\""
echo ""