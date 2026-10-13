#  MyLibrary - Sistema de Gestión de Biblioteca

Este es un sistema de gestión para bibliotecas desarrollado en **PHP** utilizando el framework **Laravel 11** y **MySQL** como motor de base de datos. El proyecto utiliza una arquitectura limpia basada en el patrón Modelo-Vista-Controlador (MVC).

---

## Reparto del Equipo de Desarrollo

*   **Desarrollador 1 (Base de Datos y Modelos): Juan David Mosquera Cabrera
*   **Desarrollador 2 (Validaciones y Lógica de Negocio): Katty Dalieth Reyes Pérez
*   **Desarrollador 3 (Controladores, API y Rutas): Andres Steven Velasquez Usuga
*   **Desarrollador 4 (Interfaz de Usuario y Vistas Blade): Saray Milena Parra Henao

---

## Requisitos Previos

Antes de instalar el proyecto, asegúrate de tener instalado en tu computadora:
*   [PHP 8.2 o superior](https://php.net)
*   [Composer](https://getcomposer.org)
*   [XAMPP](https://apachefriends.org) (Con el módulo MySQL activo)
*   [Git](https://git-scm.com)

---

## Instrucciones de Instalación para el Equipo

Si eres uno de los desarrolladores del equipo, sigue estos pasos para montar el proyecto de forma idéntica en tu máquina local:

### 1. Clonar el repositorio y actualizar código
Abre tu terminal en tu carpeta de proyectos y descarga los últimos cambios subidos por el Integrante 1:
```bash
git pull origin main
```

### 2. Instalar dependencias de PHP
Entra a la carpeta del proyecto e instala los paquetes necesarios administrados por Composer:
```bash
cd MyLibrary
composer install
```

### 3. Configurar el archivo de entorno `.env`
Crea una copia del archivo de configuración ambiental:
```bash
cp .env.example .env
```
*(Si usas la consola clásica CMD de Windows y te da error, utiliza: `copy .env.example .env`)*

Abre el nuevo archivo `.env` en VS Code y asegúrate de configurar las credenciales de tu base de datos de XAMPP:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=letras_y_tinta
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generar la clave de la aplicación
```bash
php artisan key:generate
```

### 5. Ejecutar Migraciones y Seeders (Poblar Base de Datos)
Asegúrate de tener **XAMPP abierto y el módulo de MySQL encendido en color verde**. Luego, ejecuta este comando para crear las tablas en tu servidor e inyectar los 30 libros y autores de prueba de forma automática:
```bash
php artisan migrate:fresh --seed
```

### 6. Levantar el servidor local
```bash
php artisan serve
```
Ya puedes abrir en tu navegador la dirección que te indique la consola (normalmente `http://127.0.0.1:8000`) para ver el proyecto corriendo.

---

## Estructura Base de Datos Creada (Fase 1)

El sistema ya cuenta con las siguientes entidades y sus relaciones lógicas listas en Eloquent ORM:
*   **`users`**: Administradores, bibliotecarios y lectores.
*   **`authors`**: Autores de los libros de la biblioteca.
*   **`books`**: Catálogo de libros (enlazados con su respectivo `author_id`).
*   **`loans`**: Registro transaccional de los préstamos realizados (conecta `user_id` y `book_id`).
