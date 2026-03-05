<?php
/**
 * Plugin Name: Visor 3D Custom - Estilo WordCamp
 * Description: Plugin modular con template externo y ES Modules.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1. Filtro para subir archivos (Paso 4)
add_filter('upload_mimes', function($mimes) {
    $mimes['gltf'] = 'model/gltf+json';
    $mimes['glb'] = 'model/gltf-binary';
    return $mimes;
});

// 2. Inyectar el Import Map (Paso 6 moderno)
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

// 3. Shortcode Invirtual
add_shortcode('visor_3d_Invirtual', function($atts) {
  $args = shortcode_atts(['url' => 'http://localhost:10019/wp-content/uploads/2026/03/invirtual_logo.glb'], $atts);
  
  // Iniciamos el buffer para capturar el HTML de la plantilla
  ob_start();
  include plugin_dir_path(__FILE__) . 'view/invirtual-3d.php';
  return ob_get_clean();
});
