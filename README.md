
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
cd ../sales_system
php -S localhost:8000
```

## Configuración base de datos

1. Crea la base de datos y tablas ejecutando el SQL:
    ```
    mysql -u root -p < db_init.sql
    ```

2. Asegúrate de que las credenciales en `config.php` sean correctas.

---

## ¿Cómo se mantiene la sesión entre ambos sistemas?

Ambos sistemas usan el mismo `session_name` ('auth_session') y están en el mismo dominio (`localhost`):
- El sistema de autenticación, tras validar el usuario, pone en la sesión `$_SESSION["user_id"]`.
- Al acceder al sistema de ventas, este mide si existe `$_SESSION["user_id"]` antes de mostrar cualquier página.
- Si el usuario no está autenticado, se redirige al login.

Esto funciona porque ambas apps comparten el mismo dominio y session_name: el navegador envía automáticamente la cookie de sesión correspondiente en ambos puertos.

---

## ¿Cómo es la redirección tras login?

- Después de login exitoso en `auth_system/login.php`, simplemente:
  ```php
  header("Location: http://localhost:8000");
  exit;
  ```
- Eso lleva al sistema de ventas, que detectará la sesión activa y mostrará el dashboard.

---

## MVC modular

Cada módulo tiene su propia carpeta con:
- `modelo/` (clases de acceso a datos)
- `controlador/` (lógica de negocio)
- `vista/` (HTML/PHP presentación)

Ejemplo de la URL de productos (listar):
```
http://localhost:8000/modules/productos/controlador/ProductoController.php?action=list
```

---

Esto es todo para iniciar tu proyecto. ¡Puedes expandir CRUDs y módulos según tus necesidades!
