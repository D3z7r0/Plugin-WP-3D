# WP Custom 3D Viewer (Three.js) 🚀🧊

Un plugin nativo para WordPress diseñado para renderizar modelos 3D (`.glb`) en tiempo real utilizando **Three.js**. Este plugin está optimizado para sobreponer de forma transparente modelos interactivos sobre elementos multimedia complejos (como fondos de video) evadiendo los bloqueos de renderizado y contextos de apilamiento (Stacking Context) de constructores visuales como Divi.

## ✨ Características Principales

* **Transparencia Nativa (Alpha Channel):** Configuración avanzada del buffer de renderizado de WebGL (`premultipliedAlpha: false`, `setClearColor(0,0)`) para asegurar flotabilidad perfecta sobre videos y fondos dinámicos.
* **Optimización Móvil (OOM Prevention):** Implementación de `IntersectionObserver` para pausar cálculos de GPU cuando el canvas sale de la ventana gráfica (Viewport), y limitador dinámico de `devicePixelRatio` para evitar el colapso de VRAM en dispositivos móviles.
* **Diseño Responsivo Autónomo:** Intercepción de CSS y Media Queries inyectadas (`!important`) para forzar redimensiones elásticas frente a las limitaciones de los constructores visuales.
* **Overwrite de Contextos de Apilamiento:** Aislamiento de capas CSS y reestructuración de `z-index` manual para obligar a WordPress/Divi a respetar la transparencia del `body` hasta la capa del `canvas`.
* **Manipulación de Materiales:** Lógica interna para recorrer las mallas (`meshes`) del modelo 3D y reasignar colores hexadecimales de manera dinámica (ej. branding de logos).
* **Indicador UI Interactivo:** Integración de un prompt visual (SVG 360°) que desaparece automáticamente al detectar el evento `start` del usuario sobre el `OrbitControls`.

## 🛠️ Tecnologías Utilizadas

* **Backend:** PHP 8.x (WordPress Plugin API, Shortcodes).
* **Frontend:** Vanilla JavaScript (ES6), CSS3.
* **Motor 3D:** Three.js (r174) + WebGL.
* **Compatibilidad probada:** Divi Builder, WordPress 6.x.

## 📂 Estructura del Proyecto

```text
visor-3d-custom/
├── visor-3d-custom.php       # Motor principal del plugin y registro de shortcodes
├── admin/
│   └── admin-media.js        # Lógica de integración con la biblioteca de medios de WP
├── js/
│   └── viewer-script.js      # Lógica Core de Three.js (Cámara, Render, Observer)
└── view/
    └── template-3d.php       # Plantilla HTML/CSS (Contenedor WebGL y overrides de CSS)

```

## 🚀 Instalación (Desarrollo / Manual)
*Clona este repositorio dentro de la carpeta de plugins de tu instalación local o servidor:
```text
Bash

cd wp-content/plugins/
git clone [https://github.com/tu-usuario/visor-3d-custom.git](https://github.com/tu-usuario/visor-3d-custom.git)
Ve al panel de administración de WordPress > Plugins.

Busca Visor 3D Custom y haz clic en Activar.

o descargalo y conviertelo en .zip para cargar directo.

```
## 💻 Modo de Uso
El plugin se ejecuta a través de un Shortcode que acepta parámetros dinámicos. Puede ser insertado en módulos de Texto o Código en cualquier constructor visual.

Plaintext

[visor_3d url="[https://tudominio.com/wp-content/uploads/modelo.glb](https://tudominio.com/wp-content/uploads/modelo.glb)" color_fondo="transparent" altura="450px"]
Parámetros:
url (string): Ruta directa al archivo .glb subido en los medios de WordPress.

color_fondo (string): Hexadecimal (ej. #ffffff) o transparent para activar el canal Alfa.

altura (string): Altura base para escritorio (ej. 450px). Nota: El plugin sobrescribe esto automáticamente a 250px en dispositivos móviles (<767px) para proteger el layout.

🧠 Arquitectura y Retos Técnicos
Este proyecto resuelve el clásico "Bug del Canvas 0x0" y el conflicto de renderizado mixto en móviles. Al no utilizar módulos ocultos (display: none) para el diseño responsivo, el script garantiza que el modelo .glb se cargue una única vez en la memoria RAM. Además, las reglas inyectadas evaden el background-color: #fff forzado por los constructores visuales en sus contenedores internos (.et_pb_code_inner), forzando una verdadera transparencia.

👨‍💻 Autor
Yahel Daniel Aguilera Reyes (𝔻𝟛𝟟𝕣𝟘)
Estudiante de Ingeniería en Sistemas Computacionales | Desarrollador Full-Stack
