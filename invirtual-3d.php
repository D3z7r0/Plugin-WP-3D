<?php
/**
 * Vista del Visor 3D
 * Aquí tienes acceso a $args['url'] si se pasas en el shortcode
 */
?>

<div id="escenario-3d" style="width: 100%; height: 500px; background: #9C9C9C;">
    <canvas id="canvas-invirtual-logo"></canvas>
</div>

<script type="module">
    import * as THREE from 'three';
    import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
    import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
    //Var global logo
    let logoInvirtual = null;

    // 1. Configuración básica
    const contenedor = document.getElementById('escenario-3d');
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x9C9C9C);

    const camera = new THREE.PerspectiveCamera(75, contenedor.clientWidth / contenedor.clientHeight, 0.1, 1000);
    //camera.position.set(15, 55, 8);  //x , y , z
    camera.position.set(0, 0, 1.1);  //x , y , z


    const renderer = new THREE.WebGLRenderer({ 
        canvas: document.getElementById('canvas-invirtual-logo'),
        antialias: true 
    });
    renderer.setSize(contenedor.clientWidth, contenedor.clientHeight);

    // 2. Luces (Importante para ver la katana)
    const light = new THREE.AmbientLight(0xffffff, 1);
    scene.add(light);

    const dirLight = new THREE.DirectionalLight(0xffffff, 2);
    dirLight.position.set(5, 5, 5);
    scene.add(dirLight);


    // 3. Cargar el modelo (Paso 7 real)
    const loader = new GLTFLoader();
    const urlModelo = '<?php echo esc_url($args['url']); ?>'; 

    loader.load(urlModelo, (gltf) => {
        logoInvirtual = gltf.scene; // Aqui manda la direccion de que se cargo
        //Mapear sus objetos
        logoInvirtual.traverse((child) => {
            if (child.isMesh) console.log("Pieza : ", child.name);
        });
        
        scene.add(gltf.scene);
        console.log("Logo Invirtual cargado!");
        }, undefined, (error) => {
        console.error("Error cargando el modelo:", error);
    });

    // -- ANIMACION DE ROTACION -- 
    function animate(time) {
    requestAnimationFrame(animate);

    // Verificamos que la katana ya haya cargado antes de rotarla, LA VAR ES LA GLOBAL
    if (logoInvirtual) {
        // La rotación se mide en Radianes ($2\pi$ = 360°)
        // Dividir el tiempo ayuda a controlar la velocidad
        logoInvirtual.rotation.y = time / 2600;  
    }

    if (controls) controls.update(); // Actualizar OrbitControls
        renderer.render(scene, camera);
    }

    // Iniciamos el ciclo
    requestAnimationFrame(animate);
    const controls = new OrbitControls(camera, renderer.domElement);


    // -- FUNCIONES ESPECIALES DE BOTONES, cambiar color --
    window.cambiarColorKatana = function(nombrePieza, nuevoColorHex) {
        if (!logoInvirtual) return;

        logoInvirtual.traverse((child) => {
            if (child.isMesh && child.name === nombrePieza) {
                // Cambiamos el color (Three.js usa objetos Color)
                child.material.color.set(nuevoColorHex);

            }
        });
    };

    
</script>
