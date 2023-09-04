<?php
/**
 * Plugin Name: higift
 * Plugin URI: https://victormellado.cl
 * Description: Plugin para vender tarjetas solidarias y coronas de caridad para "Hogar Italiano".
 * Version: 1.0
 * Author: Victor Mellado / ChatGPT 
 * Author URI: https://victormellado.cl
 */


/*Chequeo de prerrequisitos */
 register_activation_hook(__FILE__, 'my_plugin_activation_check');

 function my_plugin_activation_check(){
     if ( ! class_exists('WPCleverWoonp') ) {
         deactivate_plugins(plugin_basename(__FILE__));  // Desactiva mi plugin
         wp_die(__('Por favor instala y activa WPC Name Your Price, es requerido para que Higift funcione.', 'textdomain'));
     }
 }
 add_action('admin_notices', 'show_admin_notice_for_required_plugin');

 /*Mostrar advertencias si faltan plugins. */
function show_admin_notice_for_required_plugin(){
    if (! class_exists('WPCleverWoonp')) {
        ?>
        <div class="notice notice-error">
            <p><?php _e('Por favor instala y activa WPC Name Your Price, es requerido para que  Higift plugin funcione.', 'textdomain'); ?></p>
        </div>
        <?php
    }
}



 function enqueue_higift_styles() {
    wp_enqueue_style('higift-css', plugin_dir_url(__FILE__) . 'css/higift.css');
    wp_enqueue_style('higift-card-vertical-css', plugin_dir_url(__FILE__) . 'css/higift-card-vertical.css');
}

add_action('wp_enqueue_scripts', 'enqueue_higift_styles');


//ADMIN ---------
// Incluir la clase higift_Admin
include_once plugin_dir_path(__FILE__) . 'admin/class-higift-admin.php';

// Instanciar la clase higift_Admin
new higift_Admin();

//FRONTEND PRODUCTO -----------
//Aplicar el template incluido en el plugin si el producto está marcado como corona de caridad o tarjeta solidaria.
function higift_choose_template($template) {
    global $post;

    if (is_singular('product')) {
        $higift_type = get_post_meta($post->ID, 'higift_type', true);

        if ($higift_type == 'tarjeta_solidaria' || $higift_type == 'corona_de_caridad') {
            $template = plugin_dir_path(__FILE__) . 'single-product-higift.php';
        }
    }

    return $template;
}

add_filter('template_include', 'higift_choose_template', 99);


//-- CHECKOUT (antes de pagar)
/*Configuración de la página de checkout */
include_once plugin_dir_path(__FILE__) . 'inc/higift-checkout.php';


//  Hooks del order-received
include_once plugin_dir_path(__FILE__) . 'inc/higift-order-received.php';


