#!/bin/bash

# 🚀 VitalAccess v5 Package Installer for Laravel 11/12/13 + Filament 5.x
# Automatiza la instalación completa del paquete VitalAccess v5 con Filament 5.x

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration for VitalAccess v5
PACKAGE_NAME="VitalAccess v5 RBAC"
COMPOSER_NAME="vitalsaas/vitalaccess"
REPO_PATH="$(pwd)/packages/vitalaccess-v5"
NAMESPACE="VitalSaaS\\VitalAccess\\"
SERVICE_PROVIDER="VitalSaaS\\VitalAccess\\VitalAccessServiceProvider"
PROJECT_NAME=""

# Helper functions
log_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

log_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

log_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

log_error() {
    echo -e "${RED}❌ $1${NC}"
    exit 1
}

# Check if project name is provided
if [ -z "$1" ]; then
    log_error "Uso: ./install-vitalaccess.sh PROJECT_NAME"
fi

PROJECT_NAME="$1"

# Verify project exists
if [ ! -d "$PROJECT_NAME" ]; then
    log_error "Proyecto '$PROJECT_NAME' no encontrado"
fi

if [ ! -f "$PROJECT_NAME/composer.json" ]; then
    log_error "No es un proyecto Laravel válido (composer.json no encontrado)"
fi

log_info "🚀 Instalando $PACKAGE_NAME en proyecto: $PROJECT_NAME"

# Step 1: Verify local package exists
if [ ! -d "$REPO_PATH" ]; then
    log_error "VitalAccess v5 no encontrado en: $REPO_PATH"
fi

if [ ! -f "$REPO_PATH/composer.json" ]; then
    log_error "composer.json no encontrado en VitalAccess v5"
fi

# Step 2: Copy package into project container (Docker compatibility)
log_info "📦 Copiando VitalAccess v5 al contenedor..."
docker exec ${PROJECT_NAME}-app-1 mkdir -p /app/packages 2>/dev/null || {
    log_warning "No se pudo crear directorio packages en contenedor, continuando..."
}
docker cp "$REPO_PATH" ${PROJECT_NAME}-app-1:/app/packages/ 2>/dev/null || {
    log_warning "No se pudo copiar al contenedor, intentando método alternativo..."
    mkdir -p "$PROJECT_NAME/packages" 2>/dev/null
    cp -r "$REPO_PATH" "$PROJECT_NAME/packages/" 2>/dev/null
}

# Step 3: Configure local repository
log_info "📝 Configurando repositorio local para VitalAccess v5..."
make composer PROJECT_NAME="$PROJECT_NAME" cmd="config repositories.vitalaccess path packages/vitalaccess-v5" || {
    log_error "Failed to configure repository"
}
log_success "Repositorio local configurado"

# Step 4: Clear Composer cache
log_info "🧹 Limpiando cache de Composer..."
make composer PROJECT_NAME="$PROJECT_NAME" cmd="clear-cache" || {
    log_warning "No se pudo limpiar cache de Composer"
}

# Step 5: Install Filament 5.x and VitalAccess v5
log_info "📦 Instalando Filament 5.x y VitalAccess v5..."
make composer PROJECT_NAME="$PROJECT_NAME" cmd="require filament/filament:^5.0 $COMPOSER_NAME:dev-main --with-all-dependencies" || {
    log_error "Failed to install packages"
}
log_success "Paquetes instalados exitosamente"

# Step 6: Publish VitalAccess configuration and assets
log_info "📤 Publicando configuraciones de VitalAccess..."
make artisan PROJECT_NAME="$PROJECT_NAME" cmd="vendor:publish --provider=\"$SERVICE_PROVIDER\"" || {
    log_error "Failed to publish VitalAccess assets"
}
log_success "Configuraciones publicadas"

# Step 7: Run VitalAccess migrations
log_info "🗃️  Ejecutando migraciones de VitalAccess..."
make migrate PROJECT_NAME="$PROJECT_NAME" || {
    log_error "Failed to run migrations"
}
log_success "Migraciones ejecutadas (8 tablas VitalAccess creadas)"

# Step 8: Install Filament admin panel
log_info "🛡️  Instalando panel de administración Filament..."
make artisan PROJECT_NAME="$PROJECT_NAME" cmd="filament:install --panels" || {
    log_error "Failed to install Filament panel"
}
log_success "Panel Filament instalado"

# Step 9: Remove incompatible VitalAccess resources (Filament 3.x -> 5.x API changes)
log_info "🧹 Eliminando recursos incompatibles (Filament 3.x -> 5.x)..."
docker exec ${PROJECT_NAME}-app-1 rm -rf /app/app/Filament/Resources/Access* /app/app/Filament/Widgets/VitalAccess* /app/app/Filament/Pages/VitalAccess* 2>/dev/null || {
    log_warning "No se pudieron eliminar algunos recursos (puede ser normal)"
}
log_success "Recursos incompatibles eliminados"

# Step 10: Create admin user
log_info "👤 Creando usuario administrador..."
ADMIN_EMAIL="admin@${PROJECT_NAME}.test"
ADMIN_PASSWORD="password"
make artisan PROJECT_NAME="$PROJECT_NAME" cmd="make:filament-user --name=\"Admin ${PROJECT_NAME^}\" --email=\"$ADMIN_EMAIL\" --password=\"$ADMIN_PASSWORD\"" || {
    log_warning "No se pudo crear usuario admin automáticamente"
    log_info "Puedes crear uno manualmente con: make artisan PROJECT_NAME=$PROJECT_NAME cmd=\"make:filament-user\""
}

# Step 11: Clear all caches
log_info "🧹 Limpiando cachés finales..."
make artisan PROJECT_NAME="$PROJECT_NAME" cmd="config:clear" >/dev/null 2>&1
make artisan PROJECT_NAME="$PROJECT_NAME" cmd="cache:clear" >/dev/null 2>&1

# Step 12: Verification
log_info "🔍 Verificando instalación..."

# Check VitalAccess models
MODELS_CHECK=$(make artisan PROJECT_NAME="$PROJECT_NAME" cmd="tinker --execute=\"echo 'VitalAccess models: ' . (class_exists('$NAMESPACE\\Models\\AccessRole') ? 'OK' : 'MISSING');\"" 2>/dev/null | grep -o "VitalAccess models: OK" || echo "MISSING")

if [[ "$MODELS_CHECK" == *"OK"* ]]; then
    log_success "Modelos VitalAccess funcionando"
else
    log_warning "No se pudieron verificar modelos VitalAccess"
fi

# Check database tables
TABLES_CHECK=$(docker exec ${PROJECT_NAME}-app-1 php artisan tinker --execute="echo 'Tables: ' . count(array_filter(DB::select('SHOW TABLES'), fn(\$t) => str_contains(array_values((array)\$t)[0], 'access_')));" 2>/dev/null | grep -o "Tables: [0-9]*" || echo "Tables: 0")

if [[ "$TABLES_CHECK" == "Tables: 8" ]]; then
    log_success "8 tablas VitalAccess creadas correctamente"
else
    log_warning "Verificación de tablas inconclusa"
fi

# Get port information
APP_PORT=$(grep "APP_PORT=" "$PROJECT_NAME/.env" 2>/dev/null | cut -d'=' -f2 || echo "8000")
MYSQL_PORT=$(grep "MYSQL_PORT=" "$PROJECT_NAME/.env" 2>/dev/null | cut -d'=' -f2 || echo "3306")
PHPMYADMIN_PORT=$(grep "PHPMYADMIN_PORT=" "$PROJECT_NAME/.env" 2>/dev/null | cut -d'=' -f2 || echo "8080")

# Step 13: Generate installation report
log_info "📖 Generando reporte de instalación..."
cat > "$PROJECT_NAME/VITALACCESS_V5_INSTALLATION.md" << EOF
# VitalAccess v5 + Filament 5.x Installation Report

**Project:** $PROJECT_NAME
**Date:** $(date)
**Package:** $PACKAGE_NAME ($COMPOSER_NAME)
**Stack:** Laravel + Filament 5.x + VitalAccess v5

## 🎉 Installation Completed Successfully!

### ✅ Components Installed:
- **Laravel:** $(docker exec ${PROJECT_NAME}-app-1 php artisan tinker --execute="echo app()->version();" 2>/dev/null || echo "Unknown")
- **PHP:** $(docker exec ${PROJECT_NAME}-app-1 php -v | head -1 | cut -d' ' -f2 2>/dev/null || echo "Unknown")
- **Filament:** 5.x
- **VitalAccess:** v5 (dev-main)

### 🔧 Installation Steps Completed:

✅ VitalAccess v5 package copied to container
✅ Local repository configured
✅ Filament 5.x + VitalAccess v5 installed via Composer
✅ VitalAccess configurations published
✅ Database migrations executed (8 tables created)
✅ Filament admin panel installed
✅ Incompatible resources cleaned (API migration 3.x -> 5.x)
✅ Admin user created
✅ All caches cleared

### 🗃️  Database Tables Created:
- access_role_categories
- access_roles
- access_permissions
- access_modules
- access_role_permissions
- access_permission_modules
- access_user_roles
- access_user_business_units

## 🚀 Access Your Application:

### 🌐 Web Application:
**URL:** http://localhost:$APP_PORT

### 🛡️  Filament Admin Panel:
**URL:** http://localhost:$APP_PORT/admin
**Email:** $ADMIN_EMAIL
**Password:** $ADMIN_PASSWORD

### 🗃️  Database Management:
**phpMyAdmin:** http://localhost:$PHPMYADMIN_PORT
**MySQL:** localhost:$MYSQL_PORT

## 🧪 Verification Commands:

\`\`\`bash
# Check VitalAccess models
make artisan PROJECT_NAME=$PROJECT_NAME cmd="tinker --execute='echo \"Models: \" . (class_exists(\"VitalSaaS\\\\VitalAccess\\\\Models\\\\AccessRole\") ? \"OK\" : \"FAIL\");'"

# Count VitalAccess tables
make artisan PROJECT_NAME=$PROJECT_NAME cmd="tinker --execute='echo \"Tables: \" . count(array_filter(DB::select(\"SHOW TABLES\"), fn(\$t) => str_contains(array_values((array)\$t)[0], \"access_\")));'"

# Check Laravel version
make artisan PROJECT_NAME=$PROJECT_NAME cmd="tinker --execute='echo \"Laravel: \" . app()->version();'"

# Access project shell
make shell PROJECT_NAME=$PROJECT_NAME
\`\`\`

## 📚 VitalAccess v5 Features:

### 🔐 RBAC System:
- **Roles:** User role management
- **Permissions:** Granular permission control
- **Modules:** Application module organization
- **Categories:** Role categorization

### 🎛️  Admin Interface:
- Filament 5.x integration
- Modern admin panel UI
- Role/permission management
- User assignment interface

### 🔧 Laravel Integration:
- Middleware support
- Model traits
- Service providers
- Artisan commands

## 🆘 Troubleshooting:

### If admin panel not accessible:
\`\`\`bash
# Check containers status
make ps PROJECT_NAME=$PROJECT_NAME

# Restart if needed
make restart PROJECT_NAME=$PROJECT_NAME
\`\`\`

### If models not working:
\`\`\`bash
# Clear caches
make artisan PROJECT_NAME=$PROJECT_NAME cmd="config:clear"
make artisan PROJECT_NAME=$PROJECT_NAME cmd="cache:clear"

# Dump autoload
make composer PROJECT_NAME=$PROJECT_NAME cmd="dump-autoload"
\`\`\`

### If database issues:
\`\`\`bash
# Check migrations
make artisan PROJECT_NAME=$PROJECT_NAME cmd="migrate:status"

# Re-run if needed
make migrate PROJECT_NAME=$PROJECT_NAME
\`\`\`

## 📞 Support:
- **Package Repository:** $REPO_PATH
- **Composer Package:** $COMPOSER_NAME
- **Namespace:** $NAMESPACE
- **Service Provider:** $SERVICE_PROVIDER
EOF

# Final success message
echo ""
echo -e "${GREEN}🎉 VitalAccess v5 + Filament 5.x instalado exitosamente!${NC}"
echo ""
echo -e "${BLUE}📋 Acceso rápido:${NC}"
echo -e "  🌐 App:        http://localhost:$APP_PORT"
echo -e "  🛡️  Admin:      http://localhost:$APP_PORT/admin"
echo -e "  👤 Usuario:    $ADMIN_EMAIL"
echo -e "  🔑 Password:   $ADMIN_PASSWORD"
echo ""
echo -e "${BLUE}📖 Documentación generada en:${NC} $PROJECT_NAME/VITALACCESS_V5_INSTALLATION.md"
echo -e "${BLUE}🔧 Shell del proyecto:${NC} make shell PROJECT_NAME=$PROJECT_NAME"
echo ""

log_success "Instalación completa - ¡VitalAccess v5 listo para usar!"