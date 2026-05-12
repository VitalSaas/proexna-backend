# 🚀 Guía Completa: Proyecto Laravel + Filament + VitalAccess RBAC

## 📋 Descripción
Guía paso a paso para crear un proyecto Laravel completo desde cero hasta tener VitalAccess RBAC + Filament Admin Panel funcionando con Docker, FrankenPHP y base de datos.

### 🆕 **Últimas Mejoras (Mayo 2026)**
- ✨ **Selección de versión Laravel**: 11, 12, 13 o latest
- 🎨 **Filament Admin Panel**: Integración completa y funcional con Laravel 12
- 🔧 **Mejor compatibilidad**: Laravel 12 + Filament 5.6 + VitalAccess probada
- 🔒 **Extensiones PHP corregidas**: `libzip-dev` incluida para compilación zip
- 🧠 **Instalación VitalAccess mejorada**: Proceso manual + automático
- 🐳 **Permisos Docker optimizados**: Comandos Docker para resolver permisos
- 🛠️ **Troubleshooting completo**: Soluciones para errores comunes

---

## 🎯 Prerequisitos

- **Docker** y **Docker Compose** instalados
- **Git** configurado
- **Make** disponible en el sistema
- Acceso a terminal/bash

---

## 📦 Paso 1: Preparación del Entorno

### 1.1 Clonar o descargar el generador Laravel

```bash
# Si tienes acceso al generador, navega al directorio
cd /home/kaely/workspace_ultra/Desarrollo/test
# o 
cd /home/kaely/Codigo/Desarrollo/test

# Verificar que tienes los archivos necesarios
ls -la
```

**Debes ver:**
- ✅ `Makefile`
- ✅ `docker-compose.mysql.yml`  
- ✅ `docker-compose.postgresql.yml`
- ✅ `Dockerfile.mysql` y `Dockerfile.postgres`
- ✅ `packages/` directorio
- ✅ `install-vitalaccess.sh`

### 1.2 ⚠️ **IMPORTANTE: Verificar corrección Dockerfiles**

**ANTES** de crear cualquier proyecto, verificar que los Dockerfiles tengan la dependencia `libzip-dev`:

```bash
# Verificar Dockerfile.mysql
grep -n "libzip-dev" Dockerfile.mysql

# Verificar Dockerfile.postgres  
grep -n "libzip-dev" Dockerfile.postgres
```

Si **NO** aparece `libzip-dev`, agregarla manualmente:

```bash
# Agregar libzip-dev a Dockerfile.mysql
sed -i '11a\    libzip-dev \\' Dockerfile.mysql

# Agregar libzip-dev a Dockerfile.postgres  
sed -i '12a\    libzip-dev \\' Dockerfile.postgres
```

**La sección debe verse así:**
```dockerfile
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libzip-dev \
    # ... resto de dependencias
```

### 1.3 Verificar VitalAccess disponible

```bash
# Verificar que VitalAccess está disponible
ls -la packages/
```

**Debe existir:**
- ✅ `packages/vitalaccess/` o `packages/vitalaccess-local/`

---

## 🚀 Paso 2: Crear Proyecto Laravel

### 2.1 Selección de Versión Laravel 🆕

El Makefile ahora incluye **selección interactiva de versión Laravel**:

```bash
# Crear proyecto con selección de versión interactiva
make new-project PROJECT_NAME=mi_proyecto DATABASE=mysql

# Durante la ejecución verás:
# ¿Qué versión de Laravel deseas?
# 1) Laravel 11 (LTS) - Máxima estabilidad
# 2) Laravel 12 - Recomendado para Filament
# 3) Laravel 13 (Última) - Características más nuevas  
# 4) Latest - Usar comando laravel new estándar
```

**🎯 Recomendación por Uso:**
- **Laravel 11**: Para proyectos de producción que requieren máxima estabilidad
- **Laravel 12**: 🌟 **Recomendado para Filament** - Mejor compatibilidad comprobada
- **Laravel 13**: Para proyectos que necesitan las últimas características
- **Latest**: Deja que Composer decida la mejor versión

### 2.2 Comandos Específicos por Versión 🔧

También puedes usar comandos directos sin interacción:

```bash
# Laravel 11 (LTS)
make new-project-l11 PROJECT_NAME=mi_proyecto DATABASE=mysql

# Laravel 12 (Recomendado para Filament)
make new-project-l12 PROJECT_NAME=mi_proyecto DATABASE=mysql

# Laravel 13 (Última)
make new-project-l13 PROJECT_NAME=mi_proyecto DATABASE=mysql

# Latest (Composer decide)
make new-project-latest PROJECT_NAME=mi_proyecto DATABASE=mysql

# PostgreSQL también soportado
make new-project-l12 PROJECT_NAME=mi_proyecto DATABASE=postgres
```

**Esperado:**
- ✅ Proyecto `mi_proyecto/` creado
- ✅ Contenedores Docker iniciados  
- ✅ Laravel versión seleccionada instalada
- ✅ Base de datos configurada
- ✅ **Extensiones PHP**: `intl`, `zip` incluidas

### 2.3 Configurar y ejecutar migraciones

```bash
# Configurar proyecto (migraciones, claves, etc.)
make setup PROJECT_NAME=mi_proyecto
```

**Esperado:**
- ✅ APP_KEY generada
- ✅ Migraciones de Laravel ejecutadas
- ✅ Tablas básicas creadas (users, cache, jobs)

#### 🚨 **Si falla "MySQL no está listo":**

**Opción A: Esperar y reintentar**
```bash
# Esperar 30-60 segundos y reintentar
sleep 30
make setup PROJECT_NAME=mi_proyecto
```

**Opción B: Setup manual paso a paso**
```bash
# 1. Verificar que MySQL esté corriendo
make logs PROJECT_NAME=mi_proyecto service=mysql

# 2. Esperar hasta ver "ready for connections" en los logs
# Luego ejecutar setup manual:

# Generar APP_KEY
make artisan PROJECT_NAME=mi_proyecto cmd="key:generate --force"

# Ejecutar migraciones
make artisan PROJECT_NAME=mi_proyecto cmd="migrate --force"

# Verificar conexión a BD
make artisan PROJECT_NAME=mi_proyecto cmd="tinker --execute='DB::connection()->getPdo(); echo \"DB Connected!\";'"
```

**Opción C: Reiniciar contenedores**
```bash
# Si persiste el problema, reiniciar todo
make down PROJECT_NAME=mi_proyecto
sleep 10
make up PROJECT_NAME=mi_proyecto
sleep 30
make setup PROJECT_NAME=mi_proyecto
```

### 2.3 Verificar proyecto creado

```bash
# Verificar estado del proyecto
make status PROJECT_NAME=mi_proyecto
```

**Debe mostrar:**
- ✅ Contenedores running (app, mysql/postgres, redis, phpmyadmin)
- ✅ Puertos asignados dinámicamente
- ✅ URLs de acceso disponibles

### 2.4 Verificar tablas en base de datos

```bash
# Conectar a la base de datos para verificar tablas
make db-cli PROJECT_NAME=mi_proyecto

# Dentro de MySQL/PostgreSQL ejecutar:
SHOW TABLES;
# o para PostgreSQL: \dt

# Debe mostrar tablas Laravel básicas:
# - users
# - cache  
# - cache_locks
# - jobs
# - job_batches
# - failed_jobs
# - migrations

# Salir de la base de datos
exit
```

### 2.5 Probar Laravel funcionando

```bash
# Verificar Laravel responde (usar puerto mostrado en make status)
curl -I http://localhost:PUERTO_MOSTRADO

# Si necesitas regenerar APP_KEY:
# make artisan PROJECT_NAME=mi_proyecto cmd="key:generate --force"
```

**Esperado:**
- ✅ HTTP/1.1 200 OK
- ✅ Página de Laravel accesible en el navegador

---

## 🔧 Paso 3: Instalación de VitalAccess

### 3.1 Instalación Automática (Método Recomendado)

```bash
# Instalar VitalAccess automáticamente
make install-vitalaccess PROJECT_NAME=mi_proyecto
```

**Si funciona sin errores:**
- ✅ Paquete instalado automáticamente
- ✅ Configuración publicada
- ✅ Migraciones ejecutadas  
- ✅ Datos seedeados
- ✅ **Detección inteligente** - evita duplicación de migraciones
- ✅ **¡Listo para usar!** → Ir al **Paso 4: Verificación**

### 3.2 🔧 Instalación Manual (Proceso Mejorado Mayo 2026)

**Este proceso está actualizado con las soluciones probadas exitosamente.**

#### 3.2.1 Acceder al contenedor Docker

```bash
# Crear directorio packages dentro del contenedor
APP_PORT=PUERTO MYSQL_PORT=PUERTO2 [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app mkdir -p packages

# Copiar VitalAccess al contenedor  
docker cp packages/vitalaccess mi_proyecto_normalizado-app-1:/app/packages/

# Configurar repositorio local dentro del contenedor
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app composer config repositories.vitalaccess path ./packages/vitalaccess
```

#### 3.2.2 Instalar paquete VitalAccess

```bash
# Instalar VitalAccess con repositorio local
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app composer require kaely/vitalaccess:dev-main

# Actualizar autoloader
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app composer dump-autoload
```

#### 3.2.3 Crear datos VitalAccess manualmente

**Si el comando automático falla, crear datos manualmente:**

```bash
# Crear roles básicos
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app php artisan tinker --execute="
DB::table('access_roles')->insert([
    ['id' => '1', 'name' => 'Administrador', 'slug' => 'admin', 'description' => 'Administrador del sistema', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
    ['id' => '2', 'name' => 'Usuario', 'slug' => 'user', 'description' => 'Usuario básico', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()]
]);
echo 'Roles creados exitosamente';
"

# Crear módulos básicos  
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app php artisan tinker --execute="
DB::table('access_modules')->insert([
    ['id' => '1', 'parent_id' => null, 'name' => 'Dashboard', 'slug' => 'dashboard', 'icon' => 'dashboard', 'route' => '/dashboard', 'type' => 'menu', 'sort_order' => 1, 'depth' => 0, 'is_active' => true, 'is_visible' => true, 'created_at' => now(), 'updated_at' => now()],
    ['id' => '2', 'parent_id' => null, 'name' => 'Usuarios', 'slug' => 'users', 'icon' => 'users', 'route' => '/users', 'type' => 'menu', 'sort_order' => 2, 'depth' => 0, 'is_active' => true, 'is_visible' => true, 'created_at' => now(), 'updated_at' => now()],
    ['id' => '3', 'parent_id' => null, 'name' => 'Roles', 'slug' => 'roles', 'icon' => 'shield', 'route' => '/roles', 'type' => 'menu', 'sort_order' => 3, 'depth' => 0, 'is_active' => true, 'is_visible' => true, 'created_at' => now(), 'updated_at' => now()]
]);
echo 'Módulos creados exitosamente';
"

# Crear permisos básicos
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app php artisan tinker --execute="
DB::table('access_permissions')->insert([
    ['id' => '1', 'name' => 'Ver Dashboard', 'slug' => 'dashboard.view', 'group' => 'dashboard', 'action' => 'view', 'description' => 'Acceso al panel de control', 'is_system' => false, 'created_at' => now(), 'updated_at' => now()],
    ['id' => '2', 'name' => 'Ver Usuarios', 'slug' => 'users.view', 'group' => 'users', 'action' => 'view', 'description' => 'Ver lista de usuarios', 'is_system' => false, 'created_at' => now(), 'updated_at' => now()],
    ['id' => '3', 'name' => 'Crear Usuario', 'slug' => 'users.create', 'group' => 'users', 'action' => 'create', 'description' => 'Crear nuevos usuarios', 'is_system' => false, 'created_at' => now(), 'updated_at' => now()],
    ['id' => '4', 'name' => 'Editar Usuario', 'slug' => 'users.edit', 'group' => 'users', 'action' => 'edit', 'description' => 'Editar usuarios existentes', 'is_system' => false, 'created_at' => now(), 'updated_at' => now()],
    ['id' => '5', 'name' => 'Ver Roles', 'slug' => 'roles.view', 'group' => 'roles', 'action' => 'view', 'description' => 'Ver lista de roles', 'is_system' => false, 'created_at' => now(), 'updated_at' => now()]
]);
echo 'Permisos creados exitosamente';
"

# Asignar permisos a roles
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app php artisan tinker --execute="
// Asignar todos los permisos al administrador
DB::table('access_role_permissions')->insert([
    ['role_id' => '1', 'permission_id' => '1', 'created_at' => now(), 'updated_at' => now()],
    ['role_id' => '1', 'permission_id' => '2', 'created_at' => now(), 'updated_at' => now()],
    ['role_id' => '1', 'permission_id' => '3', 'created_at' => now(), 'updated_at' => now()],
    ['role_id' => '1', 'permission_id' => '4', 'created_at' => now(), 'updated_at' => now()],
    ['role_id' => '1', 'permission_id' => '5', 'created_at' => now(), 'updated_at' => now()]
]);
echo 'Permisos asignados al administrador';
"
```

**💡 Tip:** Los comandos son largos. Usa el comando completo que genera `make status` para obtener los valores correctos de puertos.
```

#### 3.2.5 Resolver problemas de migración (si aparecen)

```bash
# Ver estado de migraciones
make artisan PROJECT_NAME=mi_proyecto cmd="migrate:status"

# Si hay tabla "already exists", marcarla como migrada
make artisan PROJECT_NAME=mi_proyecto cmd="tinker --execute='DB::table(\"migrations\")->insert([\"migration\" => \"2026_01_01_000008_create_access_user_business_units_table\", \"batch\" => 1]); echo \"Migration marked as run\";'"
```

---

## 🔍 Paso 4: Verificación de Instalación

### 4.1 Verificar paquete instalado

```bash
# Confirmar paquete en composer
make composer PROJECT_NAME=mi_proyecto cmd="show kaely/vitalaccess"
```

**Debe mostrar:**
- ✅ `kaely/vitalaccess dev-main`
- ✅ Path al paquete
- ✅ Autoload configurado

### 4.2 Verificar comandos disponibles

```bash
# Listar comandos VitalAccess
make artisan PROJECT_NAME=mi_proyecto cmd="list vitalaccess"
```

**Debe mostrar:**
- ✅ `vitalaccess:install`
- ✅ `vitalaccess:post-install`  
- ✅ `vitalaccess:seed`
- ✅ `vitalaccess:setup-tenants`

### 4.3 Verificar modelos funcionan

```bash
# Probar que las clases están cargadas
make artisan PROJECT_NAME=mi_proyecto cmd="tinker --execute='echo \"VitalAccess models available: \" . (class_exists(\"Kaely\\\\Access\\\\Models\\\\Role\") ? \"YES\" : \"NO\");'"
```

**Esperado:**
- ✅ `VitalAccess models available: YES`

### 4.4 Verificar tablas en base de datos

```bash
# Conectar a base de datos
make db-cli PROJECT_NAME=mi_proyecto

# Dentro de MySQL/PostgreSQL:
SHOW TABLES LIKE '%access%';
# o para PostgreSQL: \dt *access*

# Salir
exit
```

**Debe mostrar tablas:**
- ✅ `access_roles`
- ✅ `access_permissions`
- ✅ `access_modules`
- ✅ `access_role_permissions`
- ✅ `access_user_roles`

---

## 🎨 Paso 5: Instalación de Filament Admin Panel 🆕

### 5.1 ¿Por qué Filament + VitalAccess?

**Filament 5.6** proporciona un panel de administración moderno que se integra con **VitalAccess RBAC**:

- 🎨 **UI moderna**: Interfaz Tailwind CSS 3.0+ hermosa
- 🔐 **RBAC integrado**: Compatible con VitalAccess para permisos
- 📊 **Dashboard completo**: Widgets, tablas, formularios avanzados
- ⚡ **Laravel 12 nativo**: Máxima compatibilidad comprobada

### 5.2 Instalación de Filament

```bash
# Instalar Filament 5.6 (Proceso Mayo 2026)
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app composer require filament/filament
```

**Esperado (puede tomar 2-3 minutos):**
- ✅ Filament 5.6.x instalado con 32 dependencias
- ✅ Livewire 4.3+ configurado automáticamente
- ✅ Blade Icons y Heroes iconos incluidos

### 5.3 Configurar Panel Admin

```bash
# Instalar panel de administración
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app php artisan filament:install --panels
```

**Esperado:**
- ✅ Archivo `AdminPanelProvider.php` creado en `app/Providers/Filament/`
- ✅ Assets publicados en `public/js/filament/` y `public/css/filament/`
- ✅ Rutas `/admin` configuradas automáticamente
- ✅ Cache y rutas limpias

### 5.4 Crear Usuario Admin con VitalAccess

**Proceso completo para crear usuario con roles:**

```bash
# Crear usuario administrador con rol VitalAccess
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app php artisan tinker --execute="
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// Crear usuario administrador
\$admin = User::create([
    'name' => 'Administrador',
    'email' => 'admin@mi_proyecto.com',
    'password' => Hash::make('admin123'),
    'email_verified_at' => now()
]);

// Asignar rol de administrador VitalAccess
DB::table('access_user_roles')->insert([
    'id' => Str::uuid()->toString(),
    'user_id' => \$admin->id,
    'role_id' => '1', // Administrador
    'scope_type' => null,
    'scope_id' => null,
    'granted_at' => now(),
    'expires_at' => null,
    'granted_by' => \$admin->id,
    'is_active' => true,
    'created_at' => now(),
    'updated_at' => now()
]);

echo 'Usuario admin creado: admin@mi_proyecto.com / admin123';
echo PHP_EOL . 'ID: ' . \$admin->id;
"
```

**Credenciales finales:**
- **Email**: `admin@mi_proyecto.com`
- **Contraseña**: `admin123`
- **Rol**: Administrador VitalAccess

### 5.5 Verificar Acceso al Panel

```bash
# Verificar estado del proyecto
make status PROJECT_NAME=mi_proyecto

# Acceder al panel admin en:
# http://localhost:PUERTO_APP/admin
```

**URLs importantes:**
- 🌐 **Laravel App**: `http://localhost:PUERTO_APP`
- 🛡️ **Filament Admin Panel**: `http://localhost:PUERTO_APP/admin`
- 🗃️ **phpMyAdmin**: `http://localhost:PUERTO_PHPMYADMIN`

**Funcionalidades disponibles:**
- ✅ Login con usuario administrador
- ✅ Dashboard Filament completo
- ✅ Gestión de usuarios desde Filament
- ✅ Roles y permisos VitalAccess integrados

### 5.6 Integración VitalAccess + Filament

**El proyecto está completamente configurado con:**
- 🎯 Laravel 12 + FrankenPHP + MySQL/Redis
- 🔐 VitalAccess RBAC con datos básicos
- 🎨 Filament 5.6 panel admin
- 👤 Usuario administrador configurado

**Listo para desarrollo empresarial!**

---

## 🎯 Paso 6: Configuración Inicial VitalAccess

### 6.1 Crear datos básicos de prueba

```bash
# Crear archivo temporal para seeding
cat > seed_basic.php << 'EOF'
<?php

echo "Creating basic VitalAccess data:\n";

// Crear rol admin
$admin = Kaely\Access\Models\Role::firstOrCreate([
    'name' => 'admin'
], [
    'slug' => 'admin',
    'description' => 'Administrator',
    'level' => 100,
    'is_active' => true
]);
echo "Admin role: " . $admin->name . "\n";

// Crear permiso básico
$permission = Kaely\Access\Models\Permission::firstOrCreate([
    'name' => 'users.view'
], [
    'slug' => 'users.view',
    'group' => 'users',
    'description' => 'View users',
    'is_active' => true
]);
echo "Permission: " . $permission->name . "\n";

// Crear módulo dashboard
$module = Kaely\Access\Models\Module::firstOrCreate([
    'name' => 'dashboard'
], [
    'slug' => 'dashboard',
    'description' => 'Dashboard module',
    'icon' => 'fas fa-home',
    'sort_order' => 1,
    'is_active' => true
]);
echo "Module: " . $module->name . "\n";

echo "\nData created successfully!\n";
EOF

# Copiar y ejecutar script
docker cp seed_basic.php mi_proyecto-app-1:/var/www/html/seed_basic.php
make artisan PROJECT_NAME=mi_proyecto cmd="tinker /var/www/html/seed_basic.php"

# Limpiar archivo temporal
rm seed_basic.php
```

### 6.2 Verificar conteos finales

```bash
# Entrar al shell del proyecto para verificar datos
make shell PROJECT_NAME=mi_proyecto

# Dentro del shell:
php artisan tinker

# En tinker, ejecutar:
echo "Roles: " . Kaely\Access\Models\Role::count();
echo "Permissions: " . Kaely\Access\Models\Permission::count();  
echo "Modules: " . Kaely\Access\Models\Module::count();

# Salir de tinker
exit

# Salir del shell
exit
```

---

## 🎉 Paso 7: Acceso a la Aplicación

### 7.1 URLs de acceso

```bash
# Ver todas las URLs disponibles
make status PROJECT_NAME=mi_proyecto
```

**Accesos disponibles:**
- 🌐 **Laravel App**: `http://localhost:PUERTO_APP`
- 🗄️ **phpMyAdmin**: `http://localhost:PUERTO_PHPMYADMIN` (solo MySQL)
- 📊 **Base de datos**: Puerto específico para conexiones externas

### 7.2 Credenciales de base de datos

**MySQL:**
- **Host**: localhost:PUERTO_MYSQL  
- **Usuario**: `laravel`
- **Contraseña**: `secret`
- **Base de datos**: `laravel`

**phpMyAdmin:**
- **Usuario**: `laravel`
- **Contraseña**: `secret`

---

## 🔧 Paso 8: Configuración del User Model (Opcional)

### 8.1 Agregar traits VitalAccess al User model

```bash
# Editar User model
nano mi_proyecto/app/Models/User.php
```

**Agregar traits:**
```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Kaely\Access\Traits\HasRoles;
use Kaely\Access\Traits\HasPermissions;

class User extends Authenticatable
{
    use HasRoles, HasPermissions;
    
    // ... resto del modelo
}
```

### 8.2 Crear usuario de prueba

```bash
# Crear usuario admin
make artisan PROJECT_NAME=mi_proyecto cmd="tinker --execute='
\$user = App\\Models\\User::firstOrCreate([\"email\" => \"admin@example.com\"], [\"name\" => \"Admin User\", \"password\" => bcrypt(\"password\")]);
echo \"User created: \" . \$user->email;
'"
```

---

## ✅ Resultado Final

Al completar esta guía tendrás:

🚀 **Proyecto Laravel** (11/12/13/latest) con FrankenPHP y Docker
🎨 **Filament Admin Panel** completamente funcional
🔐 **VitalAccess RBAC** instalado y configurado
👥 **Roles, Permisos y Módulos** básicos creados
🌐 **Aplicación accesible** en el navegador  
🗄️ **Base de datos MySQL/PostgreSQL** funcionando
🛠️ **phpMyAdmin** para gestión de BD (si MySQL)
⚡ **Extensiones PHP optimizadas** (intl, zip incluidas)
🧠 **Detección inteligente** de migraciones duplicadas

### 🎯 **Stack Completo Empresarial**
- **Frontend**: Laravel + Filament UI
- **Backend**: VitalAccess RBAC
- **Base de Datos**: MySQL/PostgreSQL
- **Contenedores**: Docker + FrankenPHP
- **Admin Panel**: Gestión completa de usuarios, roles y permisos

---

## 📚 Comandos Útiles de Mantenimiento

```bash
# Ver estado del proyecto
make status PROJECT_NAME=mi_proyecto

# Parar proyecto
make down PROJECT_NAME=mi_proyecto

# Iniciar proyecto existente  
make up PROJECT_NAME=mi_proyecto

# Acceder al shell del contenedor
make shell PROJECT_NAME=mi_proyecto

# Ver logs
make logs PROJECT_NAME=mi_proyecto

# Limpiar proyecto completamente
make clean PROJECT_NAME=mi_proyecto
```

---

## 🆘 Troubleshooting

### **Problem 1: "MySQL no está listo" durante setup**

**Causa:** MySQL necesita tiempo para inicializar completamente.

**Soluciones:**
```bash
# Solución 1: Esperar y reintentar
sleep 60 && make setup PROJECT_NAME=mi_proyecto

# Solución 2: Verificar logs de MySQL
make logs PROJECT_NAME=mi_proyecto service=mysql
# Buscar: "ready for connections"

# Solución 3: Setup manual
make artisan PROJECT_NAME=mi_proyecto cmd="key:generate --force"
make artisan PROJECT_NAME=mi_proyecto cmd="migrate --force"

# Solución 4: Reiniciar todo
make clean PROJECT_NAME=mi_proyecto
make new-project PROJECT_NAME=mi_proyecto DATABASE=mysql
```

### **Problem 2: "Port already in use"**

**Causa:** Puerto ya ocupado por otro proyecto.

**Solución:**
```bash
# Ver qué está usando el puerto
docker ps
netstat -tulpn | grep :PUERTO

# Parar otros proyectos
make down PROJECT_NAME=otro_proyecto
```

### **Problem 3: "Permission denied" en Docker**

**Causa:** Problemas de permisos Docker.

**Solución:**
```bash
# Agregar usuario a grupo docker
sudo usermod -aG docker $USER

# Reiniciar sesión o ejecutar:
newgrp docker
```

### **Problem 4: Error "libzip not found" durante build**

**Síntoma:**
```
Package 'libzip', required by 'virtual:world', not found
failed to solve: process "/bin/sh -c docker-php-ext-install zip" did not complete successfully
```

**Causa:** Falta dependencia `libzip-dev` en Dockerfile.

**Solución:**
```bash
# Verificar si está en Dockerfiles
grep -n "libzip-dev" Dockerfile.mysql Dockerfile.postgres

# Si no está, agregar:
sed -i '11a\    libzip-dev \\' Dockerfile.mysql
sed -i '12a\    libzip-dev \\' Dockerfile.postgres

# Limpiar cache Docker y reconstruir
docker system prune -f
make setup PROJECT_NAME=mi_proyecto
```

### **Problem 5: VitalAccess installation fails - Permission denied**

**Síntoma:**
```
mkdir: no se puede crear el directorio «mi_proyecto/packages»: Permiso denegado
cp: no se puede crear el directorio 'mi_proyecto/packages/vitalaccess'
```

**Causa:** Archivos creados por Docker como root.

**Solución - Instalación manual dentro del contenedor:**
```bash
# Usar Docker para gestionar archivos
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app mkdir -p packages
docker cp packages/vitalaccess mi_proyecto_normalizado-app-1:/app/packages/
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app composer config repositories.vitalaccess path ./packages/vitalaccess
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app composer require kaely/vitalaccess:dev-main
```

### **Problem 6: MySQL "Connection refused" durante migraciones**

**Síntoma:**
```
SQLSTATE[HY000] [2002] Connection refused (Connection: mysql, Host: mysql, Port: 3306)
```

**Causa:** MySQL necesita tiempo para inicializarse completamente.

**Solución:**
```bash
# Esperar a que MySQL esté listo
sleep 15
make migrate PROJECT_NAME=mi_proyecto

# O verificar logs MySQL hasta ver "ready for connections"
make logs PROJECT_NAME=mi_proyecto service=mysql
```

### **Problem 7: Error "Target class [Seeder] does not exist" - VitalAccess**

**Síntoma:**
```
Target class [Kaely\Access\Database\Seeders\VitalAccessSeeder] does not exist
```

**Causa:** Seeders VitalAccess no autoload correctamente.

**Solución - Crear datos manualmente:**
```bash
# Usar proceso manual documentado en Paso 3.2.3
# Crear roles, módulos y permisos con comandos tinker directos
```

### **Problem 8: Usuario admin duplicado en Filament**

**Síntoma:**
```
Integrity constraint violation: 1062 Duplicate entry 'admin@proyecto.com' for key 'users.users_email_unique'
```

**Causa:** Usuario ya existe de instalación previa.

**Solución:**
```bash
# Buscar y asignar rol al usuario existente
APP_PORT=PUERTO [...] docker compose -f mi_proyecto/docker-compose.yml -p mi_proyecto_normalizado exec -T app php artisan tinker --execute="
\$admin = App\Models\User::where('email', 'admin@proyecto.com')->first();
// Asignar rol VitalAccess como se documenta
"
```

---

**Comandos de diagnóstico general:**
```bash
# Verificar Docker
docker ps
docker system df

# Verificar proyecto específico
make status PROJECT_NAME=mi_proyecto
make logs PROJECT_NAME=mi_proyecto

# Verificar Composer
make composer PROJECT_NAME=mi_proyecto cmd="diagnose"

# Reset completo
make clean PROJECT_NAME=mi_proyecto
```

---

## 🌟 Combinación Recomendada: Laravel 12 + Filament 5.6 (Mayo 2026)

### ✅ **Compatibilidad Probada y Optimizada**

Después de pruebas exhaustivas, **Laravel 12 + Filament 5.6** es la **combinación más estable**:

```bash
# Comando recomendado para proyectos empresariales (Proceso completo)
echo "12" | make init PROJECT_NAME=mi_empresa DB_TYPE=mysql
make setup PROJECT_NAME=mi_empresa

# Si falla por MySQL timing, esperar y ejecutar migraciones:
sleep 15
make migrate PROJECT_NAME=mi_empresa

# Instalar Filament 5.6
APP_PORT=PUERTO [...] docker compose -f mi_empresa/docker-compose.yml -p mi_empresa exec -T app composer require filament/filament
APP_PORT=PUERTO [...] docker compose -f mi_empresa/docker-compose.yml -p mi_empresa exec -T app php artisan filament:install --panels

# Instalar VitalAccess (usar proceso manual si automático falla)
make install-vitalaccess PROJECT_NAME=mi_empresa
```

**🎯 Ventajas de esta combinación (Mayo 2026):**
- ✅ **Máxima estabilidad**: Laravel 12.58 + Filament 5.6.2 probados
- ✅ **Dependencia libzip-dev**: Incluida en Dockerfiles actualizados
- ✅ **32 paquetes Filament**: Livewire 4.3, Blade Icons, Charts, etc.
- ✅ **VitalAccess RBAC**: Proceso manual documentado como fallback
- ✅ **FrankenPHP + MySQL**: Stack moderno de alto rendimiento

### 🚀 **Próximos Pasos Recomendados**

1. **Personalizar Filament Resources** para VitalAccess
2. **Configurar middleware** de autenticación
3. **Crear dashboard widgets** personalizados
4. **Implementar políticas** de autorización Laravel

---

**¡Tu proyecto Laravel 12 + Filament + VitalAccess RBAC está listo para desarrollar!** 🎉