# Guía Completa de Despliegue en Render.com

## Paso 1: Preparar el Repositorio GitHub

### 1.1 Crear repositorio en GitHub
```bash
git init
git add .
git commit -m "Initial commit: Sistema de Asignación de Salones"
git branch -M main
git remote add origin https://github.com/tu-usuario/proyecto-salones.git
git push -u origin main
```

### 1.2 Archivos necesarios (ya incluidos)
- ✅ `Procfile` - Configuración para Render
- ✅ `render.yaml` - Configuración YAML de Render
- ✅ `.env.production` - Variables de producción
- ✅ `composer.json` - Dependencias PHP

## Paso 2: Crear Base de Datos en Supabase

### 2.1 Crear proyecto Supabase
1. Ir a https://supabase.com
2. Crear nuevo proyecto
3. Esperar a que se inicialice (5-10 minutos)

### 2.2 Obtener credenciales
1. Ir a Settings → Database
2. Copiar:
   - **Host**: db.xxxxx.supabase.co
   - **Database**: postgres
   - **User**: postgres
   - **Password**: (la que estableciste)
   - **Port**: 5432

## Paso 3: Desplegar en Render

### 3.1 Crear Web Service en Render
1. Ir a https://render.com
2. Dashboard → New → Web Service
3. Conectar repositorio GitHub
4. Configurar:
   - **Name**: sistema-salones
   - **Environment**: PHP
   - **Region**: Seleccionar más cercana
   - **Plan**: Free (o superior)

### 3.2 Build Command
```bash
composer install && php artisan migrate --force
```

### 3.3 Start Command
```bash
vendor/bin/heroku-php-apache2 public/
```

### 3.4 Variables de Entorno
Agregar en Render Dashboard:

```
APP_NAME=Sistema de Asignación de Salones
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:xxxxx (generar con php artisan key:generate)
APP_URL=https://tu-app.onrender.com

DB_CONNECTION=pgsql
DB_HOST=db.xxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=tu_password_supabase

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
```

## Paso 4: Configurar Base de Datos

### 4.1 Ejecutar migraciones
Render ejecutará automáticamente las migraciones durante el build.

### 4.2 Ejecutar seeders (opcional)
Puedes ejecutar seeders desde la consola de Render:
```bash
php artisan db:seed
```

## Paso 5: Verificar Despliegue

1. Ir a https://tu-app.onrender.com
2. Debería ver la página de login
3. Usar credenciales de prueba:
   - Email: admin@salones.local
   - Contraseña: admin123

## Solución de Problemas

### Error: "Application Error"
- Revisar logs en Render Dashboard
- Verificar variables de entorno
- Ejecutar: `php artisan config:cache`

### Error: "SQLSTATE[08006]"
- Verificar credenciales de Supabase
- Verificar que Supabase esté activo
- Agregar IP de Render a whitelist de Supabase (si es necesario)

### Error: "Class not found"
- Ejecutar: `composer install`
- Ejecutar: `php artisan cache:clear`

### Migraciones no se ejecutan
- Verificar que `render.yaml` esté correcto
- Revisar logs de build en Render

## Actualizar Aplicación

Después de hacer cambios:

```bash
git add .
git commit -m "Descripción de cambios"
git push origin main
```

Render se redesplegará automáticamente.

## Monitoreo

### Ver logs
```bash
# En Render Dashboard
Logs → View Logs
```

### Backup de base de datos
```bash
# Desde Supabase
Database → Backups → Create Backup
```

## Seguridad en Producción

- ✅ `APP_DEBUG=false`
- ✅ `APP_ENV=production`
- ✅ Cambiar `APP_KEY` en cada instalación
- ✅ Usar HTTPS (automático en Render)
- ✅ Configurar CORS si es necesario
- ✅ Validar todas las entradas de usuario

## Próximos Pasos

1. Configurar notificaciones por correo
2. Agregar autenticación de dos factores
3. Implementar sistema de logs avanzado
4. Configurar backups automáticos
5. Agregar monitoreo y alertas

---

**¡Despliegue completado!** 🚀
