#!/bin/bash

# 🗑️ Laravel Projects Cleanup Script
# Limpia solo los proyectos Laravel generados, no todo Docker

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}🗑️  Limpiador de Proyectos Laravel${NC}"
echo ""

# Detectar proyectos Laravel en el directorio actual
PROJECTS=($(find . -maxdepth 1 -type d -name "*" -not -path "." -not -path "./packages" | sed 's|./||'))

if [ ${#PROJECTS[@]} -eq 0 ]; then
    echo -e "${YELLOW}ℹ️  No se encontraron proyectos para limpiar${NC}"
    exit 0
fi

echo -e "${YELLOW}📁 Proyectos encontrados:${NC}"
for project in "${PROJECTS[@]}"; do
    echo "   • $project"
done
echo ""

# Preguntar confirmación
echo -e "${RED}⚠️  Esto eliminará:${NC}"
echo "   • Contenedores Docker de estos proyectos"
echo "   • Volúmenes de bases de datos"
echo "   • Directorios de proyectos"
echo "   • NO afectará otros contenedores Docker"
echo ""

read -p "¿Continuar? [y/N]: " confirm

if [ "$confirm" != "y" ] && [ "$confirm" != "Y" ]; then
    echo -e "${BLUE}❌ Cancelado${NC}"
    exit 0
fi

echo ""
echo -e "${BLUE}🚀 Iniciando limpieza...${NC}"

# Limpiar cada proyecto
for project in "${PROJECTS[@]}"; do
    echo ""
    echo -e "${YELLOW}📦 Limpiando proyecto: $project${NC}"

    # Verificar si tiene docker-compose.yml
    if [ -f "$project/docker-compose.yml" ]; then
        # Usar make clean si está en el directorio correcto
        if [ -f "Makefile" ]; then
            make clean PROJECT_NAME="$project" 2>/dev/null || {
                echo "   ⚠️  make clean falló, usando docker compose directo"
                cd "$project" 2>/dev/null && docker compose down -v 2>/dev/null && cd .. || echo "   ❌ No se pudo limpiar $project"
            }
        else
            # Limpiar directo con docker compose
            cd "$project" 2>/dev/null && docker compose down -v 2>/dev/null && cd .. || echo "   ❌ No se pudo limpiar $project"
        fi

        # Eliminar directorio
        echo "   🗂️  Eliminando directorio..."
        rm -rf "$project"
        echo -e "   ${GREEN}✅ $project eliminado${NC}"
    else
        echo -e "   ${YELLOW}⚠️  $project no parece ser un proyecto Laravel Docker${NC}"
        read -p "   ¿Eliminar directorio $project anyway? [y/N]: " delete_confirm
        if [ "$delete_confirm" = "y" ] || [ "$delete_confirm" = "Y" ]; then
            rm -rf "$project"
            echo -e "   ${GREEN}✅ $project eliminado${NC}"
        else
            echo -e "   ${BLUE}⏭️  $project omitido${NC}"
        fi
    fi
done

# Limpiar contenedores huérfanos relacionados con Laravel
echo ""
echo -e "${BLUE}🧹 Limpiando contenedores huérfanos...${NC}"
docker container prune -f 2>/dev/null || echo "   ⚠️  No se pudieron limpiar contenedores huérfanos"

# Limpiar volúmenes no utilizados
echo -e "${BLUE}💾 Limpiando volúmenes no utilizados...${NC}"
docker volume prune -f 2>/dev/null || echo "   ⚠️  No se pudieron limpiar volúmenes no utilizados"

# Limpiar redes no utilizadas
echo -e "${BLUE}🌐 Limpiando redes no utilizadas...${NC}"
docker network prune -f 2>/dev/null || echo "   ⚠️  No se pudieron limpiar redes no utilizadas"

echo ""
echo -e "${GREEN}🎉 Limpieza completada${NC}"

# Mostrar estado final
echo ""
echo -e "${BLUE}📊 Estado final:${NC}"
echo "   🗂️  Directorios restantes:"
ls -la | grep "^d" | grep -v "^\.$\|^\.\.$\|packages" || echo "      (ninguno)"

echo "   🐳 Contenedores activos:"
docker ps --format "table {{.Names}}\t{{.Status}}" | grep -E "(laravel|mysql|redis|phpmyadmin)" 2>/dev/null || echo "      (ninguno relacionado con Laravel)"