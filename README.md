
# Proyecto PHP: Sistema de autenticación y sistema de ventas

## Estructura

- `auth_system/` — Registro/Login/Logout de usuarios, guarda usuarios en MySQL.
- `sales_system/` — Sistema de ventas modular, estructura MVC por módulo.
- `db_init.sql` — Script para crear las tablas en MySQL.

## Cómo levantar los servidores PHP embebidos

Abre dos terminales en la carpeta raíz del proyecto y ejecuta:

```sh
# Terminal 1: Auth system en puerto 8001
cd auth_system
php -S localhost:8001

# Terminal 2: Sales system en puerto 8000
cd sales_system
php -S localhost:8000
```
