# 🚀 **Guía Completa: Laravel 13 + VitalAccess v5 + Filament 5.x**

> **Documentación para crear un proyecto completo desde cero**  
> ✅ **TODAS las correcciones DE RAÍZ integradas**  
> ✅ **Compatible con Laravel 11, 12 y 13**  
> ✅ **Sin errores de importaciones Filament 5.x**  
> ✅ **Comandos automáticos** para UserResource y Panel Admin

---

## 📚 **Índice**

1. [Requisitos previos](#-requisitos-previos)
2. [Crear proyecto Laravel 13](#-paso-1-crear-proyecto-laravel-13)
3. [Configurar Docker](#-paso-2-configurar-proyecto-con-docker)
4. [Instalar VitalAccess v5](#-paso-3-instalar-vitalaccess-v5--filament-5x)
5. [Ejecutar seeders](#-paso-4-ejecutar-seeders-de-vitalaccess)
6. [Configurar Panel Admin](#-paso-41-configurar-panel-admin-automatizado)
7. [Crear Resource de Usuarios](#-paso-42-crear-resource-de-usuarios-corrección-de-raíz)
8. [Verificar instalación](#-paso-5-verificar-instalación)
9. [Verificar funcionalidad](#-paso-6-verificar-funcionalidad-vitalaccess)
10. [Comandos útiles](#-comandos-útiles-para-el-proyecto)
11. [Verificación final](#-verificación-final-exitosa)
12. [Solución de problemas](#-en-caso-de-errores)
13. [Información del proyecto](#-información-del-proyecto)

---

## 🔧 **Requisitos previos**

### Software necesario:
- ✅ **Docker** y **Docker Compose** instalados
- ✅ **Git** disponible  
- ✅ Acceso al directorio de trabajo `/home/kaely/workspace_ultra/Desarrollo/test`
- ✅ Permisos de escritura en el directorio

### Versiones compatibles:
- **Laravel:** 11.x (LTS), 12.x, 13.
- **PHP:** 8.3+
- **Filament:** 5.x
- **MySQL:** 8.0+
- **Redis:** 7.x

---

## 📦 **PASO 1: Crear proyecto Laravel 13**

### Comando principal:
```bash
# Navegar al directorio de trabajo
cd /home/kaely/workspace_ultra/Desarrollo/test

# Crear proyecto Laravel 13 con Docker
make new-project-l13 PROJECT_NAME=mi-proyecto
```

### Opciones alternativas de versión:
```bash
# Laravel 11 LTS (más estable, mejor soporte a largo plazo)
make new-project-l11 PROJECT_NAME=mi-proyecto

# Laravel 12 (balance entre estabilidad y funcionalidades)
make new-project-l12 PROJECT_NAME=mi-proyecto

# Laravel 13 (más reciente, puede tener incompatibilidades menores)
make new-project-l13 PROJECT_NAME=mi-proyecto

# Laravel última versión disponible
make new-project-latest PROJECT_NAME=mi-proyecto
```

### Resultado esperado:
```
✓ Proyecto mi-proyecto creado exitosamente
Para continuar:
  make setup PROJECT_NAME=mi-proyecto
```

### ⚠️ **Notas importantes:**
- El nombre del proyecto debe usar guiones o guiones bajos (no espacios)
- Laravel 11 es LTS y recomendado para producción
- Laravel 13 es compatible pero puede requerir ajustes menores

---

## 🐳 **PASO 2: Configurar proyecto con Docker**

### Configuración automática:
```bash
# Configurar Docker, dependencias y base de datos
make setup PROJECT_NAME=mi-proyecto
```

### Proceso incluye:
- 🏗️ **Construcción de imagen Docker** con PHP 8.4 + FrankenPHP
- 🚀 **Inicio de contenedores** (App, MySQL, Redis, phpMyAdmin)
- 📦 **Instalación de dependencias** vía Composer
- 🔑 **Generación de application key**
- 🗃️ **Configuración de base de datos** y migraciones iniciales

### Resultado esperado:
```
✓ Proyecto mi-proyecto listo:
  🌐 Laravel: http://localhost:8XXX
  🗃️  phpMyAdmin: http://localhost:8XXX
  🐬 MySQL: localhost:8XXX  
  🔴 Redis: localhost:8XXX
```

### 🔍 **Verificación:**
- La aplicación Laravel debe responder en la URL indicada
- phpMyAdmin debe ser accesible para gestión de base de datos
- Los contenedores deben estar ejecutándose sin errores

---

## 🛡️ **PASO 3: Instalar VitalAccess v5 + Filament 5.x**

### Instalación completa automática:
```bash
# Instalar VitalAccess v5 con todas las correcciones DE RAÍZ
make install-vitalaccess PROJECT_NAME=mi-proyecto
```


### ¿Qué hace este comando?

#### **3.1 Preparación del paquete:**
- 📦 Copia VitalAccess v5 al contenedor
- 🔧 Configura repositorio local de Composer  
- 🧹 Limpia caché de Composer

#### **3.2 Instalación de dependencias:**
- 📥 Instala **Filament 5.x** (`filament/filament:^5.0`)
- 📥 Instala **VitalAccess v5** (`vitalsaas/vitalaccess:dev-main`)
- 🔗 Resuelve dependencias automáticamente

#### **3.3 Configuración de Filament:**
- 🛡️ Instala panel de administración Filament
- 📄 Publica assets y configuraciones
- 🎨 Configura tema y recursos

#### **3.4 Configuración de VitalAccess:**
- 📤 Publica migraciones de VitalAccess (8 tablas)
- 📤 Publica seeders con corrección DE RAÍZ
- 📤 Publica modelos, traits y middleware
- 🗃️ Ejecuta migraciones automáticamente

#### **3.5 Usuario administrador:**
- 👤 Crea usuario administrador del panel
- 🔑 Configura credenciales por defecto

### Resultado esperado:
```
🎉 VitalAccess v5 + Filament 5.x instalado exitosamente!

📋 Acceso rápido:
  🌐 App: http://localhost:8XXX
  🛡️ Admin: http://localhost:8XXX/admin  
  👤 Usuario: admin@mi-proyecto.test
  🔑 Password: password

✅ 8 tablas VitalAccess creadas correctamente
✅ Panel Filament instalado
✅ Modelos VitalAccess funcionando
```

---

## 🌱 **PASO 4: Ejecutar seeders de VitalAccess**

### Comando de seeding:
```bash
# Ejecutar seeder con corrección DE RAÍZ (crea usuarios Y asigna roles)
make artisan PROJECT_NAME=mi-proyecto cmd="db:seed --class=VitalSaaS\\VitalAccess\\Database\\Seeders\\VitalAccessModulesSeeder"
```

### ⚠️ **Si aparece error de namespace:**
Si obtienes el error: `Target class [Database\Seeders\VitalSaaSVitalAccessDatabaseSeedersVitalAccessModulesSeeder] does not exist`

**Solución:** Ejecuta directamente con Docker:
```bash
# Reemplaza 'mi-proyecto' con tu PROJECT_NAME
docker exec mi-proyecto-app-1 php artisan db:seed --class="VitalSaaS\\VitalAccess\\Database\\Seeders\\VitalAccessModulesSeeder"
```

> **Nota:** Los contenedores Docker se crean con sufijo `-1` (ej: `mi-proyecto-app-1`)

### ¿Qué hace el seeder corregido?

#### **4.1 Crea categorías de roles:**
- 📋 Administración
- 📋 Operacional  
- 📋 Consulta

#### **4.2 Crea roles del sistema:**
- 👑 **Super Administrador** - Acceso total al sistema
- 🛡️ **Administrador** - Gestión de usuarios y configuración
- 👤 **Manager** - Gestión operacional
- 👁️ **Viewer** - Solo lectura

#### **4.3 Crea permisos:**
- ✅ Gestión de usuarios
- ✅ Gestión de roles  
- ✅ Gestión de permisos
- ✅ Gestión de módulos
- ✅ Configuración del sistema

#### **4.4 Crea módulos de navegación:**
- 📊 Dashboard
- 👥 Gestión de usuarios
- 🛡️ Control de acceso
- ⚙️ Configuración

#### **4.5 ⭐ CORRECCIÓN DE RAÍZ - Crea usuarios y asigna roles automáticamente:**
- 👑 `superadmin@vitalaccess.test` → Super Administrador
- 🛡️ `admin@vitalaccess.test` → Administrador  
- 👤 `manager@vitalaccess.test` → Manager

### Resultado esperado:
```
INFO  Seeding database.  

✅ Usuarios por defecto creados y roles asignados:
   - Super Admin: superadmin@vitalaccess.test / superadmin123
   - Admin: admin@vitalaccess.test / admin123
   - Manager: manager@vitalaccess.test / manager123
```

### ⚠️ **Nota importante:**
Esta es la **corrección DE RAÍZ** que resuelve el problema de la tabla `access_user_roles` vacía. Ya NO necesitas ejecutar SQL manual para asignar roles.

---

## ⚙️ **PASO 4.1: Configurar Panel Admin (AUTOMATIZADO)**

### **🤖 Comando automático (SIN intervención manual):**
```bash
# Configurar AdminPanelProvider automáticamente 
make artisan PROJECT_NAME=mi-proyecto cmd="vitalaccess:configure-panel"
```

### **✅ Este comando hace TODO automáticamente:**
- ✅ **Agrega importaciones** de recursos y widgets VitalAccess
- ✅ **Registra recursos** (Roles, Permisos, Módulos) 
- ✅ **Agrega widgets** (VitalAccessStatsWidget)
- ✅ **Detecta configuración existente** (no duplica)
- ✅ **Sin edición manual** de archivos

### **Resultado esperado:**
```
Configuring AdminPanelProvider with VitalAccess integration...
✅ AdminPanelProvider configured successfully!
🔄 Clear cache: php artisan cache:clear
🌐 Access: /admin with VitalAccess resources
```

### ⚠️ **Si no tienes permisos para editar:**
```bash
# Crear archivo corregido
cat > /tmp/AdminPanelProvider_temp.php << 'EOF'
# (Copia todo el contenido del archivo original y agrega las líneas mencionadas)
EOF

# Copiar al contenedor
docker cp /tmp/AdminPanelProvider_temp.php mi-proyecto-app-1:/app/app/Providers/Filament/AdminPanelProvider.php
```

---

## 👥 **PASO 4.2: Crear Resource de Usuarios (CORRECCIÓN DE RAÍZ)**

### **🚀 Comando automático con todas las correcciones incluidas:**
```bash
# Crear UserResource con VitalAccess + Filament 5.x (SIN ERRORES)
make artisan PROJECT_NAME=mi-proyecto cmd="vitalaccess:user-resource"
```

### **✅ Este comando incluye TODAS las correcciones de raíz:**
- ✅ **UserResource** con navegación correcta en grupo VitalAccess
- ✅ **UserForm** con integración de roles (`accessRoles`)
- ✅ **UsersTable** con importaciones **correctas** de Filament 5.x 
- ✅ **Páginas** (List, Create, Edit) completamente funcionales
- ✅ **User Model** actualizado con trait `HasVitalAccess`
- ✅ **Sin errores** de importaciones o namespaces

### **Archivos creados automáticamente:**
```
app/Filament/Resources/Users/
├── UserResource.php          # ✅ Configurado para VitalAccess
├── Schemas/UserForm.php      # ✅ Con roles integrados  
├── Tables/UsersTable.php     # ✅ Filament 5.x compatible
└── Pages/
    ├── ListUsers.php         # ✅ Lista con acciones
    ├── CreateUser.php        # ✅ Crear con roles
    └── EditUser.php          # ✅ Editar con roles

app/Models/User.php           # ✅ Actualizado automáticamente
```

### **Resultado:** 
- ✅ Menú "Usuarios" en grupo VitalAccess
- ✅ Asignación de roles por usuario  
- ✅ Gestión completa de usuarios con RBAC
- ✅ **SIN ERRORES** de importaciones Filament 5.x
- ✅ **Funcionamiento inmediato** sin configuración adicional

---

## ✅ **PASO 5: Verificar instalación**

### **5.1 Verificar rutas de VitalAccess:**
```bash
make artisan PROJECT_NAME=mi-proyecto cmd="route:list" | grep -E "admin|access"
```

**Debe mostrar rutas como:**
```
GET|HEAD  admin/access-roles
GET|HEAD  admin/access-roles/create  
GET|HEAD  admin/access-roles/{record}/edit
GET|HEAD  admin/access-permissions
GET|HEAD  admin/access-permissions/create
GET|HEAD  admin/access-permissions/{record}/edit  
GET|HEAD  admin/access-modules
GET|HEAD  admin/access-modules/create
GET|HEAD  admin/access-modules/{record}/edit
```

### **5.2 Verificar tabla access_user_roles poblada:**
```bash
make artisan PROJECT_NAME=mi-proyecto cmd="tinker --execute=\"use Illuminate\\Support\\Facades\\DB; echo 'Usuarios con roles: ' . DB::table('access_user_roles')->count();\""
```

**Debe mostrar:**
```
Usuarios con roles: 3
```

### **5.3 Verificar asignaciones específicas:**
```bash
make artisan PROJECT_NAME=mi-proyecto cmd="tinker --execute=\"use Illuminate\\Support\\Facades\\DB; \\\$results = DB::table('access_user_roles')->join('users', 'access_user_roles.user_id', '=', 'users.id')->join('access_roles', 'access_user_roles.role_id', '=', 'access_roles.id')->select('users.email', 'access_roles.name as role_name')->get(); foreach(\\\$results as \\\$result) { echo \\\$result->email . ' -> ' . \\\$result->role_name . PHP_EOL; }\""
```

**Debe mostrar:**
```
superadmin@vitalaccess.test -> Super Administrador
admin@vitalaccess.test -> Administrador  
manager@vitalaccess.test -> Manager
```

### **5.4 Verificar estado de la aplicación:**
```bash
make artisan PROJECT_NAME=mi-proyecto cmd="about"
```

**Debe mostrar Filament v5.x instalado sin errores.**

### **5.5 Acceder al panel de administración:**
```bash
# Obtener URLs del proyecto
make status PROJECT_NAME=mi-proyecto
```

**Abrir en el navegador:** `http://localhost:XXXX/admin`

---

## 🎯 **PASO 6: Verificar funcionalidad VitalAccess**

### **6.1 Credenciales de acceso:**

#### **Panel de administración principal:**
- 📧 **Email:** `admin@mi-proyecto.test`
- 🔑 **Password:** `password`

#### **Usuarios VitalAccess adicionales:**
- 👑 **Super Admin:** `superadmin@vitalaccess.test` / `superadmin123`
- 🛡️ **Admin:** `admin@vitalaccess.test` / `admin123`
- 👤 **Manager:** `manager@vitalaccess.test` / `manager123`

### **6.2 Dashboard del panel admin:**

#### **📊 Widgets visibles:**
- **VitalAccess Widget** - Estadísticas generales del sistema
- **VitalAccess Stats Widget** - Contadores detallados
- **Account Widget** - Información de la cuenta actual
- **Filament Info Widget** - Información del framework

#### **📈 Métricas mostradas:**
- 👥 **Usuarios totales** en el sistema
- 🛡️ **Roles activos** configurados
- 🔑 **Permisos** disponibles  
- 📦 **Módulos** de navegación activos

### **6.3 Navegación "VitalAccess":**

#### **En el sidebar izquierdo debe aparecer:**
```
📊 Dashboard
├── VitalAccess
│   ├── 🛡️ Roles
│   ├── 🔑 Permisos  
│   └── 📦 Módulos
```

#### **Funcionalidades disponibles:**

##### **🛡️ Gestión de Roles (`/admin/access-roles`):**
- ➕ Crear nuevos roles
- ✏️ Editar roles existentes  
- 👥 Asignar permisos a roles
- 📊 Ver usuarios asignados por rol
- 🏷️ Categorizar roles

##### **🔑 Gestión de Permisos (`/admin/access-permissions`):**
- ➕ Crear nuevos permisos
- ✏️ Editar permisos existentes
- 🏗️ Definir acciones del sistema
- 📋 Agrupar permisos por módulo

##### **📦 Gestión de Módulos (`/admin/access-modules`):**
- ➕ Crear módulos de navegación
- ✏️ Configurar rutas y URLs
- 🎨 Asignar iconos y estilos
- 👁️ Controlar visibilidad
- 📊 Gestionar orden de navegación

### **6.4 Datos precargados automáticamente:**

#### **Roles creados:**
1. **Super Administrador** - Acceso completo
2. **Administrador** - Gestión general  
3. **Manager** - Operaciones
4. **Viewer** - Solo lectura

#### **Permisos del sistema:**
- Gestión de usuarios y roles
- Control de acceso y permisos
- Configuración de módulos
- Administración del sistema

#### **Módulos de navegación:**
- Dashboard principal
- Gestión de usuarios
- Control de acceso VitalAccess
- Configuración del sistema

#### **✅ Usuarios con roles asignados:**
- 3 usuarios creados automáticamente
- Roles asignados correctamente
- Acceso inmediato al sistema

---

## 🛠️ **Comandos útiles para el proyecto**

### **Gestión de contenedores:**
```bash
# Entrar al shell del contenedor de la aplicación
make shell PROJECT_NAME=mi-proyecto

# Ver logs en tiempo real de la aplicación  
make logs PROJECT_NAME=mi-proyecto

# Ver logs de todos los servicios
make logs-all PROJECT_NAME=mi-proyecto

# Reiniciar todos los contenedores
make restart PROJECT_NAME=mi-proyecto

# Ver estado de los contenedores
make ps PROJECT_NAME=mi-proyecto

# Estado detallado de los servicios
make status PROJECT_NAME=mi-proyecto
```

### **Base de datos:**
```bash
# Acceder a la consola de MySQL
make db-cli PROJECT_NAME=mi-proyecto

# Acceder específicamente a MySQL
make mysql-cli PROJECT_NAME=mi-proyecto

# Ejecutar migraciones
make migrate PROJECT_NAME=mi-proyecto

# Resetear base de datos (¡CUIDADO! Borra datos)
make fresh PROJECT_NAME=mi-proyecto
```

### **Laravel Artisan:**
```bash
# Ejecutar comando artisan personalizado
make artisan PROJECT_NAME=mi-proyecto cmd="COMANDO"

# Ejemplos útiles:
make artisan PROJECT_NAME=mi-proyecto cmd="optimize:clear"
make artisan PROJECT_NAME=mi-proyecto cmd="config:clear"
make artisan PROJECT_NAME=mi-proyecto cmd="route:clear"
make artisan PROJECT_NAME=mi-proyecto cmd="view:clear"

# Acceder a Tinker para debugging
make tinker PROJECT_NAME=mi-proyecto
```

### **Composer:**
```bash
# Ejecutar comando composer personalizado
make composer PROJECT_NAME=mi-proyecto cmd="COMANDO"

# Ejemplos:
make composer PROJECT_NAME=mi-proyecto cmd="dump-autoload"
make composer PROJECT_NAME=mi-proyecto cmd="show vitalsaas/vitalaccess"
```

### **Testing:**
```bash
# Ejecutar suite de tests
make test PROJECT_NAME=mi-proyecto
```

### **Limpieza y mantenimiento:**
```bash
# Limpiar todos los cachés de Laravel
make cache-clear PROJECT_NAME=mi-proyecto

# Detener proyecto (conserva datos y volúmenes)
make down PROJECT_NAME=mi-proyecto

# Limpiar proyecto (elimina contenedores y volúmenes)
make clean PROJECT_NAME=mi-proyecto

# Eliminación completa (contenedores, volúmenes e imágenes)
make nuke PROJECT_NAME=mi-proyecto
```

### **Otros servicios:**
```bash
# Acceder a Redis CLI
make redis-cli PROJECT_NAME=mi-proyecto
```

---

## ✅ **Verificación final exitosa**

### **Tu proyecto está funcionando correctamente si:**

#### **✅ Infraestructura básica:**
- ✅ **Laravel 13 corriendo** sin errores en la URL asignada
- ✅ **Base de datos MySQL** conectada y funcionando  
- ✅ **Redis** operativo para cache y sesiones
- ✅ **phpMyAdmin** accesible para gestión de BD

#### **✅ Panel de administración:**
- ✅ **Panel Filament 5.x** accesible en `/admin`
- ✅ **Login funcionando** con las credenciales configuradas
- ✅ **Dashboard cargando** sin errores de JavaScript o PHP

#### **✅ VitalAccess integrado:**
- ✅ **Navegación "VitalAccess"** visible en sidebar
- ✅ **3 recursos funcionando:** Roles, Permisos, Módulos
- ✅ **Widgets mostrando datos** en el dashboard

#### **✅ Base de datos poblada:**
- ✅ **8 tablas VitalAccess** creadas correctamente
- ✅ **3 usuarios con roles** en `access_user_roles`
- ✅ **Datos de prueba** disponibles para testing

#### **✅ Funcionalidad CRUD:**
- ✅ **Crear, leer, actualizar, eliminar** roles
- ✅ **Gestión de permisos** completa
- ✅ **Configuración de módulos** operativa

---

## 🚨 **En caso de errores**

### **Diagnóstico inicial:**
```bash
# Limpiar cachés y verificar estado
make artisan PROJECT_NAME=mi-proyecto cmd="config:clear"
make artisan PROJECT_NAME=mi-proyecto cmd="route:clear" 
make artisan PROJECT_NAME=mi-proyecto cmd="view:clear"

# Ver logs detallados
make logs PROJECT_NAME=mi-proyecto

# Verificar estado de contenedores
make ps PROJECT_NAME=mi-proyecto
```

### **Errores comunes y soluciones:**

#### **🔥 Error: "VitalAccess routes not found"**
```bash
# Verificar que los recursos estén registrados
make artisan PROJECT_NAME=mi-proyecto cmd="route:list" | grep access

# Si no aparecen, verificar AdminPanelProvider
make shell PROJECT_NAME=mi-proyecto
# Dentro del contenedor:
cat app/Providers/Filament/AdminPanelProvider.php
```

#### **🔥 Error: "access_user_roles table empty"**
```bash
# Re-ejecutar el seeder corregido
make artisan PROJECT_NAME=mi-proyecto cmd="db:seed --class=VitalSaaS\\VitalAccess\\Database\\Seeders\\VitalAccessModulesSeeder"

# Verificar resultado
make artisan PROJECT_NAME=mi-proyecto cmd="tinker --execute=\"echo DB::table('access_user_roles')->count();\""
```

#### **🔥 Error: "Filament panel not loading"**
```bash
# Re-instalar panel de Filament
make artisan PROJECT_NAME=mi-proyecto cmd="filament:install --panels"

# Limpiar y regenerar assets
make artisan PROJECT_NAME=mi-proyecto cmd="optimize:clear"
make artisan PROJECT_NAME=mi-proyecto cmd="filament:optimize"
```

#### **🔥 Error: "Database connection refused"**
```bash
# Verificar estado de MySQL
make ps PROJECT_NAME=mi-proyecto

# Reiniciar servicios
make restart PROJECT_NAME=mi-proyecto

# Verificar configuración
make shell PROJECT_NAME=mi-proyecto
cat .env | grep DB_
```

#### **🔥 Error: "VitalAccess resources with wrong namespace"**
```bash
# Limpiar recursos copiados incorrectamente
make shell PROJECT_NAME=mi-proyecto
rm -rf app/Filament/Resources/ app/Filament/Widgets/ app/Filament/Pages/

# Limpiar autoload
composer dump-autoload

# Reiniciar contenedores
make restart PROJECT_NAME=mi-proyecto
```

### **Reinstalación completa:**
```bash
# Si los errores persisten, reinstalar desde cero:
make clean PROJECT_NAME=mi-proyecto

# Luego seguir todos los pasos desde PASO 1
```

### **Soporte adicional:**
- 📖 **Documentación Laravel:** https://laravel.com/docs
- 📖 **Documentación Filament:** https://filamentphp.com/docs  
- 🐛 **Issues del proyecto:** https://github.com/anthropics/claude-code/issues

---

## 📞 **Información del proyecto**

- **Creado:** Mayo 2026
- **Versiones:** Laravel 11/12/13, Filament 5.x, VitalAccess v5
- **Autor:** Claude Sonnet 4 
- **Licencia:** MIT
- **Correcciones:** DE RAÍZ aplicadas (no parches)

---

**✨ ¡Disfruta desarrollando con Laravel + VitalAccess + Filament! ✨**