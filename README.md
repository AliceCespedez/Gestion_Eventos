# EvenTea - Gestión de Eventos

## Descripción

EvenTea es una aplicación web para la gestión integral de eventos desarrollada con Laravel. Permite a los usuarios organizar y administrar eventos, gestionar invitados, menús, servicios y presupuestos. La plataforma cuenta con diferentes roles de usuario: administradores, empleados y clientes, cada uno con permisos específicos.

## Características principales

- Gestión completa de eventos (crear, editar, eliminar, ver detalles)
- Sistema de autenticación con tres roles de usuario
- Panel de control diferenciado por roles
- Gestión de invitados con confirmación de asistencia
- Asignación de mesas y asientos para eventos
- Catálogo de menús con precios y descripciones estructuradas
- Catálogo de servicios complementarios
- Control de presupuesto con cálculo en tiempo real
- Gráficos estadísticos de eventos por mes
- Sistema de consultas y notificaciones
- Interfaz responsive con Bootstrap 5
- Fuentes personalizadas y diseño adaptado a la identidad de marca

## Tecnologías utilizadas

- Laravel 10 / 11
- PHP 8.1 o superior
- MySQL
- Bootstrap 5
- Bootstrap Icons
- Chart.js
- HTML5 / CSS3
- JavaScript

## Requisitos previos

- PHP >= 8.1
- Composer
- Node.js y NPM
- MySQL
- XAMPP / WAMP / Laragon (para entorno local) o cualquier servidor con soporte PHP y MySQL

## Instalación

### Clonar el repositorio
git clone https://github.com/AliceCespedez/Gestion_Eventos.git
cd Gestion_Eventos

text

### Instalar dependencias de PHP
composer install

text

### Instalar dependencias de Node.js
npm install

text

### Configurar el archivo de entorno
cp .env.example .env

text

Editar el archivo .env con tus credenciales de base de datos:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eventea
DB_USERNAME=root
DB_PASSWORD=

text

### Generar clave de la aplicación
php artisan key:generate

text

### Ejecutar migraciones y seeders
php artisan migrate --seed

text

### Compilar assets
npm run build

text

Para entorno de desarrollo:
npm run dev

text

### Iniciar el servidor
php artisan serve

text

La aplicación estará disponible en `http://localhost:8000`

## Estructura de la base de datos

Principales tablas del sistema:

- usuarios - Usuarios del sistema con roles (admin, empleado, cliente)
- eventos - Eventos creados por los usuarios
- invitados - Invitados asociados a eventos
- mesas - Mesas configuradas para eventos
- asientos - Asientos pertenecientes a mesas
- menu - Catálogo de menús disponibles
- menu_evento - Relación entre eventos y menús (con cantidad)
- servicios - Catálogo de servicios complementarios
- servicios_contratados - Servicios contratados para eventos
- locales - Locales disponibles para eventos
- tipo_evento - Tipos de eventos (cumpleaños, boda, etc.)
- consultas - Consultas de contacto de los usuarios

## Roles y permisos

### Administrador
- Acceso a todas las funcionalidades
- Gestión de usuarios (clientes y empleados)
- Dashboard con estadísticas globales
- Gestión de menús y servicios
- Gestión de locales y tipos de eventos

### Empleado
- Gestión de eventos de clientes
- Acceso a consultas
- Gestión de invitados y mesas
- No puede gestionar usuarios

### Cliente
- Gestión de sus propios eventos
- Visualización de sus eventos
- Gestión de invitados de sus eventos
- Consulta de presupuestos

## Estructura de directorios importante

- `app/Models/` - Modelos de la base de datos
- `app/Http/Controllers/` - Controladores de la aplicación
- `routes/web.php` - Definición de rutas
- `resources/views/` - Vistas Blade
- `public/css/` - Archivos CSS personalizados
- `public/images/` - Imágenes estáticas
- `database/migrations/` - Migraciones de base de datos
- `database/seeders/` - Seeders para datos de prueba

## Estilos y personalización

Los estilos personalizados se encuentran en:
- `public/css/app.css` - Estilos globales y variables CSS
- `public/css/fonts.css` - Definiciones de fuentes tipográficas

Variables CSS principales definidas en `app.css`:

```css
:root {
    --font-primary: 'BeVietnam', sans-serif;
    --font-secondary: 'PlayfairDisplay', serif;
    --color-chocolate: #574E49;
    --color-beige-medio: #D8D5CF;
    --color-beige-claro: #E9E5DF;
}
Mantenimiento
Limpiar caché de Laravel
text
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
Recargar autoload de Composer
text
composer dump-autoload
Crear enlace simbólico para almacenamiento
text
php artisan storage:link
Posibles problemas y soluciones
Error de conexión a base de datos:

Verificar credenciales en archivo .env

Asegurar que el servicio MySQL esté corriendo en XAMPP

Error de tabla no encontrada:

Ejecutar php artisan migrate:fresh --seed para recrear las tablas

Error de permisos en storage/logs:

En Linux/Mac: chmod -R 775 storage

Créditos
Proyecto desarrollado como parte de un sistema de gestión de eventos.

Licencia
Este proyecto es de uso interno. Todos los derechos reservados.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
