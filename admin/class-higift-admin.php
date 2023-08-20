<?php
class HI_Gift_Admin {

    public function __construct() {
        // Agregar la pestaña "HI Gift"
        add_filter('woocommerce_product_data_tabs', array($this, 'add_hi_gift_tab'));
        add_action('woocommerce_product_data_panels', array($this, 'hi_gift_tab_content'));
        add_action('woocommerce_process_product_meta', array($this, 'save_hi_gift_fields'));
        add_action('admin_footer', array($this, 'load_hi_gift_fields'));
    }

    // Agregar la pestaña "HI Gift" en la página de edición del producto
    public function add_hi_gift_tab($tabs) {
        $tabs['hi_gift'] = array(
            'label' => __('HI Gift', 'woocommerce'), // Nombre de la pestaña
            'target' => 'hi_gift_options', // ID del contenedor de la pestaña
            'class' => array('show_if_simple', 'show_if_variable'), // Mostrar solo para productos simples y variables
        );
        return $tabs;
    }

// Contenido de la pestaña "HI Gift"
public function hi_gift_tab_content() {
    global $post;

    echo '<div id="hi_gift_options" class="panel woocommerce_options_panel">';

    // Opciones de radio para "Tarjeta solidaria" y "Corona de Caridad"
    echo '<div class="options_group">';
    woocommerce_wp_radio(
        array(
            'id' => 'hi_gift_type',
            'label' => __('Tipo de regalo', 'woocommerce'),
            'options' => array(
                'tarjeta_solidaria' => __('Tarjeta solidaria', 'woocommerce'),
                'corona_de_caridad' => __('Corona de Caridad', 'woocommerce'),
            ),
        )
    );
    echo '</div>';

    // Cajas de texto para mensajes personalizados
    for ($i = 1; $i <= 3; $i++) {
        woocommerce_wp_text_input(
            array(
                'id' => 'hi_gift_message_' . $i,
                'label' => sprintf(__('Mensaje personalizado %d', 'woocommerce'), $i),
                'desc_tip' => true,
                'description' => __('Ingrese el mensaje personalizado.', 'woocommerce'),
            )
        );
    }

    echo '</div>';
}
   
public function save_hi_gift_fields($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['post_type']) && 'product' != $_POST['post_type']) return;

    $hi_gift_type = isset($_POST['hi_gift_type']) ? wc_clean($_POST['hi_gift_type']) : '';
    update_post_meta($post_id, 'hi_gift_type', $hi_gift_type);

    for ($i = 1; $i <= 3; $i++) {
        $hi_gift_message = isset($_POST['hi_gift_message_' . $i]) ? wc_clean($_POST['hi_gift_message_' . $i]) : '';
        update_post_meta($post_id, 'hi_gift_message_' . $i, $hi_gift_message);
    }
}



// Recuperar los valores de la pestaña "HI Gift" y establecerlos en los campos
public function load_hi_gift_fields() {
    global $post;
    if ('product' != $post->post_type) return;

    $hi_gift_type = get_post_meta($post->ID, 'hi_gift_type', true);
    echo '<script type="text/javascript">
        jQuery(document).ready(function($) {
            $("input[name=\'hi_gift_type\'][value=\'' . esc_js($hi_gift_type) . '\']").prop("checked", true);
        });
    </script>';

    for ($i = 1; $i <= 3; $i++) {
        $hi_gift_message = get_post_meta($post->ID, 'hi_gift_message_' . $i, true);
        echo '<script type="text/javascript">
            jQuery(document).ready(function($) {
                $("#hi_gift_message_' . $i . '").val("' . esc_js($hi_gift_message) . '");
            });
        </script>';
    }
}




}
