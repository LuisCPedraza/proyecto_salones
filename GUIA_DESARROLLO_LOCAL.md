# Guía de Desarrollo Local

## Instalación Inicial

### 1. Clonar el Proyecto
```bash
git clone https://github.com/tu-usuario/proyecto-salones.git
cd proyecto-salones
```

### 2. Instalar Dependencias
```bash
composer install
```

### 3. Configurar Archivo .env
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar Base de Datos

Editar `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=salones_db
DB_USERNAME=postgres
DB_PASSWORD=password
```

### 5. Crear Base de Datos
```bash
createdb salones_db
```

### 6. Ejecutar Migraciones
```bash
php artisan migrate
```

### 7. Cargar Datos Iniciales
```bash
php artisan db:seed
```

### 8. Iniciar Servidor
```bash
php artisan serve
```

Acceder a: http://localhost:8000

## Usuarios de Prueba

| Email | Contraseña | Rol |
|-------|-----------|-----|
| admin@salones.local | admin123 | Administrador |
| coordinador@salones.local | coordinador123 | Coordinador |
| profesor@salones.local | profesor123 | Profesor |

## Comandos Útiles

### Crear nuevo modelo con migración
```bash
php artisan make:model NombreModelo -m
```

### Crear controlador
```bash
php artisan make:controller NombreController
```

### Crear migración
```bash
php artisan make:migration create_tabla_table
```

### Ejecutar migraciones
```bash
php artisan migrate
```

### Revertir última migración
```bash
php artisan migrate:rollback
```

### Revertir todas las migraciones
```bash
php artisan migrate:reset
```

### Ejecutar seeders
```bash
php artisan db:seed
```

### Ejecutar pruebas
```bash
php artisan test
```

### Limpiar caché
```bash
php artisan cache:clear
php artisan config:cache
php artisan route:cache
```

## Estructura del Proyecto

```
proyecto_salones/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controladores
│   │   └── Middleware/      # Middleware
│   ├── Models/              # Modelos Eloquent
│   └── Services/            # Servicios de negocio
├── database/
│   ├── migrations/          # Migraciones
│   └── seeders/             # Seeders
├── resources/
│   └── views/               # Vistas Blade
├── routes/
│   ├── web.php              # Rutas web
│   └── api.php              # Rutas API
├── tests/                   # Pruebas
├── .env.example             # Variables de ejemplo
├── composer.json            # Dependencias
└── README.md                # Documentación
```

## Desarrollo de Nuevas Funcionalidades

### 1. Crear Modelo
```bash
php artisan make:model NombreModelo -m
```

### 2. Definir Migración
Editar `database/migrations/xxxx_create_nombre_table.php`

### 3. Crear Controlador
```bash
php artisan make:controller NombreController
```

### 4. Agregar Rutas
Editar `routes/web.php`

### 5. Crear Vistas
Crear archivos en `resources/views/`

### 6. Ejecutar Migraciones
```bash
php artisan migrate
```

## Debugging

### Usar dd() para debug
```php
dd($variable); // Muestra y detiene
```

### Usar Log
```php
Log::info('Mensaje', ['datos' => $datos]);
```

### Ver logs
```bash
tail -f storage/logs/laravel.log
```

## Buenas Prácticas

- ✅ Usar type hints en funciones
- ✅ Validar todas las entradas
- ✅ Usar transacciones para operaciones críticas
- ✅ Agregar comentarios en código complejo
- ✅ Escribir pruebas para nuevas funcionalidades
- ✅ Usar modelos en lugar de queries crudas
- ✅ Mantener controladores simples
- ✅ Usar servicios para lógica de negocio

## Git Workflow

```bash
# Crear rama para nueva funcionalidad
git checkout -b feature/nombre-funcionalidad

# Hacer cambios y commits
git add .
git commit -m "Descripción clara del cambio"

# Subir rama
git push origin feature/nombre-funcionalidad

# Crear Pull Request en GitHub
# Después de revisar, hacer merge a main

# Actualizar local
git checkout main
git pull origin main
```

---

¡Listo para desarrollar! 🚀
