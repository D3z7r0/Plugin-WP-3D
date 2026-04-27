import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

// Función para inicializar cada visor encontrado en la página
function initViewer(container) {
    const modelUrl = container.dataset.model;
    const bgColor = container.dataset.bg;
    const canvas = container.querySelector('.canvas-3d');
    
    let model = null;

    // Escena
    const scene = new THREE.Scene();

    if (bgColor === 'transparent' || !bgColor) {
        scene.background = null; // OBLIGATORIO para transparencia
    } else {
        scene.background = new THREE.Color(bgColor);
    }

    // Cámara
    const camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.set(0, 0, 1.1);

    // Renderer
    const renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true, alpha: true, premultipliedAlpha: false});
    if (bgColor === 'transparent') {
        renderer.setClearColor(0x000000, 0); 
        renderer.setClearAlpha(0);
    }

    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    
    // Luces
    scene.add(new THREE.AmbientLight(0xffffff, 1.5));
    const dirLight = new THREE.DirectionalLight(0xffffff, 2);
    dirLight.position.set(5, 5, 5);
    scene.add(dirLight);

    // Loader
    const loader = new GLTFLoader();
    loader.load(modelUrl, (gltf) => {
        model = gltf.scene;
        scene.add(model);

        // Aplicar color azul automáticamente al cargar
        model.traverse((child) => {
            if (child.isMesh) {                
                // Si el nombre empieza con "logo", lo ponemos azul
                if (child.name.startsWith('logo')) {
                    child.material.color.set('#206bb1');
                }
            }
        });
    }, undefined, (err) => console.error("Error cargando:", err));

    // Controles
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    let isVisible = true;

    // 1. Crear el observador
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            isVisible = entry.isIntersecting; // true si está en pantalla, false si no
        });
    }, { threshold: 0.1 });

    // 2. Observar el contenedor
    observer.observe(container);

    // 3. Modificar la función animate
    function animate(time) {
        requestAnimationFrame(animate);

        // Si no está visible, detenemos los cálculos y el render para salvar la GPU
        if (!isVisible) return; 

        if (model) {
            model.rotation.y = time / 2600; // Si tenías autoRotate
        }
        controls.update();
        renderer.render(scene, camera);
    }

    // Resize inteligente
    window.addEventListener('resize', () => {
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });

    // Función global para este modelo específico
    window.cambiarColorPieza = function(piezaName, hex) {
        if (!model) return;
        model.traverse(child => {
            if (child.isMesh && child.name === piezaName) {
                child.material.color.set(hex);
            }
        });
    }

    animate();
}

// Ejecutar al cargar la página para todos los contenedores .visor-container
document.querySelectorAll('.visor-container').forEach(container => {
    initViewer(container);
});