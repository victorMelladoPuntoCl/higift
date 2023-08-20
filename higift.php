<?php
/**
 * Plugin Name: higift
 * Plugin URI: https://victormellado.cl
 * Description: Plugin para vender tarjetas solidarias y coronas de caridad para "Hogar Italiano".
 * Version: 1.0
 * Author: Victor Mellado / ChatGPT 4
 * Author URI: https://victormellado.cl
 */

 function enqueue_higift_styles() {
    wp_enqueue_style('higift-css', plugin_dir_url(__FILE__) . 'css/higift.css');
}

add_action('wp_enqueue_scripts', 'enqueue_higift_styles');


function enqueue_higift_scripts() {
    wp_enqueue_script('higift-js', plugin_dir_url(__FILE__) . 'js/higift-preview.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'enqueue_higift_scripts');






// Incluir la clase HI_Gift_Admin
include_once plugin_dir_path(__FILE__) . 'admin/class-higift-admin.php';

// Instanciar la clase HI_Gift_Admin
new HI_Gift_Admin();

function hi_gift_choose_template($template) {
    global $post;

    if (is_singular('product')) {
        $hi_gift_type = get_post_meta($post->ID, 'hi_gift_type', true);

        if ($hi_gift_type == 'tarjeta_solidaria' || $hi_gift_type == 'corona_de_caridad') {
            $template = plugin_dir_path(__FILE__) . 'templates/single-product-higift.php';
        }
    }

    return $template;
}

add_filter('template_include', 'hi_gift_choose_template', 99);
