# 📚 Documentación: Proyecto testproexna

## 🎯 Descripción del Proyecto

Documentación completa paso a paso para crear el proyecto **testproexna** con Laravel 12, MySQL, VitalSaaS RBAC y Filament como panel administrativo usando Docker.

---

## 📋 Prerrequisitos

- **Docker** y **Docker Compose** instalados
- **Make** disponible en el sistema
- Acceso a terminal/bash
- **Git** configurado (opcional)

---

## 🗂️ Estructura del Entorno Base

El entorno base debe contener:
```
/home/kaely/Codigo/Desarrollo/test/
├── Makefile                    # Comandos automatizados
├── docker-compose.mysql.yml   # Configuración Docker MySQL
├── Dockerfile.mysql           # Dockerfile para MySQL
├── .env.example.mysql         # Variables de entorno MySQL
├── .dockerignore              # Archivos a ignorar en Docker
├── install-vitalaccess.sh     # Script de instalación VitalSaaS
├── packages/                  # Directorio de paquetes locales
│   └── vitalaccess-local/     # Paquete VitalSaaS
└── guia-completa-laravel-vitalaccess.md
```

---

## 🧹 Paso 1: Limpieza Inicial

### 1.1 Detener y eliminar contenedores existentes
```bash
cd /home/kaely/Codigo/Desarrollo/test
docker ps -a | grep -E "(testproexna|miproyecto)" | awk '{print $1}' | xargs -r docker stop
docker ps -a | grep -E "(testproexna|miproyecto)" | awk '{print $1}' | xargs -r docker rm
```

### 1.2 Limpiar redes y volúmenes Docker
```bash
docker network prune -f
docker volume prune -f
```

### 1.3 Eliminar directorios de proyectos anteriores
```bash
# Usar Docker para eliminar directorios con permisos de root
docker run --rm -v "$(pwd)":/workspace alpine rm -rf /workspace/miProyecto /workspace/testProexna

# Limpiar imágenes no utilizadas
docker image prune -f
```

### 1.4 Verificar limpieza
```bash
ls -la  # Verificar que no existen directorios de proyectos anteriores
docker ps -a  # Verificar que no hay contenedores
```

---

## 🚀 Paso 2: Creación del Proyecto Laravel

### 2.1 Crear proyecto Laravel 12 con MySQL
```bash
make new-project PROJECT_NAME=testproexna LARAVEL_VERSION=12 DB_TYPE=mysql
```

**Proceso automático que incluye:**
- Creación de proyecto Laravel 12 usando Composer
- Instalación de dependencias PHP
- Configuración de archivos Docker
- Copia de archivos de configuración (.env, docker-compose.yml, Dockerfile)
- Configuración inicial de Laravel (clave de aplicación, migraciones básicas)

### 2.2 Verificar creación del proyecto
```bash
ls -la | grep testproexna  # Verificar que el directorio se creó
```

---

## 🐳 Paso 3: Configuración y Levantamiento de Docker

### 3.1 Configurar y levantar servicios Docker
```bash
make setup PROJECT_NAME=testproexna
```

**Este comando ejecuta:**
- Build de la imagen Docker del proyecto
- Levantamiento de contenedores (app, mysql, phpmyadmin, redis)
- Instalación de dependencias de Composer
- Generación de clave de aplicación Laravel
- Ejecución de migraciones de Laravel

### 3.2 Verificar servicios activos
```bash
cd testproexna
docker compose ps
```

**Servicios esperados:**
- `testproexna-app-1`: Laravel (puerto 8117)
- `testproexna-mysql-1`: MySQL 8.0 (puerto 8118)
- `testproexna-phpmyadmin-1`: phpMyAdmin (puerto 8119)
- `testproexna-redis-1`: Redis (puerto 8121)

---

## 🎨 Paso 4: Instalación de Filament

### 4.1 Instalar Filament via Composer
```bash
docker compose exec app composer require filament/filament
```

### 4.2 Configurar panel administrativo
```bash
docker compose exec app php artisan filament:install --panels
```

**Resultado esperado:**
- Creación de `AdminPanelProvider.php`
- Publicación de assets de Filament
- Configuración de rutas administrativas

### 4.3 Crear usuario administrador
```bash
docker compose exec app php artisan tinker --execute="
\$user = \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@testproexna.com',
    'password' => bcrypt('password123'),
    'email_verified_at' => now(),
]);
echo 'Usuario administrador creado: ' . \$user->email;
"
```

---

## 🔐 Paso 5: Instalación de VitalSaaS RBAC

### 5.1 Crear directorio packages
```bash
docker compose exec app mkdir -p packages
```

### 5.2 Copiar paquete VitalSaaS al proyecto
```bash
docker cp ../packages/vitalaccess-local testproexna-app-1:/app/packages/vitalaccess
```

### 5.3 Configurar composer.json para VitalSaaS

**Crear archivo temporal con configuración:**
```json
{
    "$schema": "https://getcomposer.org/schema.json",
    "name": "laravel/laravel",
    "type": "project",
    "description": "The skeleton application for the Laravel framework.",
    "keywords": ["laravel", "framework"],
    "license": "MIT",
    "require": {
        "php": "^8.2",
        "filament/filament": "^5.6",
        "laravel/framework": "^12.0",
        "laravel/tinker": "^2.10.1",
        "kaely/vitalaccess": "dev-main"
    },
    "repositories": [
        {
            "type": "path",
            "url": "packages/vitalaccess"
        }
    ],
    ...
}
```

### 5.4 Copiar composer.json modificado
```bash
# Crear archivo temporal
cat > /tmp/composer_with_vitalsaas.json << 'EOF'
[contenido del composer.json modificado]
EOF

# Copiar al contenedor
docker cp /tmp/composer_with_vitalsaas.json testproexna-app-1:/app/composer.json
```

### 5.5 Instalar VitalSaaS
```bash
docker compose exec app composer update
```

### 5.6 Ejecutar instalación de VitalSaaS
```bash
# Verificar comandos disponibles
docker compose exec app php artisan list | grep -i vital

# Instalar VitalSaaS (las migraciones ya estarán ejecutadas)
docker compose exec app php artisan vitalaccess:install --seed
```

---

## 🔍 Paso 6: Verificación y Configuración Final

### 6.1 Verificar tablas de VitalSaaS
```bash
docker compose exec mysql mysql -u laravel -plaravel_password laravel -e "SHOW TABLES LIKE 'access%';"
```

**Tablas esperadas:**
- `access_modules`
- `access_permission_modules`
- `access_permissions`
- `access_role_categories`
- `access_role_permissions`
- `access_roles`
- `access_user_business_units`
- `access_user_roles`

### 6.2 Verificar rutas administrativas
```bash
docker compose exec app php artisan route:list | grep admin
```

**Rutas esperadas:**
- `GET admin` → Dashboard
- `GET admin/login` → Login
- `POST admin/logout` → Logout

### 6.3 Verificar usuario administrador
```bash
docker compose exec mysql mysql -u laravel -plaravel_password laravel -e "SELECT id, name, email, created_at FROM users LIMIT 5;"
```

### 6.4 Verificación final de servicios
```bash
docker compose ps
```

**Estado esperado:** Todos los servicios con status "Up" y healthy.

---

## 🌐 URLs de Acceso

| Servicio | URL | Puerto |
|----------|-----|---------|
| **Laravel App** | http://localhost:8117 | 8117 |
| **Panel Admin** | http://localhost:8117/admin | 8117 |
| **Login Admin** | http://localhost:8117/admin/login | 8117 |
| **phpMyAdmin** | http://localhost:8119 | 8119 |
| **MySQL** | localhost:8118 | 8118 |
| **Redis** | localhost:8121 | 8121 |

---

## 🔑 Credenciales

### Panel Administrativo
- **Email:** `admin@testproexna.com`
- **Contraseña:** `password123`

### Base de Datos MySQL
- **Host:** `localhost:8118`
- **Usuario:** `laravel`
- **Contraseña:** `laravel_password`
- **Base de datos:** `laravel`

---

## 🏗️ Arquitectura del Sistema

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Laravel 12    │    │   Filament 5.6  │    │  VitalSaaS RBAC │
│   Framework     │◄──►│ Admin Panel     │◄──►│   Package       │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   MySQL 8.0     │    │   Redis Cache   │    │  FrankenPHP     │
│   Database      │    │   Storage       │    │  Web Server     │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

---

## 🛠️ Comandos Útiles

### Docker Management
```bash
# Ver logs de la aplicación
docker compose logs app

# Acceder al contenedor de la app
docker compose exec app bash

# Reiniciar servicios
docker compose restart

# Detener servicios
docker compose down

# Levantar servicios
docker compose up -d
```

### Laravel Management
```bash
# Limpiar cache
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear

# Ver rutas
docker compose exec app php artisan route:list

# Ejecutar migraciones
docker compose exec app php artisan migrate

# Acceder a Tinker
docker compose exec app php artisan tinker
```

### VitalSaaS Management
```bash
# Ver comandos VitalSaaS
docker compose exec app php artisan list | grep vital

# Reinstalar VitalSaaS
docker compose exec app php artisan vitalaccess:install

# Seed datos VitalSaaS
docker compose exec app php artisan vitalaccess:seed
```

---

## 🚨 Troubleshooting

### Problema: Contenedores no inician
**Solución:**
```bash
# Verificar logs
docker compose logs

# Reconstruir imagen
docker compose build --no-cache
docker compose up -d
```

### Problema: Error de permisos
**Solución:**
```bash
# Ajustar permisos dentro del contenedor
docker compose exec app chown -R www-data:www-data /app/storage
docker compose exec app chmod -R 755 /app/storage
```

### Problema: Base de datos no conecta
**Solución:**
```bash
# Verificar que MySQL esté corriendo
docker compose ps mysql

# Verificar conexión
docker compose exec app php artisan tinker --execute="
DB::connection()->getPdo();
echo 'Conexión exitosa';
"
```

### Problema: Panel admin no carga
**Solución:**
```bash
# Limpiar cache y reconfigurar
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear

# Verificar rutas
docker compose exec app php artisan route:list | grep admin
```

---

## 📁 Estructura Final del Proyecto

```
testproexna/
├── app/
│   └── Providers/
│       └── Filament/
│           └── AdminPanelProvider.php
├── packages/
│   └── vitalaccess/              # Paquete VitalSaaS
├── docker-compose.yml           # Configuración Docker
├── Dockerfile                   # Imagen Docker personalizada
├── .env                        # Variables de entorno
├── composer.json               # Dependencias PHP (incluye VitalSaaS)
└── [archivos estándar de Laravel]
```

---

## ✅ Verificación de Instalación Exitosa

1. ✅ **Laravel 12** funcionando en puerto 8117
2. ✅ **MySQL 8.0** corriendo en puerto 8118
3. ✅ **Filament Admin** accesible en `/admin`
4. ✅ **VitalSaaS RBAC** con 8 tablas instaladas
5. ✅ **Usuario administrador** creado y funcional
6. ✅ **phpMyAdmin** disponible en puerto 8119
7. ✅ **Redis** corriendo en puerto 8121

---

## 📝 Notas Importantes

- **Puertos dinámicos:** El sistema asigna puertos automáticamente basados en el hash del nombre del proyecto
- **Persistencia:** Los datos se mantienen en volúmenes Docker
- **Seguridad:** Cambiar credenciales por defecto en producción
- **Desarrollo:** El entorno está optimizado para desarrollo local

---

## 🎯 Próximos Pasos Sugeridos

1. **Configurar roles y permisos** personalizados en VitalSaaS
2. **Crear recursos Filament** para gestión de entidades
3. **Implementar autenticación** personalizada si es necesaria
4. **Configurar environment** de producción
5. **Añadir tests** para funcionalidades críticas

---

**📅 Documento creado:** $(date)  
**🏷️ Versión:** 1.0  
**👤 Creado por:** Claude Code Assistant  
**🎯 Proyecto:** testproexna - Laravel 12 + VitalSaaS + Filament