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
