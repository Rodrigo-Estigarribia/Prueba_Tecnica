# Sistema de Gestión de Clientes, Productos y Compras

Este proyecto es una pequeña aplicacion web costuida con **Laravel** y **Bootstrap** el cual permite:

- Gestionar **clientes** (crear, listar, editar, eliminar).
- Gestionar **productos** (crear, listar, editar, eliminar).
- Registrar **compras** con actualización automática de stock mediante un **webhook**.
- Visualizar un **historial de compras** con detalle de clientes y productos.
---

## Tecnologías utilizadas

## 🚀 Tecnologías utilizadas

- [Laravel 12.28.1](https://laravel.com/)  
- [PHP 8.2.12](https://www.php.net/)  
- [MySQL](https://www.mysql.com/) como base de datos  
- [Bootstrap 5](https://getbootstrap.com/) para estilos  
- [Composer](https://getcomposer.org/) para manejar dependencias de PHP  
- [XAMPP](https://www.apachefriends.org/index.html) como servidor local  
- **JavaScript (Fetch API + autocompletado)** para consumo de la API y funcionalidades dinámicas en el frontend 

# Ejecutar el siguiente comando para instalar las dependencias
composer install

# Configuracion de la base de datos en .env:
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=gestion
DB_USERNAME=
DB_PASSWORD=
**tener en cuenta** en el archivo **.env.example** borrar el example que quede tal que asi **.env** seguido ejecutar el siguiente comando **php artisan key:generate** para generar la clave de laravel


# Ejecutar el siguiente comando para migraciones:
php artisan migrate --seed

# Ejecutar el siguiente comando para iniciar el servidor:
php artisan serve
acceder a la url que se indica

# Ubicacion de la base de datos:
database/gestion.sql
**para importar la base de datos** se debe de crear en phpMyAdmin una base de datos con el nombre de **gestion** y ahi importar el archivo gestion.sql

