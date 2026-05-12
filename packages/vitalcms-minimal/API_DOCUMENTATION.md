# VitalCMS Minimal - API Documentation

## 🚀 Base URL
```
http://localhost:8000/api/cms
```

## 📋 Available Endpoints

### 🎭 Hero Sections

#### GET `/hero-sections`
Obtiene todas las hero sections activas ordenadas por sort_order.

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Profesionalismo en la Naturaleza",
      "subtitle": "Expertos en Jardinería y Paisajismo",
      "description": "...",
      "image": {
        "url": "http://localhost:8000/storage/hero-sections/hero-example.jpg",
        "position": "left",
        "effects": {"brightness": "1.1", "contrast": "1.2"}
      },
      "gradient": {
        "position": "bottom",
        "css": "linear-gradient(to top, #00000080%, #transparent0%)"
      },
      "content": {
        "position": "top-right",
        "width": 40
      },
      "buttons": [...],
      "cssClasses": ["hero-section", "has-gradient", "image-position-left"],
      "styles": {"height": "600px", "filter": "contrast(1.2) brightness(1.1)"}
    }
  ],
  "meta": {
    "count": 5,
    "cache_ttl": 3600
  }
}
```

#### GET `/hero-sections/{id}`
Obtiene una hero section específica por ID.

---

### 🛠️ Services

#### GET `/services`
Obtiene todos los servicios activos.

**Query Parameters:**
- `featured` (boolean) - Solo servicios destacados
- `category` (string) - Filtrar por categoría
- `per_page` (int) - Paginación

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Diseño de Jardines",
      "short_description": "...",
      "price": "Desde $2,500",
      "formatted_price": "Desde $2,500",
      "price_description": "por proyecto",
      "icon": "🌿",
      "image": "http://localhost:8000/storage/services/diseno-jardines.jpg",
      "category": "diseño",
      "category_name": "Diseño",
      "featured": true
    }
  ],
  "meta": {
    "count": 10
  },
  "filters": {
    "categories": {
      "diseño": "Diseño",
      "mantenimiento": "Mantenimiento",
      "paisajismo": "Paisajismo",
      "instalacion": "Instalación",
      "consulta": "Consulta",
      "especializado": "Especializado"
    }
  }
}
```

#### GET `/services/featured`
Obtiene solo los servicios destacados (máximo 6).

#### GET `/services/category/{category}`
Obtiene servicios por categoría específica.

**Categories:** `diseño`, `mantenimiento`, `paisajismo`, `instalacion`, `consulta`, `especializado`

#### GET `/services/{id}`
Obtiene un servicio específico con descripción completa.

---

### 📞 Contact

#### GET `/contact/config`
Obtiene configuración del formulario de contacto.

**Response:**
```json
{
  "success": true,
  "data": {
    "service_interests": {
      "diseño": "Diseño de jardines",
      "mantenimiento": "Mantenimiento",
      "paisajismo": "Paisajismo",
      "instalacion": "Instalación de sistemas",
      "consulta": "Consultoría",
      "otro": "Otro"
    },
    "validation": {
      "name": ["required", "max:255"],
      "email": ["required", "email", "max:255"],
      "message": ["required", "max:2000"]
    },
    "contact_info": {
      "phone": "+52 951 308 4924",
      "whatsapp": "+52 951 308 4924",
      "email": "admin@example.com",
      "business_name": "PROEXNA - Profesionalismo en la naturaleza"
    }
  }
}
```

#### POST `/contact`
Envía un mensaje de contacto.

**Request Body:**
```json
{
  "name": "Juan Pérez",
  "email": "juan@example.com",
  "phone": "+52 951 123 4567", // opcional
  "subject": "Consulta sobre servicios", // opcional
  "message": "Me interesa el servicio de diseño de jardines",
  "service_interest": "diseño" // opcional
}
```

**Response:**
```json
{
  "success": true,
  "message": "¡Gracias por contactarnos! Te responderemos pronto.",
  "data": {
    "id": 1,
    "reference": "PROEXNA-000001",
    "status": "new"
  }
}
```

**Rate Limiting:** 5 submissions per minute per IP.

---

## 🎨 Frontend Integration Examples

### React/Next.js

```javascript
// Obtener hero sections
const getHeroSections = async () => {
  const response = await fetch('/api/cms/hero-sections');
  const data = await response.json();
  return data.data;
};

// Obtener servicios destacados
const getFeaturedServices = async () => {
  const response = await fetch('/api/cms/services/featured');
  const data = await response.json();
  return data.data;
};

// Enviar formulario de contacto
const submitContact = async (formData) => {
  const response = await fetch('/api/cms/contact', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(formData)
  });
  return response.json();
};
```

### CSS Classes for Hero Sections

Los hero sections incluyen clases CSS automáticas:

```css
.hero-section { /* Base styles */ }
.layout-centered { /* Contenido centrado */ }
.image-position-left { /* Imagen a la izquierda */ }
.content-position-top-right { /* Contenido en esquina superior derecha */ }
.has-gradient { /* Tiene gradiente */ }
.gradient-bottom { /* Gradiente inferior */ }
.has-image { /* Tiene imagen */ }
```

## 🔄 Cache

- **Hero Sections**: Cache de 1 hora
- **Services**: Cache de 1 hora
- **Contact Config**: Sin cache (datos dinámicos)

## 📱 Response Format

Todas las respuestas siguen este formato:

```json
{
  "success": boolean,
  "data": any,
  "meta"?: object,
  "message"?: string,
  "errors"?: object
}
```

## 🛡️ Error Handling

- **200**: Success
- **404**: Resource not found
- **422**: Validation error
- **429**: Rate limit exceeded
- **500**: Server error