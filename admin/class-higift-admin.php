<?php
class higift_Admin {

    public function __construct() {
        // Agregar la pestaña "HI Gift"
        add_filter('woocommerce_product_data_tabs', array($this, 'add_higift_tab'));
        add_action('woocommerce_product_data_panels', array($this, 'higift_tab_content'));
        add_action('woocommerce_process_product_meta', array($this, 'save_higift_fields'));
        add_action('woocommerce_product_options_general_product_data', array($this, 'load_higift_fields'));
    }

    // Agregar la pestaña "HI Gift" en la página de edición del producto
    public function add_higift_tab($tabs) {
        $tabs['higift'] = array(
            'label' => __('HI Gift', 'woocommerce'), // Nombre de la pestaña
            'target' => 'higift_options', // ID del contenedor de la pestaña
            'class' => array('show_if_simple', 'show_if_variable'), // Mostrar solo para productos simples y variables
        );
        return $tabs;
    }

// Contenido de la pestaña "HI Gift"
public function higift_tab_content() {
    global $post;

    echo '<div id="higift_options" class="panel woocommerce_options_panel">';

    // Opciones de radio para "Tarjeta solidaria" y "Corona de Caridad"
    echo '<div class="options_group">';
    woocommerce_wp_radio(
        array(
            'id' => 'higift_type',
            'label' => __('Tipo de regalo', 'woocommerce'),
            'options' => array(
                'tarjeta_solidaria' => __('Tarjeta solidaria', 'woocommerce'),
                'corona_de_caridad' => __('Corona de Caridad', 'woocommerce'),
            ),
        )
    );
    echo '</div>';

// Cajas de textarea para mensajes personalizados

?>
    <script>
        jQuery(document).ready(function($) {
    $('textarea[id^="higift_message_"]').attr('maxlength', 200).css('height', '180px');
});
    </script>

<?php

for ($i = 1; $i <= 3; $i++) {
    woocommerce_wp_textarea_input(
        array(
            'id' => 'higift_message_' . $i,
            'label' => sprintf(__('Mensaje personalizado %d', 'woocommerce'), $i),
            'desc_tip' => true,
            'description' => __('Ingrese el mensaje personalizado.', 'woocommerce'),
        )
    );
}

    echo '</div>';
}


/*Guardar los datos como metadatos del producto */

public function save_higift_fields($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['post_type']) && 'product' != $_POST['post_type']) return;

    /*Tipo: corona o tarjeta */
    $higift_type = isset($_POST['higift_type']) ? wc_clean($_POST['higift_type']) : '';
    update_post_meta($post_id, 'higift_type', $higift_type);

    /*3 mensajes personalizados */
    for ($i = 1; $i <= 3; $i++) {
        $higift_message = isset($_POST['higift_message_' . $i]) ? wc_clean($_POST['higift_message_' . $i]) : '';
        update_post_meta($post_id, 'higift_message_' . $i, $higift_message);
    }
}



// Recuperar los valores de la pestaña "HI Gift" y establecerlos en los campos

public function load_higift_fields() {

    global $post;
    if ('product' != $post->post_type) return;

    /* Recuperar tipo y poblar con js */
    $higift_type = get_post_meta($post->ID, 'higift_type', true);
    echo '<script type="text/javascript">
        jQuery(document).ready(function($) {
            $("input[name=\'higift_type\'][value=\'' . esc_js($higift_type) . '\']").prop("checked", true);
        });
    </script>';

    /* Recuperar mensajes y poblar con js */
    for ($i = 1; $i <= 3; $i++) {
        $higift_message = get_post_meta($post->ID, 'higift_message_' . $i, true);
        echo '<script type="text/javascript">
            jQuery(document).ready(function($) {
                $("#higift_message_' . $i . '").val("' . esc_js($higift_message) . '");
            });
        </script>';
    }
}

}
