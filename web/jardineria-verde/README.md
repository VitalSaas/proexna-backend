# 🌱 Jardinería Verde

Sitio web profesional para empresa de jardinería y paisajismo construido con Next.js, TypeScript y Tailwind CSS.

## Características

- ✨ Diseño moderno y responsivo
- 🎨 Personalización completa con Tailwind CSS
- 📱 Optimizado para móviles
- ⚡ Rendimiento optimizado con Next.js 14
- 🔧 TypeScript para mayor robustez
- 🌿 Temática especializada en jardinería

## Estructura del Proyecto

```
jardineria-verde/
├── src/
│   ├── app/
│   │   ├── globals.css
│   │   ├── layout.tsx
│   │   └── page.tsx
│   └── components/
├── public/
├── package.json
├── tailwind.config.js
├── tsconfig.json
└── next.config.js
```

## Instalación y Desarrollo

### 🐳 Con Docker (Recomendado)

La forma más fácil de ejecutar este proyecto es usando Docker. No necesitas tener Node.js instalado en tu sistema.

#### Opción 1: Usando el script de inicio
```bash
# Modo producción
./start.sh prod

# Modo desarrollo (con hot reload)
./start.sh dev

# Ver ayuda
./start.sh help
```

#### Opción 2: Usando Makefile
```bash
# Modo producción
make prod

# Modo desarrollo
make dev

# Ver todos los comandos
make help
```

#### Opción 3: Docker Compose directo
```bash
# Modo producción
docker compose up --build -d jardineria-verde

# Modo desarrollo
docker compose --profile dev up --build -d jardineria-dev
```

**URLs de acceso:**
- Producción: [http://localhost:3000](http://localhost:3000)
- Desarrollo: [http://localhost:3001](http://localhost:3001)

### 📦 Instalación tradicional (requiere Node.js)

Si prefieres ejecutar sin Docker:

```bash
# Instalar dependencias
npm install

# Ejecutar servidor de desarrollo
npm run dev

# Construir para producción
npm run build

# Ejecutar en producción
npm start
```

## 🐳 Comandos Docker útiles

```bash
# Ver logs en tiempo real
make logs

# Detener la aplicación
make stop

# Limpiar contenedores e imágenes
make clean

# Reiniciar la aplicación
make restart

# Ver estado de contenedores
make status
```

## Secciones del Sitio

- **Hero**: Presentación principal con call-to-action
- **Servicios**: Diseño de jardines, mantenimiento y paisajismo
- **Sobre Nosotros**: Historia y estadísticas de la empresa
- **Contacto**: Formulario y datos de contacto

## Personalización

### Colores
Los colores principales están definidos en `tailwind.config.js`:
- Primary: Verde jardín (#22c55e)
- Secondary: Verde oscuro (#16a34a)
- Accent: Verde lima (#84cc16)

### Contenido
Edita los textos y información en `src/app/page.tsx` para personalizar:
- Nombre de la empresa
- Servicios ofrecidos
- Información de contacto
- Estadísticas y logros

## Tecnologías Utilizadas

- [Next.js 14](https://nextjs.org/) - Framework de React
- [TypeScript](https://www.typescriptlang.org/) - Tipado estático
- [Tailwind CSS](https://tailwindcss.com/) - Framework CSS
- [React](https://reactjs.org/) - Biblioteca de UI

## Licencia

Este proyecto es privado y pertenece a Jardinería Verde.