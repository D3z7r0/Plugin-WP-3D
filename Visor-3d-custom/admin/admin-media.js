jQuery(document).ready(function($) {
    let mediaUploader;

    $('#btn-select-3d').on('click', function(e) {
        e.preventDefault();

        // Si el selector ya existe, ábrelo
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // Crear el "Frame" de la biblioteca de medios
        mediaUploader = wp.media({
            title: 'Seleccionar Modelo 3D',
            button: { text: 'Usar este modelo' },
            multiple: false,
            library: {
                // Aunque no podemos filtrar por .glb nativamente de forma fácil,
                // esto abrirá la biblioteca general
                type: '' 
            }
        });

        // Cuando se selecciona un archivo
        mediaUploader.on('select', function() {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            const fileUrl = attachment.url;
            const fileExt = fileUrl.split('.').pop().toLowerCase();

            // Validar extensión
            if (fileExt === 'glb' || fileExt === 'gltf') {
                const shortcode = `[visor_3d url="${fileUrl}"]`;
                $('#input-shortcode').val(shortcode);
                $('#shortcode-result').slideDown();
            } else {
                alert('Por favor, selecciona un archivo válido (.glb o .gltf)');
            }
        });

        mediaUploader.open();
    });

    // Copiar al portapapeles al hacer clic en el input
    $('#input-shortcode').on('click', function() {
        $(this).select();
        document.execCommand('copy');
        alert('Shortcode copiado al portapapeles');
    });
});