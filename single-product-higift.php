<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit; /*Por seguridad*/

global $product;
global $higift_type;


global $higift_message_1;
global $higift_message_2;
global $higift_message_3;



$product = wc_get_product(get_the_ID());
$higift_type = get_post_meta($post->ID, 'higift_type', true);

$higift_message_1 = get_post_meta($post->ID, 'higift_message_1', true);
$higift_message_2 = get_post_meta($post->ID, 'higift_message_2', true);
$higift_message_3 = get_post_meta($post->ID, 'higift_message_3', true);

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

function enqueue_higift_scripts() {
    wp_enqueue_script('higift-js', plugin_dir_url(__FILE__) . 'js/higift-preview.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'enqueue_higift_scripts');

get_header(); // Incluir el archivo header.php de tu tema
?>

<div id="higift-wrapper">
    <!-- Columna Izquierda -->


    <div id="higift-left">
        <div id="higift-left-container">


            <?php
            /** Desactivar el hook que muestra las imagnees del producto por default.
             * 
             * Hook: woocommerce_before_single_product_summary.
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            /*do_action( 'woocommerce_before_single_product_summary' );*/

            ?>


            <div class="summary entry-summary">

                <?php


                // Añadir campos personalizados antes del botón "Añadir al carrito"
                add_action('woocommerce_before_add_to_cart_button', 'add_custom_fields_to_add_to_cart_form');

                function add_custom_fields_to_add_to_cart_form()
                {

                    /* Campos personalizados del producto, configurado su valor en el backend */
                    global $product;
                    global $higift_type;
                    global $higift_message_1;
                    global $higift_message_2;
                    global $higift_message_3;

                ?>


                        <!-- Paso 3: Escoge un diseño (solo para productos variables) -->
                        <?php if ($product->is_type('variable')) : ?>
                        <style></style>
                        <h2>Escoge un diseño:</h2>
                        <div class="higift-designs">

                            <?php foreach ($product->get_available_variations() as $variation) : ?>
                                <div class="higift-design variant-box">
                                    <img src="<?php echo $variation['image']['url']; ?>" alt="<?php echo $variation['image']['alt']; ?>" data-variant-id="<?php echo $variation['variation_id']; ?>" data-variant-name="<?php echo $variation['attributes']['attribute_diseno']; ?>">
                                </div>
                            <?php endforeach; ?>

                        </div>

                        

                        <?php endif;
                        /*echo(HIGIFT_PLUGIN_DIR2 . DIRECTORY_SEPARATOR. 'inc'. DIRECTORY_SEPARATOR .'tcpdf'. DIRECTORY_SEPARATOR .'tcpdf.php');*/
                        ?>

                    <!-- PASO1 : DATOS DEL DESTINATARIO  -------------------------------------------------------->
                    
                    <h2>Contenido y datos de la <?php echo $higift_type == 'corona_de_caridad' ? 'corona de caridad' : 'tarjeta solidaria'; ?></h2>

                        <h3>Datos para el envío de la tarjeta. </h3>
                        <label>Deudo o familia a quien se envía:</label>
                        <input type="text" name="higift_to_name" required>

                        <label>Email al que se enviará la tarjeta:</label>
                        <input type="email" name="higift_to_email" required>
                   

                    <!-- Paso 2: Contenido de la Tarjeta/Corona -->


                    <?php if ($higift_type == 'corona_de_caridad') : ?>
                        <label>Nombre del difunto:</label>
                        <input type="text" name="higift_other_name">
                    <?php endif; ?>

                    <label>Mensaje (Hasta 200 caracteres):</label>
                    <!--<input type="text" name="higift_message" maxlength="200" required class="largo">-->
                    <textarea name="higift_message" rows="4" required class="largo" maxlength="200"></textarea>

                    <p>
                        <label>Puedes elegir un mensaje predefinido y editarlo a tu gusto:</label>
                        <select id="higift_predefined_messages" name="higift_predefined_message">
                            <option value="">Selecciona un mensaje</option>

                            <?php
                            /*Generar las opciones del combobox */
                            echo '<option value="' . esc_attr($higift_message_1) . '">' . esc_html($higift_message_1) . '</option>';
                            echo '<option value="' . esc_attr($higift_message_2) . '">' . esc_html($higift_message_2) . '</option>';
                            echo '<option value="' . esc_attr($higift_message_3) . '">' . esc_html($higift_message_3) . '</option>';
                            ?>
                        </select>
                    </p>

                    <label>Nombre del remitente:</label>
                    <input type="text" name="higift_sender_name" maxlength="20" required>
                    <label>Apellido del remitente:</label>
                    <input type="text" name="higift_sender_lastname" maxlength="20" required>

                    <input type="hidden" name="higift_type" value="<?php echo $higift_type; ?>">

                
                
                <?php    
                } /*cierra el hook ================================================ */
                ?>


                <?php
                /**
                 * Hook: woocommerce_single_product_summary.
                 * @hooked woocommerce_template_single_title - 5
                 * @hooked woocommerce_template_single_rating - 10
                 * @hooked woocommerce_template_single_price - 10
                 * @hooked woocommerce_template_single_excerpt - 20
                 * @hooked woocommerce_template_single_add_to_cart - 30
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 * @hooked WC_Structured_Data::generate_product_data() - 60
                 */
                do_action('woocommerce_single_product_summary');
                ?>

                <?php
                /**
                 * Hook: woocommerce_after_single_product_summary.
                 *
                 * @hooked woocommerce_output_product_data_tabs - 10
                 * @hooked woocommerce_upsell_display - 15
                 * @hooked woocommerce_output_related_products - 20
                 */
                /*Por si lo necesitas (si no borrar) */
                /* do_action( 'woocommerce_after_single_product_summary' );*/
                ?>

            </div>


        </div>
    </div>




    <!---------------------------------------------------->
    <!-- Columna Derecha: higift-card-wrapper (vista previa de la tarjeta)--------------------------------------->
    <?php include(plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR .'inc'.DIRECTORY_SEPARATOR.'higift_card_template.php'); ?>

    <?php if ($higift_type == 'corona_de_caridad') : ?>
        <!-- Código específico para la corona de caridad -->


    <?php else : ?>
        <!-- Código específico para la tarjeta solidaria -->
    <?php endif; ?>

</div> <!-- higift-wrapper -->


<?php
get_footer(); // Incluir el archivo footer.php de tu tema
?>