<style>
    .et_pb_section_0 .et_pb_row_0, 
    .et_pb_section_0 .et_pb_column_0,
    .et_pb_section_0 .et_pb_code_0,
    .et_pb_section_0 .et_pb_code_inner {
        background-color: transparent !important;
        background: transparent !important;
        background-image: none !important;
        border: none !important;
    }

    .et_pb_section_0 {
        background-color: transparent !important;
    }

    .et_pb_section_video_bg {
        z-index: 0 !important;
    }

    .visor-container {
        z-index: 10 !important;
        background: transparent !important;
    }

    @media (max-width: 767px) {
        .visor-container {
            height: 250px !important;
        }
        
        canvas.canvas-3d {
            height: 250px !important;
        }
    }
</style>

<?php if ( empty($args['url']) ) : ?>
    <div style="background: #f8d7da; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px;">
        ⚠️ Error: No se ha proporcionado una URL para el modelo 3D.
    </div>
<?php else : ?>
    <div class="visor-container" 
         data-model="<?php echo esc_url($args['url']); ?>" 
         data-bg="<?php echo esc_attr($args['color_fondo']); ?>"
         style="width: 100%; height: <?php echo esc_attr($args['altura']); ?>; position: relative; overflow: hidden;">
        <canvas class="canvas-3d" style="width: 100%; height: 100%; display: block;"></canvas>
    </div>
<?php endif; ?>