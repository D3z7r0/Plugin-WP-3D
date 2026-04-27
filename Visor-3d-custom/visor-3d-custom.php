<?php
/**
 * Plugin Name: Visor 3D
 * Description: Sistema profesional de visualización 3D con ES Modules y Shortcodes dinámicos.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1A. Permitir las extensiones en la biblioteca (FALTABA ESTE)
add_filter('upload_mimes', function($mimes) {
    $mimes['gltf'] = 'model/gltf+json';
    $mimes['glb']  = 'model/gltf-binary';
    $mimes['bin']  = 'application/octet-stream'; 
    return $mimes;
});

// 1B. Filtro de subida para forzar la validación 
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
    $filetype = wp_check_filetype( $filename, $mimes );
    $ext = $filetype['ext'];
    if ( in_array( $ext, ['gltf', 'glb'] ) ) {
        $data['ext'] = $ext;
        $data['type'] = ($ext === 'glb') ? 'model/gltf-binary' : 'model/gltf+json';
        $data['proper_filename'] = $filename;
    }
    return $data;
}, 10, 4 );

// 2. Import Map e inyección de scripts
add_action('wp_head', function() {
    ?>
    <script type="importmap">
    {
      "imports": {
        "three": "https://cdn.jsdelivr.net/npm/three@0.174.0/build/three.module.js",
        "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.174.0/examples/jsm/"
      }
    }
    </script>
    <?php
});

// 3. Encolar el JS como Módulo
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('viewer-js', plugins_url('/js/viewer-script.js', __FILE__), array(), '1.1', true);
});

// Filtro para añadir type="module" al script
add_filter('script_loader_tag', function($tag, $handle, $src) {
    if ('viewer-js' !== $handle) return $tag;
    return '<script type="module" src="' . esc_url($src) . '"></script>';
}, 10, 3);

// PARTE 4: Lógica de Administración (Media Library)

// Encolar scripts necesarios para la biblioteca de medios en el admin
add_action('admin_enqueue_scripts', function($hook) {
    if ( 'post.php' != $hook && 'post-new.php' != $hook ) return;

    // Carga las librerías nativas de WP para medios
    wp_enqueue_media();

    // Nuestro script personalizado para manejar el clic
    wp_enqueue_script(
        'visor-admin-js', 
        plugins_url('/admin/admin-media.js', __FILE__), 
        array('jquery'), 
        '1.0', 
        true
    );
});

// Crear un Meta Box (Caja en el editor) para ayudar a generar el shortcode
add_action('add_meta_boxes', function() {
    add_meta_box(
        'visor_helper',
        'Generador de Visor 3D',
        'visor_meta_box_callback',
        ['post', 'page'], // Aparece en Entradas y Páginas
        'side',           // En la barra lateral
        'high'
    );
});

function visor_meta_box_callback() {
    ?>
    <div class="visor-admin-box">
        <p>Selecciona un modelo .glb o .gltf para obtener su shortcode:</p>
        <button type="button" id="btn-select-3d" class="button button-primary">Seleccionar Modelo 3D</button>
        <div id="shortcode-result" style="margin-top:15px; display:none;">
            <p><strong>Copia este shortcode:</strong></p>
            <input type="text" id="input-shortcode" class="widefat" readonly>
        </div>
    </div>
    <?php
}


// 5. Shortcode Dinámico
add_shortcode('visor_3d', function($atts) {
    $args = shortcode_atts([
        'url' => '', // Si no hay URL, el JS no cargará nada
        'color_fondo' => '#9C9C9C',
        'altura' => '500px'
    ], $atts);

    ob_start();
    include plugin_dir_path(__FILE__) . 'view/template-3d.php';
    return ob_get_clean();
});


/**
 * SECCIÓN DE DOCUMENTACIÓN PROFESIONAL
 */

// 1. Registrar el Menú y el Submenú
add_action('admin_menu', function() {
    add_menu_page(
        'Documentación Visor 3D',   // Título de la pestaña del navegador
        'Visor 3D',                // Nombre que aparece en la barra lateral
        'manage_options',          // Solo para administradores
        'visor-3d-docs',           // El identificador único (Slug)
        'visor_3d_docs_page',      // La función que pinta la tabla de comandos
        'dashicons-3d',            // El icono del cubo
        110                        // Posición al final del menú
    );
});

// 2. Función de la Página de Documentación
function visor_3d_docs_page() {
    ?>
    <div class="wrap" style="max-width: 900px;">
        <h1><span class="dashicons dashicons-book-alt" style="font-size: 30px; width: 30px; height: 30px;"></span> Documentación del Visor 3D Custom</h1>
        <p class="description">Guía técnica para la implementación y personalización de modelos interactivos.</p>
        
        <hr>

        <h2 class="title">Uso Rápido</h2>
        <p>Para desplegar el visor en cualquier página o entrada (incluyendo Divi), utiliza el siguiente shortcode:</p>
        <code style="display:block; padding: 15px; background: #fff; border-left: 4px solid #2271b1; font-size: 14px;">
            [visor_3d url="URL_DEL_MODELO" color_fondo="#9C9C9C" altura="500px"]
        </code>

        <h2 class="title">API de JavaScript (Comandos de Consola)</h2>
        <p>Estos comandos están disponibles globalmente una vez que el visor se ha inicializado:</p>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 35%;">Comando</th>
                    <th>Descripción</th>
                    <th>Ejemplo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>window.cambiarColorPieza(name, hex)</code></td>
                    <td>Busca una malla por su nombre en el modelo y cambia su color.</td>
                    <td><code>cambiarColorPieza('logo', '#206bb1')</code></td>
                </tr>
                <tr>
                    <td><code>initViewer(container)</code></td>
                    <td>Inicializa el motor Three.js en los elementos con clase <code>.visor-container</code>.</td>
                    <td>Automático al cargar</td>
                </tr>
            </tbody>
        </table>

        <h2 class="title">🛠 Atributos del Shortcode</h2>
        <p>Personaliza cada instancia del visor de forma independiente:</p>
        <ul class="ul-disc">
            <li><strong>url:</strong> (Obligatorio) El enlace directo al archivo .glb o .gltf.</li>
            <li><strong>color_fondo:</strong> Color hexadecimal para el fondo del escenario.</li>
            <li><strong>altura:</strong> Define el tamaño vertical del lienzo (ej: 400px, 80vh).</li>
        </ul>

        <h2 class="title">Personalización Automática (Scripting)</h2>
        <p>El visor incluye una lógica de <strong>auto-pintado</strong> al cargar el modelo. Esta característica asegura que las piezas clave mantengan la identidad visual de la marca sin intervención manual:</p>

        <div style="background: #f9f9f9; border: 1px dashed #ccc; padding: 15px; border-radius: 5px;">
            <p><strong>Regla de Negocio Actual:</strong></p>
            <ul style="margin: 0;">
                <li><strong>Detección:</strong> El script escanea todos los objetos (Meshes) del archivo 3D.</li>
                <li><strong>Filtro:</strong> Si el nombre de la pieza comienza con la cadena <code>'logo'</code> (ej: <em>logo_principal</em>, <em>logo_bordes</em>).</li>
                <li><strong>Acción:</strong> Se aplica automáticamente el color azul corporativo <code>#206bb1</code>.</li>
            </ul>
        </div>

        <p style="margin-top:10px;">
            <span class="dashicons dashicons-info" style="color: #2271b1;"></span> 
            <em>Nota: Si deseas cambiar este color después de la carga, aún puedes usar el comando <code>cambiarColorPieza()</code> desde la consola.</em>
        </p>

        <div class="notice notice-info is-dismissible" style="margin-top: 30px;">
            <p><strong>Tip de Ingeniero:</strong> Recuerda que los nombres de las piezas (<code>name</code>) son sensibles a mayúsculas y minúsculas. Puedes ver los nombres disponibles en la consola del navegador al cargar el modelo.</p>
        </div>

        <p style="margin-top: 40px; text-align: center; color: #999;">
            Desarrollado por <strong>Daniel Aguilera</strong> | Versión 1.1 - 2026 | GitHub: D3z7r0
        </p>
    </div>
    
    <style>
        .title { margin-top: 30px !important; color: #23282d; }
        code { background: #eaeaea; padding: 2px 5px; border-radius: 3px; font-weight: bold; }
    </style>
    <?php
}

