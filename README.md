# CD Riohacha - Web App de Gestión Logística

Esta es una aplicación web construida con PHP, MySQL y Bootstrap para la gestión logística de CD Riohacha.

## Requisitos Previos

- **XAMPP**, **WAMP**, o **LAMP** stack instalado (Apache, MySQL, PHP 8.0+).
- Navegador web moderno.

## Instalación y Configuración

1. **Clonar/Copiar el Proyecto:**
   Asegúrese de que la carpeta del proyecto esté dentro del directorio raíz de su servidor web (por ejemplo, `htdocs` en XAMPP o `/var/www/html` en Apache).
   
   Ruta sugerida: `C:\xampp\htdocs\CD Riohacha\Web`

2. **Configurar la Base de Datos:**
   - Abra **phpMyAdmin** (usualmente en `http://localhost/phpmyadmin`).
   - Cree una nueva base de datos llamada `cd_riohacha_db`.
   - Importe el archivo SQL de esquema ubicado en `sql/schema.sql`:
     - Seleccione la base de datos `cd_riohacha_db`.
     - Vaya a la pestaña "Importar".
     - Seleccione el archivo `sql/schema.sql` y haga clic en "Continuar".

3. **Configurar Conexión (Opcional):**
   - El archivo de configuración de base de datos está en `config/db.php`.
   - Por defecto está configurado para XAMPP:
     - Host: `localhost`
     - Usuario: `root`
     - Contraseña: `` (vacía)
   - Si su configuración de MySQL es diferente, edite este archivo.

4. **Ejecutar la Aplicación:**
   - Abra su navegador y vaya a: `http://localhost/CD%20Riohacha/Web/`
   - O la ruta correspondiente donde haya colocado los archivos.

## Credenciales de Acceso

**Usuario Administrador por Defecto:**
- **Email:** `admin@cdriohacha.com`
- **Contraseña:** `password`

## Solución de Problemas (Login no funciona)

1. **Base de Datos no importada:** Asegúrese de haber seguido el paso 2 de la instalación e importado `sql/schema.sql`.
2. **Configuración de DB:** Si su MySQL tiene contraseña para el usuario `root`, debe ponerla en `config/db.php`.
3. **URL Rewriting:** La aplicación usa un enrutador simple. Si ve errores 404 al navegar, asegúrese de que la URL base en el navegador coincida con la estructura de carpetas.
4. **Permisos de Sesión:** Asegúrese de que PHP tenga permisos para escribir sesiones (configuración por defecto de XAMPP suele estar bien).

## Estructura del Proyecto

- `config/`: Configuración de base de datos.
- `controllers/`: Lógica de negocio (MVC).
- `models/`: Modelos de datos (opcional en esta versión simple).
- `views/`: Archivos de plantilla HTML/PHP.
  - `layouts/`: Header y Footer comunes.
  - `home/`: Página principal.
  - `auth/`: Login.
  - `dashboard/`: Tablero de KPIs.
  - `admin/`: Panel de administración.
- `assets/`: Archivos estáticos (CSS, JS, Imágenes).
- `sql/`: Scripts de base de datos.
- `index.php`: Enrutador principal.

## Características

- **Inicio:** Carrusel de imágenes, información de la empresa, pilares logísticos.
- **Autenticación:** Login seguro con roles (usuario y admin).
- **Tablero Diario:** Visualización de KPIs logísticos con indicadores de estado.
- **Panel Admin:** Gestión de usuarios, edición de carrusel y contenido.
