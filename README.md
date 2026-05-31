# Magic Shop Cosmetics 🌟

**Magic Shop Cosmetics** es una plataforma web premium de comercio electrónico especializada en la venta de cosméticos de alta eficacia y cuidado personal de lujo. Con un enfoque estético editorial y una arquitectura interactiva modular, ofrece una experiencia de usuario deslumbrante tanto para clientes en el catálogo público como para administradores en el panel de control.

---

## 🚀 Características Clave

### 💎 Diseño Premium de Vanguardia
* **Estética Luxury:** Paleta cromática en negro, blanco y acentos dorados que evocan exclusividad y elegancia.
* **Experiencia de Usuario (UX/UI):** Diseñado inicialmente en **Google Stitch** y convertido a código pixel-perfect con micro-animaciones en tarjetas, botones y modales.

### 📱 Experiencia Móvil de Primer Nivel
* **Menú Hamburguesa Glassmorphic:** Menú interactivo flotante en móviles con efecto de vidrio esmerilado (`backdrop-filter: blur(20px);`), fondo translúcido y sutiles bordes dorados.
* **Tablas en Tarjetas Responsivas:** La gestión de catálogo y pedidos en el panel de administración se reorganiza dinámicamente en tarjetas responsivas y legibles en cualquier smartphone.

### ⚙️ Funcionalidades del E-commerce
* **Gestor de Catálogo Físico:** Los administradores pueden añadir y editar cosméticos subiendo imágenes directamente desde su computadora a la carpeta pública del servidor, con eliminación inteligente de archivos obsoletos para no malgastar espacio en disco.
* **Control de Pedidos Interactivo:** Consulta y modificación del estado de despachos en tiempo real mediante solicitudes asíncronas seguras (Fetch/AJAX) y alertas estéticas con **SweetAlert2**.
* **Persistencia en la Nube:** Configurado con persistencia a base de datos de producción externa en **Railway** mediante un resolvedor robusto de URLs absolutas que es compatible con cualquier subdirectorio local en XAMPP.

---

## 🛠️ Stack Tecnológico

* **Backend:** PHP 8.x / CodeIgniter 4 (Framework MVC robusto).
* **Base de Datos:** MySQL / MariaDB (Alojada en **Railway**).
* **Frontend:** HTML5 semántico, CSS3 modular (5 hojas de estilo independientes), JavaScript (ES6+).
* **Alertas e Interacciones:** SweetAlert2.

---

## 📁 Estructura de Hojas de Estilo CSS

El sistema cuenta con un diseño modular e independiente organizado en `public/css/`:
1. **`global.css`:** Contiene la definición de variables CSS, tokens de diseño y la paleta de colores corporativos negro/dorado.
2. **`layout.css`:** Define la estructura de componentes globales, header responsivo con hamburguesa, tarjetas del dashboard y comportamiento de tablas-tarjetas responsivas.
3. **`forms.css`:** Estilos para inputs, validaciones, leyendas de ayuda y adaptabilidad responsiva de los formularios de registro y checkout.
4. **`catalog.css`:** Animaciones, transformaciones y grids flexibles para el catálogo público y tarjetas de productos.
5. **`alerts.css`:** Ajustes y personalizaciones exclusivas de integración visual con SweetAlert2.

---

## 💻 Instalación y Configuración Local

### Requisitos Previos
* PHP 8.2 o superior (con extensiones `intl`, `mbstring`, `mysqli` y `mysqlnd` habilitadas en tu `php.ini`).
* Apache (XAMPP / WampServer).
* Composer instalado.

### Pasos de Configuración

1. **Clonar e Inicializar el Proyecto**:
   Coloca el proyecto en tu directorio de servidor web (ej. `d:/xammp/htdocs/magic-shop/`).
   ```bash
   composer install
   ```

2. **Configurar el Archivo de Entorno (`.env`)**:
   El proyecto ya viene configurado para enlazarse con la base de datos MySQL en producción en **Railway**. Si deseas editar las credenciales, edita tu archivo [.env](file:///d:/xammp/htdocs/magic-shop/.env):
   ```ini
   database.default.hostname = zephyr.proxy.rlwy.net
   database.default.database = railway
   database.default.username = root
   database.default.password = YekotZfGRrjNeTRGNBSRkSKOtldjxYrP
   database.default.DBDriver = MySQLi
   database.default.port = 40101
   ```

3. **Ejecutar en tu Servidor Local**:
   Asegúrate de que Apache esté corriendo en XAMPP. Accede desde tu navegador web a la dirección del subdirectorio:
   `http://localhost/magic-shop/public/`

---

## 🛡️ Estructura del Repositorio de Git
Hemos optimizado el archivo [.gitignore](file:///d:/xammp/htdocs/magic-shop/.gitignore) para que mantengas tu repositorio limpio de archivos de desarrollo e infraestructura irrelevante. Quedan excluidos:
* El directorio `/vendor` de dependencias de Composer.
* La variable de configuración local `.env`.
* Las carpetas y archivos internos del editor (`.vscode/`, `.idea/`).
* Archivos temporales del motor Spec Kit (`.agents/`, `.specify/`, `specs/`).
* Fotos de prueba cargadas físicamente por administradores localmente (`public/uploads/productos/*`).

---

## 👥 Roles de Usuario por Defecto (Base de Datos)

El sistema cuenta con un sistema de autenticación seguro encriptado con **Bcrypt** (`password_hash`):

1. **Administrador**:
   * **Correo:** `admin@test.com`
   * **Contraseña:** `admin` (Hasheada de forma segura para permitir acceso directo al Dashboard).
2. **Cliente**:
   * **Correo:** `juan@test.com`
   * **Contraseña:** `12345678` (Usa este usuario para simular compras rápidas en el carrito de compras).
