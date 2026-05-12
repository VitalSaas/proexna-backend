# Makefile para Jardinería Verde

.PHONY: help prod dev build stop clean logs

# Configuración por defecto
DEFAULT_GOAL := help

help: ## Mostrar esta ayuda
	@echo "🌱 Jardinería Verde - Comandos disponibles:"
	@echo ""
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-12s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)
	@echo ""
	@echo "Ejemplos:"
	@echo "  make prod    # Ejecutar en producción"
	@echo "  make dev     # Ejecutar en desarrollo"
	@echo "  make logs    # Ver logs en tiempo real"

prod: ## Ejecutar en modo producción (puerto 3000)
	@echo "🚀 Iniciando en modo producción..."
	docker compose up --build -d jardineria-verde
	@echo "✅ Aplicación disponible en: http://localhost:3000"

dev: ## Ejecutar en modo desarrollo con hot reload (puerto 3001)
	@echo "🛠️  Iniciando en modo desarrollo..."
	docker compose --profile dev up --build -d jardineria-dev
	@echo "✅ Aplicación disponible en: http://localhost:3001"
	@echo "📝 Hot reload activado para desarrollo"

build: ## Construir la imagen de Docker
	@echo "🔨 Construyendo imagen Docker..."
	docker compose build
	@echo "✅ Imagen construida exitosamente"

stop: ## Detener todos los contenedores
	@echo "🛑 Deteniendo contenedores..."
	docker compose down
	@echo "✅ Contenedores detenidos"

clean: ## Limpiar contenedores e imágenes
	@echo "🧹 Limpiando contenedores e imágenes..."
	docker compose down --rmi all --volumes --remove-orphans
	@echo "✅ Limpieza completada"

logs: ## Ver logs de la aplicación en tiempo real
	@echo "📋 Mostrando logs en tiempo real (Ctrl+C para salir)..."
	docker compose logs -f

restart: stop prod ## Reiniciar la aplicación

status: ## Ver estado de los contenedores
	@echo "📊 Estado de los contenedores:"
	docker compose ps

shell: ## Acceder al shell del contenedor
	@echo "🐚 Accediendo al contenedor..."
	docker compose exec jardineria-verde sh

# Comandos de desarrollo
install: ## Instalar dependencias (desarrollo)
	@echo "📦 Instalando dependencias..."
	docker compose --profile dev run --rm jardineria-dev npm install

test: ## Ejecutar tests
	@echo "🧪 Ejecutando tests..."
	docker compose --profile dev run --rm jardineria-dev npm test

lint: ## Ejecutar linter
	@echo "🔍 Ejecutando linter..."
	docker compose --profile dev run --rm jardineria-dev npm run lint