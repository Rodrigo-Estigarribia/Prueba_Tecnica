# Sistema de Gestión de Clientes, Productos y Compras

Este proyecto es una pequeña aplicacion web costuida con **Laravel** y **Bootstrap** el cual permite:

- Gestionar **clientes** (crear, listar, editar, eliminar).
- Gestionar **productos** (crear, listar, editar, eliminar).
- Registrar **compras** con actualización automática de stock mediante un **webhook**.
- Visualizar un **historial de compras** con detalle de clientes y productos.
---

## Tecnologías utilizadas

- [Laravel 12.28.1](https://laravel.com/)
- [PHP 8.2.12](https://www.php.net/)
- [MySQL](https://www.mysql.com/) como base de datos
- [Bootstrap 5](https://getbootstrap.com/) para estilos
- [JavaScript (Fetch API)](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API) para consumo de la API

# Configuracion de la base de datos en .env:
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=gestion
DB_USERNAME=
DB_PASSWORD=

# Ejecutar el siguiente comando para migraciones:
php artisan migrate --seed

# Ejecutar el siguiente comando para iniciar el servidor:
php artisan serve
acceder a la url que se indica

# Ubicacion de la base de datos:
database/gestion.sql

