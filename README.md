# Proyecto Marketplace

Este es un proyecto desarrollado con **Laravel**, preparado para correr localmente con MySQL.

## 1. Requisitos

- PHP >= 8.1
- Composer
- MySQL
- Git

---

## 2. Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/DvJeremy/prueba_tecnica.git
cd prueba_tecnica

2. Instala dependencias de PHP:

composer install

## 2. Instalación

1. Crea una base de datos en MySQL:

CREATE DATABASE marketplace;


2. Copia el archivo de ejemplo .env.example a .env:

cp .env.example .env


3. Configura las variables de entorno para tu base de datos en .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=marketplace
DB_USERNAME=root
DB_PASSWORD=

4. Ejecuta las migraciones y seeders:

php artisan migrate --seed

5. Ejecutar la aplicación localmente

php artisan serve
