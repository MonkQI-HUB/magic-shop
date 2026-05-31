<!--
=== SYNC IMPACT REPORT ===
- Version Change: [CONSTITUTION_VERSION] -> 1.0.0
- Bump Rationale: Initial definition of project principles focusing on code quality, MVC, OOP, and Clean Architecture for Magic Shop Cosmetics.
- List of Modified Principles:
  * [PRINCIPLE_1_NAME] -> I. Arquitectura Limpia y Separación de Responsabilidades (Clean Architecture & SOC)
  * [PRINCIPLE_2_NAME] -> II. Modelo-Vista-Controlador (MVC) Estricto
  * [PRINCIPLE_3_NAME] -> III. Programación Orientada a Objetos (POO) y SOLID (NON-NEGOTIABLE)
  * [PRINCIPLE_4_NAME] -> IV. Diseño UI/UX Consistente y Modular (Pixel-Perfect con Stitch)
  * [PRINCIPLE_5_NAME] -> V. Validaciones Robustas y Gestión Estética de Alertas
- Added Sections:
  * Restricciones Tecnológicas y de Persistencia
  * Ciclo de Desarrollo y Control de Calidad
- Removed Sections: None
- Templates requiring updates:
  * .specify/templates/plan-template.md (✅ updated)
  * .specify/templates/spec-template.md (✅ updated)
  * .specify/templates/tasks-template.md (✅ updated)
- Follow-up TODOs: None
==========================
-->
# Magic Shop Cosmetics Constitution

## Core Principles

### I. Arquitectura Limpia y Separación de Responsabilidades (Clean Architecture & SOC)
Toda la lógica de la aplicación debe estar estructurada bajo una arquitectura limpia con una estricta separación de responsabilidades. Se prohíbe mezclar lógica de negocio directamente en las vistas o en la persistencia. Las capas de negocio (entidades, casos de uso), adaptadores de interfaz (controladores, presentadores) y frameworks/drivers (CodeIgniter 4, bases de datos) deben mantenerse desacoplados y con dependencias apuntando únicamente hacia el interior.
- **Regla no negociable**: Los controladores solo dirigen el flujo y delegan la lógica a los modelos u objetos de negocio correspondientes.
- **Justificación**: Facilita la mantenibilidad, escalabilidad y testabilidad independiente del software sin depender de frameworks específicos.

### II. Modelo-Vista-Controlador (MVC) Estricto
El patrón de diseño arquitectónico es estrictamente MVC usando las facilidades nativas de CodeIgniter 4.
- **Vistas**: Exclusivas para renderizado HTML/CSS estructurado de Stitch y manejo de interfaz de usuario. No deben realizar consultas directas a la base de datos ni contener lógica de negocio compleja.
- **Controladores**: Reciben peticiones HTTP, coordinan flujos, invocan modelos y retornan vistas. Deben mantenerse "delgados" (Thin Controllers).
- **Modelos**: Encapsulan la persistencia y la interacción directa con la base de datos MySQL de forma segura.
- **Justificación**: Una estructura estandarizada que evita el código espagueti y alinea el desarrollo con las mejores prácticas del framework.

### III. Programación Orientada a Objetos (POO) y SOLID (NON-NEGOTIABLE)
Todo el desarrollo debe regirse bajo el paradigma de Programación Orientada a Objetos (POO) y cumplir con los principios SOLID.
- **Abstracción y Encapsulamiento**: Las propiedades de las clases deben protegerse adecuadamente y exponerse mediante getters y setters específicos cuando sea necesario.
- **Responsabilidad Única (SRP)**: Cada clase, controlador o modelo debe tener una única razón para cambiar.
- **Inyección de Dependencias**: Evitar el acoplamiento rígido instanciando objetos dentro de otros de forma directa; preferir el uso de contenedores de servicios o inyección directa en constructores.
- **Justificación**: Garantiza un código robusto, flexible ante cambios y fácilmente reutilizable.

### IV. Diseño UI/UX Consistente y Modular (Pixel-Perfect con Stitch)
La interfaz de usuario debe replicar con exactitud el diseño validado en Google Stitch ("Design DNA").
- **Arquitectura CSS Escalable y Modular**: Se prohíbe el uso de estilos inline o archivos monolíticos. El CSS debe organizarse utilizando un enfoque modular, superando el mínimo requerido de 5 hojas de estilo base. La estructura en `public/css/` debe separar claramente el dominio público del dominio administrativo, incluyendo (pero no limitándose a):
  - **Core**: `global.css` (tokens de diseño, paleta negro/dorado), `layout.css`, `alerts.css` y `forms.css`.
  - **E-Commerce**: `catalog.css`, `checkout.css`.
  - **Administrativo**: `admin-dashboard.css`, `admin-tables.css`.
- **Estructura HTML Semántica**: Utilizar etiquetas HTML5 correctas (`<h1>`, `<img>`, `<table>`, `<section>`) para la estructura de la aplicación.
- **Justificación**: Garantiza una experiencia de usuario premium, facilita el mantenimiento del código, optimiza el rendimiento separando la carga del panel de control de la tienda pública, y asegura una integración fluida con los diseños exportados desde Stitch.

### V. Validaciones Robustas y Gestión Estética de Alertas
La integridad de los datos en Magic Shop debe asegurarse en múltiples capas antes de persistirse.
- **JavaScript**: Validaciones del lado del cliente antes de enviar cualquier formulario al backend.
- **SweetAlert2**: Uso obligatorio de SweetAlert2 para interacciones estéticas y ventanas modales de confirmación en acciones críticas (ej. "¿Seguro que deseas enviar tus datos?").
- **Alerts nativos**: Solo para notificaciones muy básicas del sistema o depuración.
- **Justificación**: Minimiza errores en el backend y garantiza una retroalimentación altamente usable e interactiva para el usuario.

## Restricciones Tecnológicas y de Persistencia
- **Lenguaje y Entorno**: PHP 8.x, JavaScript moderno (ES6+), HTML5 y CSS3 nativo.
- **Framework y Base de Datos**: CodeIgniter 4 (CI4) y base de datos relacional MySQL.
- **Seguridad y Persistencia**: Conexiones exclusivas a través del archivo de configuración `.env` y el ORM/Query Builder nativo de CI4 para mitigar ataques de inyección SQL. Todo manejo de contraseñas de usuarios debe encriptarse usando algoritmos seguros (ej. `password_hash`).
- **Referencia Estricta del Esquema de Datos**: El archivo `db/db.sql` en el proyecto es el único plano autorizado de la base de datos. Se prohíbe la alucinación, inferencia o invención de nombres de tablas, columnas o relaciones por parte del agente. Toda lógica de modelos en CodeIgniter 4 debe mapearse estrictamente contra la estructura definida en este archivo.
## Ciclo de Desarrollo y Control de Calidad
- **Validaciones Pre-Commit**: Verificación de sintaxis de PHP y cumplimiento de estándares de codificación (PSR-12).
- **Flujo de Ramas (Git)**: Uso obligatorio de ramas de características (feature branches) con la nomenclatura definida en el proyecto antes de integrar cambios en la rama principal.
- **Revisiones de Arquitectura**: Todo cambio debe alinearse con la arquitectura MVC/POO descrita en esta constitución y validarse contra la especificación (`spec.md`).

## Governance
1. Esta constitución es la norma suprema del proyecto Magic Shop Cosmetics y prevalece sobre cualquier decisión ad-hoc.
2. Cualquier modificación o enmienda a estos principios requerirá una propuesta formal de cambio, aprobación de los responsables y un incremento controlado en la versión de la constitución.
3. Todas las tareas de desarrollo deben someterse a revisiones automatizadas y manuales para garantizar el cumplimiento de los principios de Clean Architecture y la separación modular de CSS descrita.
4. Desarrollo Guiado por especificación: Use `AGENTS.md` y `spec.md` para guiar el desarrollo continuo del sistema en tiempo de ejecución.

**Version**: 1.0.0 | **Ratified**: 2026-05-30 | **Last Amended**: 2026-05-30
