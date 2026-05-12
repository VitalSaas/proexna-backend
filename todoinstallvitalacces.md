# 📋 TODO: Instalación Completa VitalAccess RBAC

## 🎯 Objetivo
Instalar VitalAccess RBAC (roles, permisos, módulos) con UI Filament en proyectos Laravel usando el generador automatizado.

---

## ✅ Checklist de Instalación

### **📦 1. Preparación del Entorno**
- [ ] Proyecto Laravel funcionando (make status PROJECT_NAME=tu_proyecto)
- [ ] Contenedores corriendo (app, MySQL/PostgreSQL, Redis)
- [ ] VitalAccess clonado en `packages/vitalaccess`

```bash
# Verificar proyecto activo
make status PROJECT_NAME=tu_proyecto

# Clonar VitalAccess si no existe
gh repo clone VicTania/vitalaccess packages/vitalaccess
```

### **🚀 2. Instalación Automática (Método Recomendado)**
- [ ] Ejecutar instalador automático
- [ ] Verificar instalación exitosa
- [ ] Corregir errores menores si aparecen

```bash
# Ejecutar instalador automático
make install-vitalaccess PROJECT_NAME=tu_proyecto

# Si funciona sin errores, ¡listo! 🎉
# Si hay errores, continuar con pasos manuales
```

### **🔧 3. Instalación Manual (Si automática falla)**

#### **3.1 Limpiar ambiente**
- [ ] Limpiar cache de Composer
- [ ] Restaurar composer.json limpio

```bash
# Limpiar cache
make composer PROJECT_NAME=tu_proyecto cmd="clear-cache"

# Si existe backup, restaurarlo
cd tu_proyecto
cp composer.json.backup composer.json  # Si existe
cd ..
```

#### **3.2 Configurar repositorio local**
- [ ] Copiar VitalAccess al proyecto
- [ ] Configurar composer.json
- [ ] Verificar configuración

```bash
# Copiar VitalAccess al proyecto
cp -r packages/vitalaccess tu_proyecto/packages/vitalaccess

# Configurar composer.json
cd tu_proyecto
cat composer.json | jq '.repositories = [{
    "type": "path",
    "url": "./packages/vitalaccess",
    "options": {"symlink": true}
}]' > composer.json.tmp && mv composer.json.tmp composer.json

cd ..
```

#### **3.3 Corregir error de sintaxis (si existe)**
- [ ] Verificar PostInstallCommand.php
- [ ] Corregir línea problemática

```bash
# Verificar si existe el error
grep -n "}\';$" tu_proyecto/packages/vitalaccess/src/Console/Commands/PostInstallCommand.php

# Si existe, corregir
sed -i "/}\';$/d" tu_proyecto/packages/vitalaccess/src/Console/Commands/PostInstallCommand.php
```

#### **3.4 Instalar paquete**
- [ ] Instalar con Composer
- [ ] Verificar symlink creado
- [ ] Verificar autoload

```bash
# Instalar VitalAccess
make composer PROJECT_NAME=tu_proyecto cmd="require kaely/vitalaccess:dev-main"

# Verificar instalación
make composer PROJECT_NAME=tu_proyecto cmd="show kaely/vitalaccess"
```

#### **3.5 Post-instalación**
- [ ] Ejecutar post-install
- [ ] Verificar migraciones
- [ ] Comprobar configuración

```bash
# Post-instalación automática
make artisan PROJECT_NAME=tu_proyecto cmd="vitalaccess:post-install --force"

# Si falla, instalación manual
make artisan PROJECT_NAME=tu_proyecto cmd="vitalaccess:install --seed"
```

### **📊 4. Verificación de la Instalación**

#### **4.1 Verificar archivos**
- [ ] Configuración publicada: `config/access.php`
- [ ] Migraciones ejecutadas
- [ ] Modelos disponibles

```bash
# Verificar configuración
ls tu_proyecto/config/access.php

# Verificar migraciones
make artisan PROJECT_NAME=tu_proyecto cmd="migrate:status"

# Verificar modelos
make artisan PROJECT_NAME=tu_proyecto cmd="tinker --execute='echo get_class(new Kaely\\\\Access\\\\Models\\\\Role);'"
```

#### **4.2 Verificar funcionalidad**
- [ ] Crear role de prueba
- [ ] Crear permission de prueba
- [ ] Verificar relaciones

```bash
# Acceder al shell
make shell PROJECT_NAME=tu_proyecto

# Dentro del shell:
php artisan tinker
```

**Dentro de tinker:**
```php
// Crear role
$role = Kaely\Access\Models\Role::create([
    'name' => 'admin',
    'description' => 'Administrator'
]);
echo "Role created: " . $role->name;

// Crear permission
$permission = Kaely\Access\Models\Permission::create([
    'name' => 'user.create', 
    'description' => 'Create users'
]);
echo "Permission created: " . $permission->name;

// Verificar conteos
echo "Roles: " . Kaely\Access\Models\Role::count();
echo "Permissions: " . Kaely\Access\Models\Permission::count();

// Salir
exit
```

#### **4.3 Verificar comando VitalAccess**
- [ ] Listar comandos disponibles
- [ ] Probar comando de seeding

```bash
# Ver comandos VitalAccess
make artisan PROJECT_NAME=tu_proyecto cmd="list vitalaccess"

# Intentar seeding (puede fallar, es normal)
make artisan PROJECT_NAME=tu_proyecto cmd="vitalaccess:seed"
```

### **📱 5. Acceso a la Aplicación**
- [ ] Verificar Laravel funciona
- [ ] Acceder a phpMyAdmin (si MySQL)
- [ ] Verificar tablas en BD

```bash
# Verificar estado
make status PROJECT_NAME=tu_proyecto

# Acceder a Laravel
curl -I http://localhost:PUERTO

# Verificar tablas en BD
make db-cli PROJECT_NAME=tu_proyecto
# SHOW TABLES LIKE 'access_%';
```

---

## 🚨 Problemas Comunes y Soluciones

### **❌ Error: "Host key verification failed"**
**Causa:** Repositorio Git remoto requiere autenticación SSH

**Solución:**
```bash
# Usar copia local sin Git
rm -rf packages/vitalaccess/.git
```

### **❌ Error: "Path repository does not exist"**
**Causa:** Docker no puede acceder a rutas del host

**Solución:**
```bash
# Copiar dentro del proyecto
cp -r packages/vitalaccess tu_proyecto/packages/vitalaccess
```

### **❌ Error: "Syntax error, unexpected string content"**
**Causa:** Línea extra `}';` en PostInstallCommand.php

**Solución:**
```bash
sed -i "/}\';$/d" tu_proyecto/packages/vitalaccess/src/Console/Commands/PostInstallCommand.php
```

### **❌ Error: "Table already exists"**
**Causa:** Migración ejecutada parcialmente

**Solución:**
```bash
# Continuar sin migraciones
make artisan PROJECT_NAME=tu_proyecto cmd="vitalaccess:seed"
```

### **❌ Error: "MySQL identifier name too long"**
**Causa:** Nombre de índice supera límite de MySQL

**Solución:**
```bash
# Ignorar - no es crítico
# El sistema funciona sin ese índice específico
```

---

## 🎯 Resultado Esperado

Al completar todos los pasos deberías tener:

✅ **Paquete VitalAccess instalado** (`kaely/vitalaccess`)
✅ **Configuración publicada** (`config/access.php`)
✅ **Migraciones ejecutadas** (tablas access_*)
✅ **Modelos disponibles** (Role, Permission, Module)
✅ **Comandos VitalAccess** funcionando
✅ **Laravel funcionando** sin errores
✅ **Base de datos** con tablas RBAC

### **🧪 Test Final:**
```bash
# Verificar que todo funciona
make artisan PROJECT_NAME=tu_proyecto cmd="tinker --execute='
echo \"VitalAccess Test:\";
echo \"- Roles: \" . Kaely\\\\Access\\\\Models\\\\Role::count();
echo \"- Permissions: \" . Kaely\\\\Access\\\\Models\\\\Permission::count();
echo \"- Modules: \" . Kaely\\\\Access\\\\Models\\\\Module::count();
'"
```

---

## 📞 Support

**Si necesitas ayuda:**
1. Verificar logs: `make logs PROJECT_NAME=tu_proyecto`
2. Verificar estado: `make status PROJECT_NAME=tu_proyecto`  
3. Revisar documentación: `tu_proyecto/VITALACCESS_INSTALLATION.md`

**Comandos útiles:**
```bash
# Reinstalar completamente
make clean PROJECT_NAME=tu_proyecto
make setup PROJECT_NAME=tu_proyecto
make install-vitalaccess PROJECT_NAME=tu_proyecto
```

---

## 🚀 Siguiente Paso

Una vez instalado VitalAccess, puedes:
- Crear roles y permisos personalizados
- Integrar con Filament UI
- Configurar middleware de permisos
- Asignar roles a usuarios

**¡VitalAccess RBAC listo para usar!** 🎉