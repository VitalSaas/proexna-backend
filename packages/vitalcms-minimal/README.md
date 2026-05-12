# 🚀 VitalCMS Minimal v1

> Sistema de gestión de contenido minimalista para Laravel + Filament

## ✨ Características

- 🎯 **Hero Sections**: Gestión de banners y sliders principales
- 🛠️ **Servicios**: Catálogo de servicios con precios y descripciones  
- 📞 **Formulario de Contacto**: Sistema completo con notificaciones
- 🔗 **API REST**: Endpoints para integración frontend (Next.js, Vue, React)
- 🎛️ **Panel Filament**: Interface de administración completa
- ⚡ **Instalación rápida**: Un solo comando

## 🔧 Requisitos

- PHP 8.2+
- Laravel 11+
- Filament 4+/5+

## 📦 Instalación

### 1. Instalar el paquete

```bash
composer require vitalsaas/vitalcms-minimal
```

### 2. Ejecutar instalación automática

```bash
php artisan vitalcms:install --seed
```

### 3. Configurar AdminPanelProvider

Agregar a tu `AdminPanelProvider`:

```php
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsHeroSectionResource;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsServiceResource;
use VitalSaaS\VitalCMSMinimal\Filament\Resources\CmsContactSubmissionResource;

public function panel(Panel $panel): Panel
{
    return $panel
        // ... tu configuración
        ->resources([
            CmsHeroSectionResource::class,
            CmsServiceResource::class,
            CmsContactSubmissionResource::class,
        ]);
}
```

## 🌐 API Endpoints

### Hero Sections
- `GET /api/cms/hero-sections` - Lista todos los hero sections
- `GET /api/cms/hero-sections/{id}` - Hero section específico

### Servicios  
- `GET /api/cms/services` - Lista todos los servicios
- `GET /api/cms/services/{id}` - Servicio específico

### Contacto
- `POST /api/cms/contact` - Enviar formulario de contacto

## 🎨 Uso con Frontend

### Next.js Example

```typescript
// Hero Sections
const heroSections = await fetch('/api/cms/hero-sections')
  .then(res => res.json());

// Servicios
const services = await fetch('/api/cms/services')
  .then(res => res.json());

// Contacto
const sendContact = async (data) => {
  await fetch('/api/cms/contact', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  });
};
```

## ⚙️ Configuración

Publica y edita el archivo de configuración:

```bash
php artisan vendor:publish --tag=vitalcms-config
```

## 📚 Documentación

- [Guía de Instalación](docs/installation.md)
- [API Reference](docs/api.md)
- [Frontend Integration](docs/frontend.md)

## 🆘 Soporte

- [Issues](https://github.com/vitalsaas/vitalcms-minimal/issues)
- [Discussions](https://github.com/vitalsaas/vitalcms-minimal/discussions)

## 📄 Licencia

MIT License - ver [LICENSE](LICENSE) para detalles.

---

**🎉 Desarrollado por [VitalSaaS](https://vitalsaas.com)**