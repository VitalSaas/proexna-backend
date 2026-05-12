# 🚀 **Plan del Paquete VitalCMS v1**

> **Sistema de Gestión de Contenidos (CMS) para Laravel 11/12/13 + Filament 5.x**  
> ✅ **Siguiendo el patrón exitoso de VitalAccess v5**  
> ✅ **Instalación automática** con un solo comando Makefile  
> ✅ **Integración plug-and-play** con Filament 5.x  
> ✅ **Compatible** con Laravel 11, 12 y 13

---

## 📚 **Índice**

1. [Concepto Principal](#-concepto-principal)
2. [Estructura del Paquete](#️-estructura-del-paquete)
3. [Entidades CMS](#️-entidades-cms-principales)
4. [Funcionalidades Clave](#️-funcionalidades-clave)
5. [Comandos Artisan](#️-comandos-artisan)
6. [Integración con Makefile](#-integración-con-makefile)
7. [Proceso de Instalación](#-proceso-de-instalación-automatizado)
8. [Configuración](#-configuración)
9. [Roadmap de Implementación](#-roadmap-de-implementación)

---

## 🎯 **Concepto Principal**

### **VitalCMS v1** - Sistema CMS completo siguiendo exactamente el patrón de vitalaccess-v5:

- **📦 Paquete Composer:** `vitalsaas/vitalcms`
- **🔧 Instalación automática** con `make install-vitalcms PROJECT_NAME=mi-proyecto`
- **🔌 Integración plug-and-play** con Filament 5.x
- **🏗️ Compatible** con Laravel 11/12/13
- **🌐 Gestión completa de contenido** web (posts, páginas, media, menús)
- **🎨 Sistema de Temas Completo** con templates editables y variables configurables
- **📊 Dashboard** con estadísticas y widgets
- **🖥️ Frontend** con rutas públicas automáticas y themes intercambiables

---

## 🏗️ **Estructura del Paquete `packages/vitalcms-v1/`**

```
vitalcms-v1/
├── CHANGELOG.md
├── composer.json                         # vitalsaas/vitalcms
├── CONTRIBUTING.md
├── LICENSE
├── README.md
├── PLUG-AND-PLAY.md
├── phpunit.xml
├── config/
│   └── vitalcms.php                     # Configuración completa CMS
├── database/
│   ├── migrations/                      # 12+ tablas CMS + Themes
│   │   ├── 2026_01_01_100001_create_cms_categories_table.php
│   │   ├── 2026_01_01_100002_create_cms_tags_table.php
│   │   ├── 2026_01_01_100003_create_cms_posts_table.php
│   │   ├── 2026_01_01_100004_create_cms_pages_table.php
│   │   ├── 2026_01_01_100005_create_cms_media_table.php
│   │   ├── 2026_01_01_100006_create_cms_menus_table.php
│   │   ├── 2026_01_01_100007_create_cms_themes_table.php
│   │   ├── 2026_01_01_100008_create_cms_templates_table.php
│   │   ├── 2026_01_01_100009_create_cms_theme_variables_table.php
│   │   ├── 2026_01_01_100010_create_cms_hero_sections_table.php
│   │   ├── 2026_01_01_100011_create_cms_sliders_table.php
│   │   ├── 2026_01_01_100012_create_cms_slider_slides_table.php
│   │   ├── 2026_01_01_100013_create_cms_layout_components_table.php
│   │   ├── 2026_01_01_100014_create_cms_widgets_table.php
│   │   ├── 2026_01_01_100015_create_cms_post_tags_table.php
│   │   ├── 2026_01_01_100016_create_cms_post_categories_table.php
│   │   └── 2026_01_01_100017_create_cms_settings_table.php
│   └── seeders/
│       ├── VitalCMSSeeder.php           # Seeder principal
│       └── VitalCMSContentSeeder.php    # Contenido de ejemplo
├── resources/
│   └── views/
│       ├── themes/                      # 🎨 Sistema de Temas
│       │   ├── default/                # Tema por defecto
│       │   │   ├── layouts/
│       │   │   │   ├── app.blade.php   # Layout principal
│       │   │   │   ├── blog.blade.php  # Layout para blog
│       │   │   │   └── page.blade.php  # Layout para páginas
│       │   │   ├── templates/
│       │   │   │   ├── post.blade.php  # Template de post
│       │   │   │   ├── page.blade.php  # Template de página
│       │   │   │   └── archive.blade.php # Template archivo
│       │   │   ├── partials/
│       │   │   │   ├── header.blade.php
│       │   │   │   ├── footer.blade.php
│       │   │   │   ├── sidebar.blade.php
│       │   │   │   └── navigation.blade.php
│       │   │   ├── components/         # Components reutilizables
│       │   │   │   ├── post-card.blade.php
│       │   │   │   ├── page-hero.blade.php
│       │   │   │   ├── category-badge.blade.php
│       │   │   │   ├── hero-section.blade.php    # 🎯 Hero sections
│       │   │   │   ├── slider.blade.php          # 🖼️ Slider component
│       │   │   │   ├── header-nav.blade.php      # 🧭 Header navigation
│       │   │   │   ├── footer-main.blade.php     # 🦶 Footer component
│       │   │   │   ├── widget-text.blade.php     # 🧩 Text widget
│       │   │   │   ├── widget-contact.blade.php  # 📞 Contact widget
│       │   │   │   ├── widget-social.blade.php   # 📱 Social widget
│       │   │   │   └── widget-newsletter.blade.php # 📧 Newsletter widget
│       │   │   └── assets/
│       │   │       ├── css/theme.css
│       │   │       ├── js/theme.js
│       │   │       └── images/
│       │   └── corporate/              # Ejemplo tema adicional
│       │       └── [misma estructura]
│       ├── frontend/                    # Legacy support
│       │   ├── blog/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── pages/
│       │   │   └── show.blade.php
│       │   └── layouts/
│       │       └── app.blade.php
│       └── admin/                       # Vistas admin especializadas
│           ├── theme-preview.blade.php # Preview de temas
│           └── template-editor.blade.php # Editor de templates
├── routes/
│   ├── web.php                         # Rutas públicas CMS
│   └── api.php                         # API endpoints CMS
├── src/
│   ├── Commands/                       # Comandos Artisan automáticos
│   │   ├── InstallVitalCMSCommand.php
│   │   ├── ConfigurePanelCommand.php
│   │   ├── PublishResourcesCommand.php
│   │   └── VitalCMSMaintenanceCommand.php
│   ├── Models/                         # Modelos Eloquent CMS + Themes + Components
│   │   ├── CmsCategory.php
│   │   ├── CmsTag.php
│   │   ├── CmsPost.php
│   │   ├── CmsPage.php
│   │   ├── CmsMedia.php
│   │   ├── CmsMenu.php
│   │   ├── CmsTheme.php               # 🎨 Sistema de Temas
│   │   ├── CmsTemplate.php            # 📄 Templates editables
│   │   ├── CmsThemeVariable.php       # 🧩 Variables de tema
│   │   ├── CmsHeroSection.php         # 🎯 Hero sections
│   │   ├── CmsSlider.php              # 🖼️ Sliders
│   │   ├── CmsSliderSlide.php         # 🖼️ Slides individuales
│   │   ├── CmsLayoutComponent.php     # 🧭 Header/Footer builder
│   │   ├── CmsWidget.php              # 🧩 Widgets/Components
│   │   └── CmsSettings.php
│   ├── Filament/
│   │   ├── Resources/                  # Recursos Filament + Themes
│   │   │   ├── CmsCategoryResource/
│   │   │   │   ├── CmsCategoryResource.php
│   │   │   │   └── Pages/
│   │   │   ├── CmsPostResource/
│   │   │   │   ├── CmsPostResource.php
│   │   │   │   └── Pages/
│   │   │   ├── CmsPageResource/
│   │   │   │   ├── CmsPageResource.php
│   │   │   │   └── Pages/
│   │   │   ├── CmsMediaResource/
│   │   │   │   ├── CmsMediaResource.php
│   │   │   │   └── Pages/
│   │   │   ├── CmsMenuResource/
│   │   │   │   ├── CmsMenuResource.php
│   │   │   │   └── Pages/
│   │   │   ├── CmsThemeResource/       # 🎨 Gestión de Temas
│   │   │   │   ├── CmsThemeResource.php
│   │   │   │   └── Pages/
│   │   │   │       ├── ListThemes.php
│   │   │   │       ├── CreateTheme.php
│   │   │   │       ├── EditTheme.php
│   │   │   │       └── ThemePreview.php
│   │   │   ├── CmsTemplateResource/    # 📄 Editor de Templates
│   │   │   │   ├── CmsTemplateResource.php
│   │   │   │   └── Pages/
│   │   │   │       ├── ListTemplates.php
│   │   │   │       ├── CreateTemplate.php
│   │   │   │       ├── EditTemplate.php
│   │   │   │       └── TemplateEditor.php
│   │   │   ├── CmsHeroSectionResource/ # 🎯 Hero Sections
│   │   │   │   ├── CmsHeroSectionResource.php
│   │   │   │   └── Pages/
│   │   │   ├── CmsSliderResource/      # 🖼️ Gestión de Sliders
│   │   │   │   ├── CmsSliderResource.php
│   │   │   │   └── Pages/
│   │   │   │       ├── ListSliders.php
│   │   │   │       ├── CreateSlider.php
│   │   │   │       ├── EditSlider.php
│   │   │   │       └── SliderBuilder.php
│   │   │   ├── CmsLayoutComponentResource/ # 🧭 Header/Footer Builder
│   │   │   │   ├── CmsLayoutComponentResource.php
│   │   │   │   └── Pages/
│   │   │   │       ├── ListComponents.php
│   │   │   │       ├── CreateComponent.php
│   │   │   │       ├── EditComponent.php
│   │   │   │       └── ComponentBuilder.php
│   │   │   └── CmsWidgetResource/      # 🧩 Widgets/Components
│   │   │       ├── CmsWidgetResource.php
│   │   │       └── Pages/
│   │   │           ├── ListWidgets.php
│   │   │           ├── CreateWidget.php
│   │   │           └── EditWidget.php
│   │   ├── Widgets/                    # Widgets dashboard
│   │   │   ├── CMSStatsWidget.php
│   │   │   ├── RecentPostsWidget.php
│   │   │   └── ContentOverviewWidget.php
│   │   └── Pages/                      # Páginas especiales
│   │       └── Dashboard.php
│   ├── Http/
│   │   ├── Controllers/               # Controladores frontend
│   │   │   ├── BlogController.php
│   │   │   └── PageController.php
│   │   └── Middleware/
│   │       └── VitalCMSMiddleware.php
│   ├── Traits/
│   │   └── HasVitalCMS.php            # Trait para User model
│   ├── VitalCMSServiceProvider.php    # Service Provider principal
│   └── VitalCMSPanelProvider.php      # Panel Provider Filament
├── stubs/                             # Templates para comandos
└── tests/
    ├── VitalCMSTest.php
    └── Feature/
        ├── CmsPostTest.php
        └── CmsPageTest.php
```

---

## 🗃️ **Entidades CMS Principales**

### **📝 Posts (cms_posts)**
```php
Schema::create('cms_posts', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('excerpt')->nullable();
    $table->longText('content');
    $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
    $table->string('featured_image')->nullable();
    $table->json('meta_data')->nullable(); // SEO meta
    $table->foreignId('author_id')->constrained('users');
    $table->timestamp('published_at')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

**Funcionalidades:**
- ✅ Editor WYSIWYG integrado
- ✅ Estados: draft, published, archived
- ✅ Imagen destacada con upload
- ✅ SEO meta (title, description, keywords)
- ✅ Categorías y tags (many-to-many)
- ✅ Autor y fechas de publicación
- ✅ Soft deletes

### **📄 Pages (cms_pages)**
```php
Schema::create('cms_pages', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->longText('content');
    $table->enum('status', ['draft', 'published'])->default('draft');
    $table->string('template')->default('default');
    $table->foreignId('parent_id')->nullable()->constrained('cms_pages');
    $table->integer('sort_order')->default(0);
    $table->json('meta_data')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

**Funcionalidades:**
- ✅ Páginas estáticas jerárquicas
- ✅ Templates personalizables
- ✅ Ordenamiento manual
- ✅ Estructura de árbol (parent/child)
- ✅ SEO meta integrado

### **🏷️ Categories (cms_categories)**
```php
Schema::create('cms_categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('color')->default('#3B82F6');
    $table->string('icon')->nullable();
    $table->foreignId('parent_id')->nullable()->constrained('cms_categories');
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});
```

**Funcionalidades:**
- ✅ Categorías jerárquicas
- ✅ Colores e iconos personalizables
- ✅ Descripción y SEO
- ✅ Ordenamiento manual

### **🏷️ Tags (cms_tags)**
```php
Schema::create('cms_tags', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->string('color')->default('#10B981');
    $table->timestamps();
});
```

### **🎨 Themes (cms_themes) - NUEVO SISTEMA COMPLETO**
```php
Schema::create('cms_themes', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('version')->default('1.0.0');
    $table->string('author')->nullable();
    $table->string('preview_image')->nullable();
    $table->json('config')->nullable(); // Variables y configuraciones
    $table->json('layouts')->nullable(); // Layouts disponibles
    $table->json('assets')->nullable(); // CSS/JS específicos
    $table->boolean('is_active')->default(false);
    $table->boolean('is_default')->default(false);
    $table->timestamps();
});
```

**Funcionalidades del Sistema de Temas:**
- ✅ **Cambio de tema** desde panel admin en tiempo real
- ✅ **Variables configurables** (colores, fuentes, spacing)
- ✅ **Multiple layouts** por tema (blog, landing, ecommerce)
- ✅ **Preview en vivo** antes de activar
- ✅ **Import/Export** de temas completos
- ✅ **Assets automáticos** (CSS/JS) por tema
- ✅ **Responsive design** automático

### **📄 Templates (cms_templates) - EDITOR AVANZADO**
```php
Schema::create('cms_templates', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->enum('type', ['layout', 'partial', 'component', 'page']); 
    $table->foreignId('theme_id')->constrained('cms_themes');
    $table->longText('content'); // Código Blade editable
    $table->json('variables')->nullable(); // Variables dinámicas
    $table->json('sections')->nullable(); // Secciones editables
    $table->json('blocks')->nullable(); // Bloques de contenido
    $table->string('parent_template')->nullable(); // Herencia
    $table->boolean('is_active')->default(true);
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});
```

**Funcionalidades del Sistema de Templates:**
- ✅ **Editor Blade** con syntax highlighting desde admin
- ✅ **Herencia de templates** (@extends, @include, @section)
- ✅ **Variables dinámicas** configurables por template
- ✅ **Bloques de contenido** reutilizables
- ✅ **Preview en tiempo real** con datos ejemplo
- ✅ **Partial templates** para header, footer, sidebar
- ✅ **Components** reutilizables (botones, cards, etc.)

### **🧩 Theme Variables (cms_theme_variables)**
```php
Schema::create('cms_theme_variables', function (Blueprint $table) {
    $table->id();
    $table->foreignId('theme_id')->constrained('cms_themes');
    $table->string('name'); // primary_color, font_family, etc.
    $table->string('type'); // color, font, number, text
    $table->text('value'); // Valor actual
    $table->text('default_value'); // Valor por defecto
    $table->text('description')->nullable();
    $table->json('options')->nullable(); // Opciones para select/radio
    $table->timestamps();
});
```

### **🎯 Hero Sections (cms_hero_sections) - NUEVO COMPONENTE**
```php
Schema::create('cms_hero_sections', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('subtitle')->nullable();
    $table->longText('description')->nullable();
    $table->string('background_image')->nullable();
    $table->string('background_video')->nullable();
    $table->enum('background_type', ['image', 'video', 'gradient', 'color'])->default('image');
    $table->json('background_settings')->nullable(); // Overlay, position, etc.
    $table->json('buttons')->nullable(); // CTAs configurables
    $table->enum('layout', ['centered', 'left', 'right', 'split'])->default('centered');
    $table->integer('height')->default(500); // Altura en px
    $table->boolean('is_active')->default(true);
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});
```

### **🖼️ Sliders (cms_sliders) - SISTEMA COMPLETO DE SLIDERS**
```php
Schema::create('cms_sliders', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->enum('type', ['hero', 'gallery', 'testimonials', 'products'])->default('hero');
    $table->json('settings')->nullable(); // Auto-play, transition, etc.
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

Schema::create('cms_slider_slides', function (Blueprint $table) {
    $table->id();
    $table->foreignId('slider_id')->constrained('cms_sliders')->onDelete('cascade');
    $table->string('title')->nullable();
    $table->text('content')->nullable();
    $table->string('image')->nullable();
    $table->string('link_url')->nullable();
    $table->string('link_text')->nullable();
    $table->json('settings')->nullable(); // Posición texto, overlay, etc.
    $table->boolean('is_active')->default(true);
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});
```

### **🧭 Header/Footer Builder (cms_layout_components)**
```php
Schema::create('cms_layout_components', function (Blueprint $table) {
    $table->id();
    $table->enum('type', ['header', 'footer', 'sidebar', 'widget']); 
    $table->string('name');
    $table->string('slug')->unique();
    $table->json('structure')->nullable(); // Layout builder data
    $table->json('settings')->nullable(); // Colores, fonts, etc.
    $table->longText('custom_html')->nullable(); // HTML personalizado
    $table->longText('custom_css')->nullable(); // CSS personalizado
    $table->boolean('is_active')->default(true);
    $table->foreignId('theme_id')->nullable()->constrained('cms_themes');
    $table->timestamps();
});
```

### **🧩 Widgets/Components (cms_widgets)**
```php
Schema::create('cms_widgets', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->enum('type', ['text', 'image', 'video', 'contact_form', 'social', 'newsletter', 'custom']);
    $table->longText('content')->nullable();
    $table->json('settings')->nullable(); // Configuraciones específicas
    $table->string('template')->nullable(); // Template personalizado
    $table->boolean('is_active')->default(true);
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});
```

**🎨 Componentes Visuales Configurables:**
- 🎯 **Hero Sections:** Banners principales con CTAs
- 🖼️ **Sliders:** Carousels con múltiples slides
- 🧭 **Headers:** Navigation builder visual
- 🦶 **Footers:** Footer builder con widgets
- 🧩 **Widgets:** Componentes reutilizables
- 📱 **Responsive:** Auto-adaptable a móviles

### **🖼️ Media (cms_media)**
```php
Schema::create('cms_media', function (Blueprint $table) {
    $table->id();
    $table->string('filename');
    $table->string('original_name');
    $table->string('path');
    $table->string('disk')->default('public');
    $table->string('mime_type');
    $table->unsignedBigInteger('size');
    $table->string('alt_text')->nullable();
    $table->text('description')->nullable();
    $table->foreignId('uploaded_by')->constrained('users');
    $table->timestamps();
});
```

**Funcionalidades:**
- ✅ Upload múltiple con drag & drop
- ✅ Gestión de tipos de archivo
- ✅ Alt text y descripción
- ✅ Redimensionamiento automático de imágenes
- ✅ Storage configurable (local/S3/etc.)

### **🧭 Menus (cms_menus)**
```php
Schema::create('cms_menus', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('location'); // header, footer, sidebar
    $table->json('items'); // Estructura del menú
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

**Funcionalidades:**
- ✅ Constructor visual de menús
- ✅ Enlaces internos (posts/pages) y externos
- ✅ Estructura jerárquica
- ✅ Múltiples ubicaciones (header, footer, etc.)

---

## ⚙️ **Funcionalidades Clave**

### **🔧 Instalación Automática**
```bash
# Comando principal (igual que vitalaccess)
make install-vitalcms PROJECT_NAME=mi-proyecto

# Proceso automático:
# 1. Copia paquete al contenedor
# 2. Configura repositorio Composer
# 3. Instala Filament 5.x + VitalCMS
# 4. Publica migraciones y ejecuta
# 5. Configura AdminPanelProvider automáticamente
# 6. Ejecuta seeders con contenido ejemplo
# 7. Registra rutas públicas
```

### **🎛️ Panel Filament Integrado + Sistema de Temas**
```php
// En AdminPanelProvider automáticamente:
->navigationGroup('VitalCMS')
->resources([
    // Contenido
    CmsPostResource::class,
    CmsPageResource::class, 
    CmsCategoryResource::class,
    CmsTagResource::class,
    CmsMediaResource::class,
    CmsMenuResource::class,
    
    // 🎨 NUEVO: Sistema de Temas
    CmsThemeResource::class,
    CmsTemplateResource::class,
])
->widgets([
    CMSStatsWidget::class,
    RecentPostsWidget::class,
    ThemePreviewWidget::class, // 🎨 NUEVO
])
```

**Panel de navegación ACTUALIZADO:**
```
📊 Dashboard
├── VitalCMS - Contenido
│   ├── 📝 Posts
│   ├── 📄 Pages  
│   ├── 🏷️ Categories
│   ├── 🏷️ Tags
│   ├── 🖼️ Media Library
│   └── 🧭 Menus
├── VitalCMS - Diseño    🎨 NUEVA SECCIÓN
│   ├── 🎨 Themes (Gestionar temas)
│   ├── 📄 Templates (Editor de templates)
│   └── 🧩 Theme Variables (Configuración)
├── VitalCMS - Componentes 🧩 NUEVA SECCIÓN
│   ├── 🎯 Hero Sections (Banners principales)
│   ├── 🖼️ Sliders (Carousels/Galerías)
│   ├── 🧭 Header Builder (Constructor navegación)
│   ├── 🦶 Footer Builder (Constructor pie de página)
│   └── 🧩 Widgets (Componentes reutilizables)
└── VitalCMS - Configuración
    └── ⚙️ Settings
```

**🎨 Funcionalidades del Panel de Diseño:**
- **Theme Manager:** Activar/desactivar temas, preview en vivo
- **Template Editor:** Editor Blade con syntax highlighting
- **Variable Configurator:** Personalizar colores, fuentes, spacing
- **Theme Import/Export:** Compartir temas completos
- **Live Preview:** Ver cambios en tiempo real

**🧩 Funcionalidades del Panel de Componentes:**
- **Hero Builder:** Crear banners principales con CTAs configurables
- **Slider Manager:** Carousels con múltiples slides y transiciones
- **Header Builder:** Constructor visual de navegación drag-and-drop
- **Footer Builder:** Pie de página con widgets y enlaces
- **Widget Library:** Biblioteca de componentes reutilizables
- **Component Preview:** Vista previa en tiempo real de componentes

### **🌐 Frontend Public Routes**
```php
// routes/web.php automático
Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
    Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('blog.tag');
});

Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
```

**URLs disponibles:**
- `/blog` - Lista de posts publicados
- `/blog/{slug}` - Post individual
- `/blog/category/{slug}` - Posts por categoría  
- `/blog/tag/{slug}` - Posts por tag
- `/{slug}` - Página estática

### **📊 Widgets Dashboard**
```php
CMSStatsWidget::class:
- 📝 Posts: 45 (32 published, 13 draft)
- 📄 Pages: 12 (10 published, 2 draft)  
- 🏷️ Categories: 8 active
- 🖼️ Media: 156 files (245 MB)
- 👀 Views: 1,234 this month

RecentPostsWidget::class:
- Lista de últimos 5 posts publicados
- Enlaces directos a edición
- Estado y fecha de publicación
```

---

## 🛠️ **Comandos Artisan**

### **Instalación y Configuración**
```bash
# Instalación completa automática
php artisan vitalcms:install

# Configurar AdminPanelProvider automáticamente  
php artisan vitalcms:configure-panel

# Publicar recursos Filament
php artisan vitalcms:publish-resources

# Mantenimiento y caché
php artisan vitalcms:maintenance
```

### **Gestión de Contenido**
```bash
# Limpiar caché CMS
php artisan vitalcms:cache:clear

# Regenerar slugs
php artisan vitalcms:regenerate-slugs

# Optimizar imágenes
php artisan vitalcms:optimize-images
```

### **🎨 Gestión de Temas y Templates - NUEVO**
```bash
# Instalar tema desde archivo/URL
php artisan vitalcms:theme:install {path/url}

# Activar tema específico
php artisan vitalcms:theme:activate {theme-slug}

# Exportar tema completo
php artisan vitalcms:theme:export {theme-slug} --path=/themes/

# Crear nuevo tema base
php artisan vitalcms:theme:create {theme-name}

# Compilar assets de tema
php artisan vitalcms:theme:build {theme-slug}

# Generar template desde stub
php artisan vitalcms:template:make {template-name} --type=layout

# Limpiar caché de templates
php artisan vitalcms:template:cache:clear

# Validar sintaxis de templates
php artisan vitalcms:template:validate
```

### **🧩 Gestión de Componentes Visuales - NUEVO**
```bash
# Crear hero section desde CLI
php artisan vitalcms:hero:create {name} --template=centered

# Generar slider con slides de ejemplo
php artisan vitalcms:slider:create {name} --type=hero --slides=5

# Crear header/footer desde template
php artisan vitalcms:layout:create header {theme-slug} --template=nav-simple
php artisan vitalcms:layout:create footer {theme-slug} --template=footer-links

# Instalar widget pack
php artisan vitalcms:widgets:install {pack-name}

# Exportar componentes
php artisan vitalcms:components:export --type=all --theme={theme-slug}

# Generar CSS de componentes
php artisan vitalcms:components:build-css
```

---

## 🚀 **Integración con Makefile**

### **Nuevo Target en Makefile**
```makefile
install-vitalcms: check-project ## Instalar VitalCMS automáticamente
	@echo "$(BLUE)Instalando VitalCMS en $(PROJECT_NAME)...$(NC)"
	@./install-vitalcms.sh $(PROJECT_NAME)
	
install-package-cms: check-project ## Instalar paquete CMS personalizado
	@if [ -z "$(PACKAGE)" ]; then \
		echo "$(RED)Error: PACKAGE requerido$(NC)"; \
		echo "Uso: make install-package-cms PROJECT_NAME=... PACKAGE=vitalsaas/vitalcms"; \
		exit 1; \
	fi
	@echo "$(BLUE)Instalando $(PACKAGE) en $(PROJECT_NAME)...$(NC)"
	$(APP) composer require $(PACKAGE)
	$(APP) php artisan vitalcms:install
	@echo "$(GREEN)✓ $(PACKAGE) instalado exitosamente$(NC)"
```

### **Script de Instalación `install-vitalcms.sh`**
```bash
#!/bin/bash
# 🚀 VitalCMS v1 Package Installer for Laravel 11/12/13 + Filament 5.x

PROJECT_NAME="$1"
PACKAGE_NAME="VitalCMS v1"
COMPOSER_NAME="vitalsaas/vitalcms"
REPO_PATH="$(pwd)/packages/vitalcms-v1"
NAMESPACE="VitalSaaS\\VitalCMS\\"
SERVICE_PROVIDER="VitalSaaS\\VitalCMS\\VitalCMSServiceProvider"

# Proceso igual que vitalaccess:
# 1. Copiar paquete al contenedor
# 2. Configurar repositorio local
# 3. Instalar Filament 5.x + VitalCMS
# 4. Publicar migraciones y ejecutar
# 5. Configurar AdminPanelProvider
# 6. Ejecutar seeders
# 7. Registrar rutas públicas
```

---

## 🎨 **Configuración `config/vitalcms.php`**

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Prefix
    |--------------------------------------------------------------------------
    */
    'table_prefix' => env('VITALCMS_TABLE_PREFIX', 'cms_'),

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'enabled' => env('VITALCMS_CACHE_ENABLED', true),
        'ttl' => env('VITALCMS_CACHE_TTL', 3600),
        'prefix' => 'vitalcms:',
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament Configuration
    |--------------------------------------------------------------------------
    */
    'filament' => [
        'enabled' => true,
        'navigation_group' => 'VitalCMS',
        'navigation_sort' => 200,
        'resources' => [
            'enabled' => true,
            'auto_register' => true,
        ],
        'widgets' => [
            'enabled' => true,
            'dashboard_stats' => true,
        ],
        'editor' => [
            'type' => 'rich_text', // rich_text, markdown
            'toolbar' => 'full', // minimal, basic, full
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Frontend Configuration
    |--------------------------------------------------------------------------
    */
    'frontend' => [
        'routes_enabled' => true,
        'blog_prefix' => env('VITALCMS_BLOG_PREFIX', 'blog'),
        'page_prefix' => env('VITALCMS_PAGE_PREFIX', ''),
        'posts_per_page' => 10,
        'theme' => 'default',
    ],

    /*
    |--------------------------------------------------------------------------
    | Media Configuration
    |--------------------------------------------------------------------------
    */
    'media' => [
        'driver' => env('VITALCMS_MEDIA_DRIVER', 'public'),
        'max_file_size' => env('VITALCMS_MAX_FILE_SIZE', '10MB'),
        'allowed_types' => [
            'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
            'videos' => ['mp4', 'avi', 'mov'],
        ],
        'image_optimization' => [
            'enabled' => true,
            'quality' => 85,
            'thumbnails' => [
                'small' => [150, 150],
                'medium' => [300, 300],
                'large' => [600, 600],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Configuration
    |--------------------------------------------------------------------------
    */
    'seo' => [
        'enabled' => true,
        'auto_sitemap' => true,
        'meta_fields' => ['title', 'description', 'keywords'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Configuration
    |--------------------------------------------------------------------------
    */
    'content' => [
        'auto_slug' => true,
        'slug_separator' => '-',
        'excerpt_length' => 160,
        'enable_comments' => false,
        'enable_tags' => true,
        'enable_categories' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | 🎨 Theme System Configuration - NUEVO SISTEMA COMPLETO
    |--------------------------------------------------------------------------
    */
    'themes' => [
        'enabled' => true,
        'default_theme' => env('VITALCMS_DEFAULT_THEME', 'default'),
        'allow_theme_switching' => true,
        'cache_compiled_themes' => true,
        'themes_path' => resource_path('views/themes'),
        'assets_path' => public_path('themes'),
        'template_inheritance' => true,
        'live_preview' => true,
        'auto_discovery' => true, // Auto-detectar temas nuevos
    ],

    /*
    |--------------------------------------------------------------------------
    | Template Engine Configuration
    |--------------------------------------------------------------------------
    */
    'templates' => [
        'enabled' => true,
        'cache_templates' => true,
        'allow_blade_editing' => true,
        'syntax_highlighting' => true,
        'auto_backup' => true, // Backup automático antes de editar
        'allowed_functions' => [
            'asset', 'url', 'route', 'config', 'trans', 'auth'
        ],
        'restricted_functions' => [
            'exec', 'shell_exec', 'system', 'file_get_contents'
        ],
        'editor' => [
            'theme' => 'monokai', // Tema del editor de código
            'font_size' => 14,
            'line_numbers' => true,
            'word_wrap' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Variables Configuration
    |--------------------------------------------------------------------------
    */
    'theme_variables' => [
        'enabled' => true,
        'cache_variables' => true,
        'compile_css' => true, // Auto-generar CSS desde variables
        'default_variables' => [
            'primary_color' => '#3B82F6',
            'secondary_color' => '#10B981',
            'font_family' => 'Inter, sans-serif',
            'font_size_base' => '16px',
            'line_height' => '1.5',
            'container_width' => '1200px',
            'border_radius' => '8px',
            'shadow' => '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Installation Settings
    |--------------------------------------------------------------------------
    */
    'installation' => [
        'create_sample_content' => true,
        'run_seeders' => true,
        'publish_frontend_routes' => true,
    ],
];
```

---

## 📋 **Roadmap de Implementación**

### **Fase 1: Estructura Base** ⏱️ 2-3 horas
- [x] ✅ Crear estructura de directorios
- [ ] 🔄 Configurar composer.json
- [ ] 🔄 Implementar VitalCMSServiceProvider
- [ ] 🔄 Crear archivo de configuración

### **Fase 2: Modelos y Migraciones** ⏱️ 3-4 horas
- [ ] 🔄 Crear migraciones para todas las tablas
- [ ] 🔄 Implementar modelos Eloquent con relaciones
- [ ] 🔄 Agregar traits y helper methods
- [ ] 🔄 Configurar Soft Deletes y timestamps

### **Fase 3: Recursos Filament** ⏱️ 4-5 horas
- [ ] 🔄 Crear recursos para Posts, Pages, Categories
- [ ] 🔄 Implementar formularios con validación
- [ ] 🔄 Configurar tablas con filtros y búsqueda
- [ ] 🔄 Agregar actions personalizadas

### **Fase 4: Comandos Artisan** ⏱️ 2-3 horas  
- [ ] 🔄 InstallVitalCMSCommand
- [ ] 🔄 ConfigurePanelCommand
- [ ] 🔄 PublishResourcesCommand
- [ ] 🔄 MaintenanceCommand

### **Fase 5: 🎨 Sistema de Temas y Templates** ⏱️ 6-8 horas
- [ ] 🔄 Crear migraciones para themes, templates, variables
- [ ] 🔄 Implementar modelos CmsTheme, CmsTemplate, CmsThemeVariable
- [ ] 🔄 Crear recursos Filament para gestión de temas
- [ ] 🔄 Implementar editor de templates con syntax highlighting
- [ ] 🔄 Sistema de variables configurables por tema
- [ ] 🔄 Engine de renderizado de templates
- [ ] 🔄 Preview en vivo de temas
- [ ] 🔄 Import/Export de temas completos
- [ ] 🔄 Comandos Artisan para gestión de temas

### **Fase 6: 🧩 Componentes Visuales (Hero, Slider, Header/Footer)** ⏱️ 5-7 horas - NUEVA FASE
- [ ] 🔄 Crear migraciones para hero sections, sliders, layout components
- [ ] 🔄 Implementar modelos CmsHeroSection, CmsSlider, CmsLayoutComponent, CmsWidget
- [ ] 🔄 Crear recursos Filament para gestión de componentes
- [ ] 🔄 Builder visual para headers y footers (drag-and-drop)
- [ ] 🔄 Slider manager con múltiples slides y configuraciones
- [ ] 🔄 Hero section builder con CTAs configurables
- [ ] 🔄 Widget system con componentes reutilizables
- [ ] 🔄 Preview en tiempo real de componentes
- [ ] 🔄 Comandos Artisan para gestión de componentes

### **Fase 7: Frontend & Rutas** ⏱️ 5-6 horas
- [ ] 🔄 Crear controladores frontend con soporte de temas y componentes
- [ ] 🔄 Implementar vistas Blade base (tema default con componentes)
- [ ] 🔄 Sistema de resolución de templates dinámico
- [ ] 🔄 Integración de hero sections y sliders en frontend
- [ ] 🔄 Renderizado dinámico de headers/footers
- [ ] 🔄 Configurar rutas públicas
- [ ] 🔄 Agregar SEO meta tags
- [ ] 🔄 Integrar theme assets (CSS/JS) automático

### **Fase 8: Integración & Testing** ⏱️ 4-5 horas
- [ ] 🔄 Crear script install-vitalcms.sh
- [ ] 🔄 Agregar target al Makefile
- [ ] 🔄 Crear seeders con contenido ejemplo + temas + componentes
- [ ] 🔄 Testing de funcionalidades básicas
- [ ] 🔄 Testing de sistema de temas
- [ ] 🔄 Testing de componentes visuales (hero, slider, etc.)
- [ ] 🔄 Validación de templates y componentes

### **Fase 9: Documentación** ⏱️ 3-4 horas
- [ ] 🔄 README.md completo
- [ ] 🔄 PLUG-AND-PLAY.md
- [ ] 🔄 Documentación de sistema de temas
- [ ] 🔄 Guía de creación de themes
- [ ] 🔄 Documentación de componentes visuales
- [ ] 🔄 Guía de builders (Hero, Slider, Header/Footer)
- [ ] 🔄 Ejemplos de templates y componentes
- [ ] 🔄 Guía de instalación y configuración

---

## 🎯 **Resultado Final Esperado**

### **Instalación en 1 comando:**
```bash
make install-vitalcms PROJECT_NAME=mi-blog
```

### **Panel Filament completamente funcional:**
- ✅ Gestión completa de posts con editor WYSIWYG
- ✅ Páginas estáticas jerárquicas  
- ✅ Categorías y tags con colores
- ✅ Media library con upload múltiple
- ✅ Constructor de menús visual
- ✅ Dashboard con estadísticas

### **Frontend automático:**
- ✅ Blog público en `/blog`
- ✅ Páginas estáticas en `/{slug}`
- ✅ SEO optimizado automáticamente
- ✅ Responsive design

### **Compatible 100% con:**
- ✅ Laravel 11, 12, 13
- ✅ Filament 5.x
- ✅ PHP 8.3+
- ✅ MySQL 8.0+ / PostgreSQL 13+

---

**🎉 ¿Listo para implementar VitalCMS v1 siguiendo este plan?**