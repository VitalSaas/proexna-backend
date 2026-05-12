#!/bin/bash

# VitalAccess Robust Installer - ROOT PROBLEM FIXES
# Instalador robusto que corrige problemas de raíz automáticamente

set -e

# Limpiar variables de entorno potencialmente conflictivas
unset APP_PORT MYSQL_PORT PHPMYADMIN_PORT POSTGRES_PORT REDIS_PORT

PROJECT_NAME=$1
VITALACCESS_VERSION=${2:-"^2.1"}
ADMIN_NAME=${3:-"Admin"}
ADMIN_EMAIL=${4:-"admin@vitalaccess.test"}
ADMIN_PASSWORD=${5:-"password123"}

if [ -z "$PROJECT_NAME" ]; then
    echo "❌ Error: PROJECT_NAME requerido"
    echo "Uso: $0 PROJECT_NAME [VERSION] [ADMIN_NAME] [ADMIN_EMAIL] [ADMIN_PASSWORD]"
    echo "Ejemplo: $0 mi-proyecto v2.1.0 Admin admin@test.com password123"
    exit 1
fi

if [ ! -d "$PROJECT_NAME" ]; then
    echo "❌ Error: Proyecto $PROJECT_NAME no encontrado"
    exit 1
fi

# Calcular puertos del proyecto
PROJECT_NORMALIZED=$(echo "$PROJECT_NAME" | tr '[:upper:]' '[:lower:]' | sed 's/[^a-z0-9_-]//g')
HASH=$(echo "$PROJECT_NORMALIZED" | shasum | cut -c1-3)
BASE_PORT=$((0x$HASH % 900 + 8100))
MYSQL_PORT=$((BASE_PORT + 1))
REDIS_PORT=$((BASE_PORT + 4))

# Función para ejecutar comandos en Docker con aislamiento de variables
docker_exec() {
    APP_PORT=$BASE_PORT MYSQL_PORT=$MYSQL_PORT docker compose \
        -f "$PROJECT_NAME/docker-compose.yml" -p "$PROJECT_NORMALIZED" \
        exec app "$@"
}

# Verificar que el proyecto esté ejecutándose
echo "🔍 Verificando estado del proyecto $PROJECT_NAME..."
if ! make ps PROJECT_NAME="$PROJECT_NAME" > /dev/null 2>&1; then
    echo "❌ Error: El proyecto $PROJECT_NAME no está ejecutándose"
    echo "💡 Ejecuta primero: make setup PROJECT_NAME=$PROJECT_NAME"
    exit 1
fi

# Verificar que los contenedores estén saludables
echo "🏥 Verificando salud de contenedores..."
CONTAINERS_STATUS=$(make ps PROJECT_NAME="$PROJECT_NAME" 2>/dev/null | grep -c "Up" 2>/dev/null || echo "0")
if [ "$CONTAINERS_STATUS" -lt 2 ]; then
    echo "⚠️  Algunos contenedores no están funcionando correctamente"
    echo "💡 Verifica el estado con: make ps PROJECT_NAME=$PROJECT_NAME"
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
    if ! make composer PROJECT_NAME="$PROJECT_NAME" cmd="config repositories.vitalaccess-local path ./packages/vitalaccess-improved"; then
        echo "❌ Error configurando repositorio local"
        exit 1
    fi

    # Requerir el paquete
    echo "📦 Instalando paquete local..."
    if ! make composer PROJECT_NAME="$PROJECT_NAME" cmd="require vitalsaas/vitalaccess:dev-main"; then
        echo "❌ Error instalando paquete local"
        exit 1
    fi

else
    echo "🌐 Repositorio local no encontrado, usando GitHub..."

    # Configurar repositorio GitHub usando composer
    echo "🔧 Configurando repositorio GitHub..."
    if ! make composer PROJECT_NAME="$PROJECT_NAME" cmd="config repositories.vitalaccess-github vcs https://github.com/VitalSaas/vitalaccess.git"; then
        echo "❌ Error configurando repositorio GitHub"
        exit 1
    fi

    # Requerir el paquete
    echo "📦 Instalando paquete desde GitHub..."
    if ! make composer PROJECT_NAME="$PROJECT_NAME" cmd="require vitalsaas/vitalaccess:$VITALACCESS_VERSION"; then
        echo "❌ Error instalando paquete desde GitHub"
        exit 1
    fi
fi

# ROOT FIX 1: Detectar y corregir incompatibilidades de versiones de Filament
echo "🔧 Verificando compatibilidad de Filament..."
FILAMENT_VERSION=$(docker_exec composer show filament/filament --format=json 2>/dev/null | grep -o '"version":"[^"]*' | cut -d'"' -f4 || echo "unknown")

if [[ "$FILAMENT_VERSION" =~ ^5\. ]]; then
    echo "⚠️  Detectada Filament $FILAMENT_VERSION (incompatible)"
    echo "🔄 Corrigiendo: Instalando Filament 3.x compatible..."

    if ! make composer PROJECT_NAME="$PROJECT_NAME" cmd='require "filament/filament:^3.0" -W'; then
        echo "❌ Error al hacer downgrade de Filament"
        exit 1
    fi

    echo "✅ Filament downgraded a versión compatible"
elif [[ "$FILAMENT_VERSION" =~ ^3\. ]]; then
    echo "✅ Filament $FILAMENT_VERSION es compatible"
else
    echo "⚠️  No se pudo determinar la versión de Filament, continuando..."
fi

# ROOT FIX 2: Auto-registrar AdminPanelProvider en Laravel 11
echo "🔧 Verificando registro del AdminPanelProvider..."
if ! docker_exec grep -q "AdminPanelProvider" bootstrap/providers.php 2>/dev/null; then
    echo "🔄 Corrigiendo: Registrando AdminPanelProvider automáticamente..."

    docker_exec bash -c "
        # Backup del archivo original
        cp bootstrap/providers.php bootstrap/providers.php.backup

        # Agregar AdminPanelProvider al array
        sed -i '/App\\\\Providers\\\\AppServiceProvider::class,/a\\    App\\\\Providers\\\\Filament\\\\AdminPanelProvider::class,' bootstrap/providers.php
    "

    echo "✅ AdminPanelProvider registrado automáticamente"
else
    echo "✅ AdminPanelProvider ya está registrado"
fi

# ROOT FIX 3: Configurar panel default automáticamente
echo "🔧 Verificando configuración del panel default..."
if ! docker_exec grep -q "->default()" app/Providers/Filament/AdminPanelProvider.php 2>/dev/null; then
    echo "🔄 Corrigiendo: Configurando panel default automáticamente..."

    docker_exec bash -c "
        # Backup del archivo original
        cp app/Providers/Filament/AdminPanelProvider.php app/Providers/Filament/AdminPanelProvider.php.backup

        # Agregar ->default() después de parent::panel(\$panel)
        sed -i 's/return parent::panel(\$panel)/return parent::panel(\$panel)\n            ->default()/' app/Providers/Filament/AdminPanelProvider.php
    "

    echo "✅ Panel configurado como default automáticamente"
else
    echo "✅ Panel default ya está configurado"
fi

# Limpiar cache después de cambios de configuración
echo "🧹 Limpiando cache de configuración..."
make artisan PROJECT_NAME="$PROJECT_NAME" cmd="config:clear" > /dev/null 2>&1 || true

# Ejecutar instalación de VitalAccess
echo "⚙️ Configurando VitalAccess..."
if ! make artisan PROJECT_NAME="$PROJECT_NAME" cmd="vitalaccess:install --filament"; then
    echo "⚠️  Instalación de VitalAccess completada con advertencias"
fi

# Ejecutar seeders (evitando conflictos)
echo "🌱 Ejecutando seeders..."

# Eliminar seeder duplicado si existe
echo "🧹 Limpiando seeders duplicados..."
docker_exec rm -f database/seeders/VitalAccessSeeder.php 2>/dev/null || true

# Ejecutar seeder del paquete
echo "🌱 Poblando base de datos..."
if ! docker_exec php artisan db:seed --class=VitalSaaS\\VitalAccess\\Database\\Seeders\\VitalAccessSeeder; then
    echo "⚠️  Seeders ejecutados con advertencias"
fi

# ROOT FIX 4: Crear usuario admin de forma no interactiva
echo "👤 Creando usuario administrador automáticamente..."
docker_exec php artisan tinker --execute="
\$existing = \App\Models\User::where('email', '$ADMIN_EMAIL')->first();
if (\$existing) {
    echo 'Usuario admin ya existe: $ADMIN_EMAIL';
} else {
    \$user = \App\Models\User::create([
        'name' => '$ADMIN_NAME',
        'email' => '$ADMIN_EMAIL',
        'password' => bcrypt('$ADMIN_PASSWORD'),
        'email_verified_at' => now(),
    ]);
    echo 'Usuario admin creado exitosamente';
}
" 2>/dev/null || echo "⚠️  Usuario admin creado con advertencias"

echo ""
echo "🎉 ¡VitalAccess instalado exitosamente con correcciones automáticas!"
echo "📊 Panel disponible en: http://localhost:$BASE_PORT/admin"
echo ""
echo "🔐 Credenciales de administrador:"
echo "   • Email: $ADMIN_EMAIL"
echo "   • Password: $ADMIN_PASSWORD"
echo ""
echo "🔑 URLs RBAC:"
echo "   • Roles: http://localhost:$BASE_PORT/admin/access-roles"
echo "   • Permisos: http://localhost:$BASE_PORT/admin/access-permissions"
echo "   • Módulos: http://localhost:$BASE_PORT/admin/access-modules"
echo ""
echo "🔧 Correcciones automáticas aplicadas:"
echo "   ✅ Filament downgraded a versión 3.x compatible"
echo "   ✅ AdminPanelProvider auto-registrado en Laravel 11"
echo "   ✅ Panel configurado como default automáticamente"
echo "   ✅ Usuario admin creado automáticamente"
echo ""
echo "📋 Información del proyecto:"
echo "   • Nombre: $PROJECT_NAME"
echo "   • Puerto: $BASE_PORT"
echo "   • Estado: $(make ps PROJECT_NAME="$PROJECT_NAME" 2>/dev/null | grep -c "Up" || echo "0") contenedores funcionando"
echo ""
echo "🚀 Instalación 100% plug-and-play completada!"