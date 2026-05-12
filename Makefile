# Makefile - Generador de proyectos Laravel + FrankenPHP + Postgres + Redis
.DEFAULT_GOAL := help
SHELL := /bin/bash

# Colors for output
RED    := \033[0;31m
GREEN  := \033[0;32m
YELLOW := \033[0;33m
BLUE   := \033[0;34m
NC     := \033[0m # No Color

# Project configuration
PROJECT_NAME ?=
# Normalize project name for Docker Compose (lowercase, alphanumeric + hyphens/underscores)
PROJECT_NORMALIZED := $(shell echo "$(PROJECT_NAME)" | tr '[:upper:]' '[:lower:]' | sed 's/[^a-z0-9_-]//g')

# Dynamic port calculation (based on normalized project name hash)
HASH := $(shell echo $(PROJECT_NORMALIZED) | shasum | cut -c1-3)
BASE_PORT := $(shell echo $$((0x$(HASH) % 900 + 8100)))
MYSQL_PORT := $(shell echo $$(($(BASE_PORT) + 1)))
PHPMYADMIN_PORT := $(shell echo $$(($(BASE_PORT) + 2)))
POSTGRES_PORT := $(shell echo $$(($(BASE_PORT) + 3)))
REDIS_PORT := $(shell echo $$(($(BASE_PORT) + 4)))

# Docker compose commands with project isolation and dynamic ports
DC      := APP_PORT=$(BASE_PORT) MYSQL_PORT=$(MYSQL_PORT) PHPMYADMIN_PORT=$(PHPMYADMIN_PORT) POSTGRES_PORT=$(POSTGRES_PORT) REDIS_PORT=$(REDIS_PORT) \
          docker compose -f $(PROJECT_NAME)/docker-compose.yml -p $(PROJECT_NORMALIZED)
APP     := $(DC) exec app
APP_NOT := $(DC) run --rm app

# Template files in current directory
TEMPLATE_FILES_MYSQL := docker-compose.mysql.yml Dockerfile.mysql .env.example.mysql .dockerignore
TEMPLATE_FILES_POSTGRES := docker-compose.postgresql.yml Dockerfile.postgres .env.example.postgres .dockerignore
DB_TYPE ?= mysql
LARAVEL_VERSION ?=

## ---------- Bootstrap ----------

check-templates: ## Verifica que existan los archivos template
	@if [ "$(DB_TYPE)" = "mysql" ]; then \
		template_files="$(TEMPLATE_FILES_MYSQL)"; \
	else \
		template_files="$(TEMPLATE_FILES_POSTGRES)"; \
	fi; \
	for file in $$template_files; do \
		if [ ! -f "$$file" ]; then \
			echo "$(RED)Error: Archivo template $$file no encontrado$(NC)"; \
			exit 1; \
		fi; \
	done

new-project: check-templates ## Crea un nuevo proyecto Laravel con nombre personalizado
	@if [ -z "$(PROJECT_NAME)" ]; then \
		echo "$(RED)Error: PROJECT_NAME requerido$(NC)"; \
		echo "Uso: make new-project PROJECT_NAME=mi_proyecto [LARAVEL_VERSION=11]"; \
		exit 1; \
	fi
	@if [ -z "$(LARAVEL_VERSION)" ]; then \
		laravel_version="11"; \
	else \
		laravel_version="$(LARAVEL_VERSION)"; \
	fi; \
	if [ -d "$(PROJECT_NAME)" ]; then \
		echo "$(YELLOW)⚠ El directorio $(PROJECT_NAME) ya existe.$(NC)"; \
		read -p "¿Sobrescribir? [y/N]: " confirm; \
		if [ "$$confirm" != "y" ] && [ "$$confirm" != "Y" ]; then \
			echo "$(BLUE)Cancelado.$(NC)"; exit 0; \
		fi; \
		rm -rf "$(PROJECT_NAME)"; \
	fi; \
	if [ "$$laravel_version" = "latest" ]; then \
		laravel_constraint=""; \
		version_display="latest"; \
	else \
		laravel_constraint=":^$$laravel_version.0"; \
		version_display="$$laravel_version"; \
	fi; \
	echo "$(BLUE)Creando proyecto Laravel $$version_display: $(PROJECT_NAME)$(NC)"; \
	docker run --rm -v "$(PWD)":/app -w /app composer:latest create-project laravel/laravel$$laravel_constraint "$(PROJECT_NAME)"
	echo "$(BLUE)Ajustando permisos...$(NC)"; \
	chown -R $$USER:$$USER "$(PROJECT_NAME)" 2>/dev/null || echo "$(YELLOW)Permisos ya correctos$(NC)"; \
	echo "$(BLUE)Copiando archivos de configuración Docker ($(DB_TYPE))...$(NC)"; \
	if [ "$(DB_TYPE)" = "mysql" ]; then \
		template_files="$(TEMPLATE_FILES_MYSQL)"; \
	else \
		template_files="$(TEMPLATE_FILES_POSTGRES)"; \
	fi; \
	for template_file in $$template_files; do \
		target_file=$$(basename $$template_file | sed 's/\.\(mysql\|postgres\|postgresql\)//g'); \
		if docker run --rm -v "$(PWD)":/workspace alpine cp "/workspace/$$template_file" "/workspace/$(PROJECT_NAME)/$$target_file" 2>/dev/null; then \
			echo "  $(GREEN)✓$(NC) $$template_file → $(PROJECT_NAME)/$$target_file"; \
		else \
			echo "  $(RED)✗$(NC) Error copiando $$template_file"; \
			exit 1; \
		fi; \
	done; \
	echo "$(BLUE)Configurando archivo .env...$(NC)"; \
	if [ -f "$(PROJECT_NAME)/.env.example" ]; then \
		if docker run --rm -v "$(PWD)":/workspace alpine cp "/workspace/$(PROJECT_NAME)/.env.example" "/workspace/$(PROJECT_NAME)/.env" 2>/dev/null; then \
			echo "  $(GREEN)✓$(NC) .env creado desde .env.example"; \
		else \
			echo "  $(RED)✗$(NC) Error creando .env"; \
		fi; \
	fi; \
	echo "$(GREEN)✓ Proyecto $(PROJECT_NAME) creado exitosamente$(NC)"; \
	if [ "$(PROJECT_NAME)" != "$(PROJECT_NORMALIZED)" ]; then \
		echo "$(YELLOW)Docker usará el nombre normalizado: $(PROJECT_NORMALIZED)$(NC)"; \
	fi; \
	echo "$(BLUE)Para continuar:$(NC)"; \
	echo "  make setup PROJECT_NAME=$(PROJECT_NAME)"

init: new-project ## Alias para new-project (retrocompatibilidad)

new-project-mysql: ## Crea nuevo proyecto Laravel con MySQL + phpMyAdmin
	$(MAKE) new-project DB_TYPE=mysql

new-project-postgres: ## Crea nuevo proyecto Laravel con PostgreSQL
	$(MAKE) new-project DB_TYPE=postgres

new-project-l11: ## Crea proyecto Laravel 11 (LTS - más estable)
	$(MAKE) new-project LARAVEL_VERSION=11

new-project-l12: ## Crea proyecto Laravel 12 (balance estabilidad/funcionalidades)
	$(MAKE) new-project LARAVEL_VERSION=12

new-project-l13: ## Crea proyecto Laravel 13 (más reciente)
	$(MAKE) new-project LARAVEL_VERSION=13

new-project-latest: ## Crea proyecto Laravel última versión disponible
	$(MAKE) new-project LARAVEL_VERSION=latest

## ---------- Gestión de proyectos ----------

list-projects: ## Lista todos los proyectos Laravel disponibles
	@echo "$(BLUE)Proyectos Laravel disponibles:$(NC)"
	@for dir in */; do \
		if [ -f "$$dir/composer.json" ] && [ -f "$$dir/docker-compose.yml" ]; then \
			project_name=$$(basename "$$dir"); \
			project_normalized=$$(echo "$$project_name" | tr '[:upper:]' '[:lower:]' | sed 's/[^a-z0-9_-]//g'); \
			hash=$$(echo "$$project_normalized" | shasum | cut -c1-3); \
			base_port=$$((0x$$hash % 900 + 8100)); \
			if docker compose -f "$$dir/docker-compose.yml" -p "$$project_normalized" ps --format json 2>/dev/null | grep -q "running"; then \
				if grep -q "DB_CONNECTION=mysql" "$$dir/.env" 2>/dev/null; then \
					echo "  $(GREEN)✓ $$project_name (MySQL) - http://localhost:$$base_port$(NC)"; \
				elif grep -q "DB_CONNECTION=pgsql" "$$dir/.env" 2>/dev/null; then \
					echo "  $(GREEN)✓ $$project_name (PostgreSQL) - http://localhost:$$base_port$(NC)"; \
				else \
					echo "  $(GREEN)✓ $$project_name (corriendo) - http://localhost:$$base_port$(NC)"; \
				fi; \
			else \
				echo "  ○ $$project_name (detenido) - http://localhost:$$base_port"; \
			fi; \
		fi; \
	done

check-project: ## Verifica que el proyecto existe y tiene estructura correcta
	@if [ -z "$(PROJECT_NAME)" ]; then \
		echo "$(RED)Error: PROJECT_NAME requerido$(NC)"; \
		echo "Uso: make COMANDO PROJECT_NAME=mi_proyecto"; \
		exit 1; \
	fi
	@if [ ! -d "$(PROJECT_NAME)" ]; then \
		echo "$(RED)Error: Proyecto $(PROJECT_NAME) no encontrado$(NC)"; \
		echo "Proyectos disponibles:"; \
		make list-projects; \
		exit 1; \
	fi
	@if [ ! -f "$(PROJECT_NAME)/docker-compose.yml" ]; then \
		echo "$(RED)Error: $(PROJECT_NAME)/docker-compose.yml no encontrado$(NC)"; \
		exit 1; \
	fi

setup: check-project build up ## Build + up + key + migrate (primer arranque tras init)
	@echo "$(BLUE)Configurando proyecto $(PROJECT_NAME)...$(NC)"
	@echo "$(BLUE)Esperando a que la base de datos esté lista...$(NC)"
	@if grep -q "DB_CONNECTION=mysql" "$(PROJECT_NAME)/.env"; then \
		echo "$(BLUE)Esperando inicialización de MySQL...$(NC)"; \
		timeout 120 sh -c 'until $(DC) exec mysql mysqladmin ping -h mysql --silent >/dev/null 2>&1; do echo -n "."; sleep 2; done' || (echo "$(RED)Error: MySQL no está listo$(NC)" && exit 1); \
		echo ""; \
		echo "$(BLUE)Esperando configuración de usuario MySQL...$(NC)"; \
		timeout 60 sh -c 'until $(DC) exec mysql mysql -u laravel -plaravel_password -e "SELECT 1;" >/dev/null 2>&1; do echo -n "."; sleep 2; done' || (echo "$(RED)Error: Usuario MySQL no está listo$(NC)" && exit 1); \
		echo ""; \
	elif grep -q "DB_CONNECTION=pgsql" "$(PROJECT_NAME)/.env"; then \
		timeout 60 sh -c 'until $(DC) exec postgres pg_isready -U laravel >/dev/null 2>&1; do sleep 1; done' || (echo "$(RED)Error: PostgreSQL no está listo$(NC)" && exit 1); \
	else \
		echo "$(RED)Error: Tipo de base de datos no detectado$(NC)" && exit 1; \
	fi
	@echo "$(BLUE)Instalando dependencias...$(NC)"
	$(APP) composer install
	@echo "$(BLUE)Generando clave de aplicación...$(NC)"
	$(APP) php artisan key:generate --force
	@echo "$(BLUE)Ejecutando migraciones...$(NC)"
	$(APP) php artisan migrate --force
	@echo "$(GREEN)✓ Proyecto $(PROJECT_NAME) listo:$(NC)"
	@echo "  🌐 Laravel: http://localhost:$(BASE_PORT)"
	@if grep -q "DB_CONNECTION=mysql" "$(PROJECT_NAME)/.env"; then \
		echo "  🗃️  phpMyAdmin: http://localhost:$(PHPMYADMIN_PORT)"; \
		echo "  🐬 MySQL: localhost:$(MYSQL_PORT)"; \
	elif grep -q "DB_CONNECTION=pgsql" "$(PROJECT_NAME)/.env"; then \
		echo "  🐘 PostgreSQL: localhost:$(POSTGRES_PORT)"; \
	fi
	@echo "  🔴 Redis: localhost:$(REDIS_PORT)"

## ---------- Ciclo de vida (requiere PROJECT_NAME) ----------

build: check-project ## Reconstruye imágenes
	@echo "$(BLUE)Construyendo imagen para $(PROJECT_NAME)...$(NC)"
	@if [ "$(PROJECT_NAME)" != "$(PROJECT_NORMALIZED)" ]; then \
		echo "$(YELLOW)Nombre normalizado para Docker: $(PROJECT_NORMALIZED)$(NC)"; \
	fi
	$(DC) build

up: check-project ## Levanta los contenedores en background
	@echo "$(BLUE)Levantando contenedores para $(PROJECT_NAME)...$(NC)"
	$(DC) up -d
	@echo "$(GREEN)✓ Contenedores de $(PROJECT_NAME) iniciados$(NC)"

down: check-project ## Detiene y elimina los contenedores
	@echo "$(BLUE)Deteniendo contenedores de $(PROJECT_NAME)...$(NC)"
	$(DC) down
	@echo "$(GREEN)✓ Contenedores detenidos$(NC)"

restart: down up ## Reinicio rápido

ps: check-project ## Estado de los contenedores
	@echo "$(BLUE)Estado de contenedores para $(PROJECT_NAME):$(NC)"
	$(DC) ps

status: check-project ## Estado detallado de los servicios
	@echo "$(BLUE)Estado del proyecto $(PROJECT_NAME) (puertos dinámicos):$(NC)"
	@echo "  🌐 Laravel: http://localhost:$(BASE_PORT)"
	@if grep -q "DB_CONNECTION=mysql" "$(PROJECT_NAME)/.env" 2>/dev/null; then \
		echo "  🗃️  phpMyAdmin: http://localhost:$(PHPMYADMIN_PORT)"; \
		echo "  🐬 MySQL: localhost:$(MYSQL_PORT)"; \
	elif grep -q "DB_CONNECTION=pgsql" "$(PROJECT_NAME)/.env" 2>/dev/null; then \
		echo "  🐘 PostgreSQL: localhost:$(POSTGRES_PORT)"; \
	fi
	@echo "  🔴 Redis: localhost:$(REDIS_PORT)"
	@echo ""
	@echo "$(BLUE)Contenedores:$(NC)"
	@$(DC) ps --format "table {{.Name}}\t{{.Status}}\t{{.Ports}}"
	@echo ""
	@echo "$(BLUE)Verificando conectividad:$(NC)"
	@if $(DC) exec app php artisan --version >/dev/null 2>&1; then \
		echo "$(GREEN)✓ Laravel funcionando$(NC)"; \
	else \
		echo "$(RED)✗ Laravel no disponible$(NC)"; \
	fi
	@if grep -q "DB_CONNECTION=mysql" "$(PROJECT_NAME)/.env" 2>/dev/null; then \
		if $(DC) exec mysql mysqladmin -u laravel -plaravel_password ping >/dev/null 2>&1; then \
			echo "$(GREEN)✓ MySQL funcionando$(NC)"; \
		else \
			echo "$(RED)✗ MySQL no disponible$(NC)"; \
		fi; \
	elif grep -q "DB_CONNECTION=pgsql" "$(PROJECT_NAME)/.env" 2>/dev/null; then \
		if $(DC) exec postgres pg_isready -U laravel >/dev/null 2>&1; then \
			echo "$(GREEN)✓ PostgreSQL funcionando$(NC)"; \
		else \
			echo "$(RED)✗ PostgreSQL no disponible$(NC)"; \
		fi; \
	else \
		echo "$(YELLOW)? Base de datos no detectada$(NC)"; \
	fi
	@if $(DC) exec redis redis-cli ping >/dev/null 2>&1; then \
		echo "$(GREEN)✓ Redis funcionando$(NC)"; \
	else \
		echo "$(RED)✗ Redis no disponible$(NC)"; \
	fi

logs: check-project ## Logs de la app (Ctrl+C para salir)
	$(DC) logs -f app

logs-all: check-project ## Logs de todos los servicios
	$(DC) logs -f

## ---------- Laravel (requiere PROJECT_NAME) ----------

shell: check-project ## Bash dentro del contenedor app
	$(APP) bash

tinker: check-project ## Tinker
	$(APP) php artisan tinker

migrate: check-project ## Ejecuta migraciones
	$(APP) php artisan migrate

fresh: check-project ## Drop + migrate + seed (¡borra datos!)
	$(APP) php artisan migrate:fresh --seed

cache-clear: check-project ## Limpia todos los caches de Laravel
	$(APP) php artisan optimize:clear

test: check-project ## Corre la suite de tests
	$(APP) php artisan test

## ---------- Composer / Artisan passthrough (requiere PROJECT_NAME) ----------
# Uso: make composer PROJECT_NAME=mi_proyecto cmd="require laravel/horizon"
# Uso: make artisan PROJECT_NAME=mi_proyecto cmd="make:model Foo -m"

composer: check-project ## Composer arbitrario: make composer PROJECT_NAME=... cmd="..."
	$(APP) composer $(cmd)

artisan: check-project ## Artisan arbitrario: make artisan PROJECT_NAME=... cmd="..."
	$(APP) php artisan $(cmd)

## ---------- DB (requiere PROJECT_NAME) ----------

db-cli: check-project ## Consola de base de datos (MySQL o PostgreSQL)
	@if grep -q "DB_CONNECTION=mysql" "$(PROJECT_NAME)/.env"; then \
		echo "$(BLUE)Conectando a MySQL...$(NC)"; \
		$(DC) exec mysql mysql -u laravel -plaravel_password laravel; \
	elif grep -q "DB_CONNECTION=pgsql" "$(PROJECT_NAME)/.env"; then \
		echo "$(BLUE)Conectando a PostgreSQL...$(NC)"; \
		$(DC) exec postgres psql -U laravel -d laravel; \
	else \
		echo "$(RED)Error: Tipo de base de datos no detectado$(NC)"; \
	fi

mysql-cli: check-project ## Consola MySQL (específica)
	$(DC) exec mysql mysql -u laravel -plaravel_password laravel

psql: check-project ## Consola PostgreSQL (específica)
	$(DC) exec postgres psql -U laravel -d laravel

redis-cli: check-project ## Consola Redis
	$(DC) exec redis redis-cli

## ---------- Paquetes Personalizados (requiere PROJECT_NAME) ----------

install-vitalaccess: check-project ## Instalar VitalAccess automáticamente
	@echo "$(BLUE)Instalando VitalAccess en $(PROJECT_NAME)...$(NC)"
	@./install-vitalaccess.sh $(PROJECT_NAME)

install-vitalcms: check-project ## Instalar VitalCMS automáticamente
	@echo "$(BLUE)Instalando VitalCMS v1 en $(PROJECT_NAME)...$(NC)"
	@if [ ! -f "packages/vitalcms-v1/install-vitalcms.sh" ]; then \
		echo "$(RED)Error: VitalCMS no encontrado en packages/vitalcms-v1/$(NC)"; \
		echo "Asegúrate de que el paquete VitalCMS esté en packages/vitalcms-v1/"; \
		exit 1; \
	fi
	@cd $(PROJECT_NAME) && ../packages/vitalcms-v1/install-vitalcms.sh --yes --dev
	@echo "$(GREEN)✓ VitalCMS v1 instalado exitosamente en $(PROJECT_NAME)$(NC)"
	@echo "$(BLUE)Panel de administración disponible en: http://localhost:$(BASE_PORT)/cms$(NC)"

install-package: check-project ## Instalar paquete personalizado: make install-package PROJECT_NAME=... PACKAGE=...
	@if [ -z "$(PACKAGE)" ]; then \
		echo "$(RED)Error: PACKAGE requerido$(NC)"; \
		echo "Uso: make install-package PROJECT_NAME=mi_proyecto PACKAGE=vendor/package"; \
		exit 1; \
	fi
	@echo "$(BLUE)Instalando $(PACKAGE) en $(PROJECT_NAME)...$(NC)"
	$(APP) composer require $(PACKAGE)
	$(APP) php artisan vendor:publish --force --all
	$(APP) php artisan migrate
	$(APP) php artisan config:clear
	$(APP) php artisan cache:clear
	@echo "$(GREEN)✓ $(PACKAGE) instalado exitosamente$(NC)"

## ---------- Limpieza (requiere PROJECT_NAME) ----------

clean: check-project ## Baja todo y borra volúmenes (¡borra DB!)
	$(DC) down -v

nuke: check-project ## clean + borra imágenes del proyecto
	$(DC) down --rmi local -v

clean-all: ## Borra TODOS los contenedores y volúmenes de Docker (¡PELIGROSO!)
	@echo "$(RED)⚠️  PELIGRO: Esto borrará TODOS los contenedores y volúmenes de Docker$(NC)"
	@read -p "¿Estás seguro? [y/N]: " confirm; \
	if [ "$$confirm" = "y" ] || [ "$$confirm" = "Y" ]; then \
		docker system prune -af --volumes; \
		echo "$(GREEN)✓ Sistema Docker limpiado$(NC)"; \
	else \
		echo "$(BLUE)Cancelado$(NC)"; \
	fi

clean-laravel: ## Limpia solo proyectos Laravel (más seguro que clean-all)
	@echo "$(BLUE)🗑️  Limpiando solo proyectos Laravel...$(NC)"
	@./cleanup-laravel-projects.sh

## ---------- Help ----------

help: ## Muestra esta ayuda
	@echo "$(BLUE)Laravel + FrankenPHP + Docker - Generador de Proyectos$(NC)"
	@echo ""
	@echo "$(YELLOW)Comandos principales:$(NC)"
	@echo "  $(GREEN)new-project-mysql$(NC)           Crea proyecto con MySQL + phpMyAdmin"
	@echo "  $(GREEN)new-project-postgres$(NC)        Crea proyecto con PostgreSQL"
	@echo "  $(GREEN)new-project$(NC)                 Crea proyecto (MySQL por defecto)"
	@echo "  $(GREEN)list-projects$(NC)               Lista proyectos existentes"
	@echo ""
	@echo "$(YELLOW)Versiones específicas de Laravel:$(NC)"
	@echo "  $(GREEN)new-project-l11$(NC)             Laravel 11 (LTS - más estable, mejor soporte Filament)"
	@echo "  $(GREEN)new-project-l12$(NC)             Laravel 12 (balance estabilidad/funcionalidades)"
	@echo "  $(GREEN)new-project-l13$(NC)             Laravel 13 (más reciente, puede tener incompatibilidades)"
	@echo "  $(GREEN)new-project-latest$(NC)          Laravel última versión disponible"
	@echo ""
	@echo "$(YELLOW)Para trabajar con un proyecto específico:$(NC)"
	@echo "  make COMANDO $(BLUE)PROJECT_NAME=mi_proyecto$(NC)"
	@echo ""
	@echo "$(YELLOW)Comandos disponibles:$(NC)"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | \
		awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2}'
	@echo ""
	@echo "$(YELLOW)Ejemplos:$(NC)"
	@echo "  $(BLUE)# Proyecto con MySQL$(NC)"
	@echo "  make new-project-mysql PROJECT_NAME=tienda_mysql"
	@echo "  $(BLUE)# Proyecto con PostgreSQL$(NC)"
	@echo "  make new-project-postgres PROJECT_NAME=blog_postgres"
	@echo "  $(BLUE)# Proyecto Laravel 12 con MySQL (recomendado para Filament)$(NC)"
	@echo "  make new-project-l12 PROJECT_NAME=admin_panel DATABASE=mysql"
	@echo "  $(BLUE)# Proyecto interactivo (pregunta versión)$(NC)"
	@echo "  make new-project PROJECT_NAME=mi_app"
	@echo "  $(BLUE)# Configurar proyecto$(NC)"
	@echo "  make setup PROJECT_NAME=admin_panel"
	@echo "  $(BLUE)# Instalar VitalCMS (requiere setup previo)$(NC)"
	@echo "  make install-vitalcms PROJECT_NAME=admin_panel"
	@echo "  $(BLUE)# Trabajar con el proyecto$(NC)"
	@echo "  make shell PROJECT_NAME=tienda_mysql"
	@echo "  make db-cli PROJECT_NAME=tienda_mysql"

.PHONY: check-templates new-project new-project-mysql new-project-postgres new-project-l11 new-project-l12 new-project-l13 new-project-latest init list-projects check-project setup build up down restart ps status logs logs-all shell tinker migrate fresh cache-clear test composer artisan db-cli mysql-cli psql redis-cli install-vitalaccess install-vitalcms install-package clean nuke clean-all clean-laravel help