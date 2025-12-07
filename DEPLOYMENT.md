# Guía de Despliegue - Sistema de Asignación de Salones

## Despliegue en Render.com

### Requisitos Previos
- Cuenta en Render.com
- Repositorio en GitHub con el código del proyecto
- Base de datos PostgreSQL en Supabase o Render

### Pasos de Despliegue

#### 1. Preparar el Proyecto

```bash
# Crear archivo Procfile
echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile

# Crear archivo .env.production
cp .env .env.production
```

#### 2. Configurar en Render

1. Ir a https://render.com
2. Crear nuevo "Web Service"
3. Conectar repositorio GitHub
4. Configurar:
   - **Build Command**: `composer install && php artisan migrate --force`
   - **Start Command**: `vendor/bin/heroku-php-apache2 public/`

#### 3. Variables de Entorno

Agregar en Render:
```
APP_NAME="Sistema de Asignación de Salones"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-app.onrender.com
DB_CONNECTION=pgsql
DB_HOST=tu-supabase-host
DB_PORT=5432
DB_DATABASE=tu-database
DB_USERNAME=tu-user
DB_PASSWORD=tu-password
```

#### 4. Desplegar

- Push a GitHub
- Render desplegará automáticamente

## Despliegue Local con Docker

### Dockerfile

```dockerfile
FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY . /var/www/html
WORKDIR /var/www/html

RUN composer install
RUN php artisan migrate

EXPOSE 80
```

### Docker Compose

```yaml
version: '3.8'

services:
  app:
    build: .
    ports:
      - "8000:80"
    environment:
      - DB_HOST=postgres
      - DB_DATABASE=salones_db
      - DB_USERNAME=postgres
      - DB_PASSWORD=password
    depends_on:
      - postgres

  postgres:
    image: postgres:15
    environment:
      - POSTGRES_DB=salones_db
      - POSTGRES_USER=postgres
      - POSTGRES_PASSWORD=password
    volumes:
      - postgres_data:/var/lib/postgresql/data

volumes:
  postgres_data:
```

## Configuración de Supabase

### Crear Proyecto en Supabase

1. Ir a https://supabase.com
2. Crear nuevo proyecto
3. Obtener credenciales:
   - Host
   - Database
   - User
   - Password

### Conectar Laravel a Supabase

Actualizar `.env`:
```
DB_CONNECTION=pgsql
DB_HOST=db.xxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=tu-password
```

## Monitoreo y Mantenimiento

### Logs
```bash
# Ver logs en Render
# Dashboard > Logs

# O localmente
tail -f storage/logs/laravel.log
```

### Backups
```bash
# Backup manual de BD
pg_dump -h host -U user -d database > backup.sql

# Restaurar
psql -h host -U user -d database < backup.sql
```

### Actualizaciones
```bash
# Actualizar dependencias
composer update

# Ejecutar migraciones
php artisan migrate --force
```

## Solución de Problemas

### Error: "SQLSTATE[08006]"
- Verificar credenciales de BD
- Verificar firewall/whitelist en Supabase

### Error: "Class not found"
- Ejecutar `composer install`
- Ejecutar `php artisan cache:clear`

### Error: "Migrations table not found"
- Ejecutar `php artisan migrate --force`

---

Para soporte adicional, consultar documentación oficial:
- Laravel: https://laravel.com/docs
- Render: https://render.com/docs
- Supabase: https://supabase.com/docs
