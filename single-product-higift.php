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

// Globales para un higift
global $product;
global $higift_type;

global $higift_message_1;
global $higift_message_2;
global $higift_message_3;

global $higift_message;

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

function enqueue_higift_scripts()
{
    wp_enqueue_script('higift-js', plugin_dir_url(__FILE__) . 'js/higift-preview.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'enqueue_higift_scripts');

// Enqueue the style
function higift_enqueue_styles() {
    wp_enqueue_style( 'higift-forms-styles', plugin_dir_url( __FILE__ ) . '/css/higift-forms.css', array(), '1.0.0', 'all' );
  }
  add_action( 'wp_enqueue_scripts', 'higift_enqueue_styles' );
  

get_header(); // Incluir el archivo header.php de tu tema
?>

<div id="higift-wrapper">
    <!-- Columna Izquierda -->

    <div id="higift-left">
        <div id="higift-left-container">
            <div class="summary entry-summary">

                <?php
                /*
                * Añadir campos personalizados antes del botón "Añadir al carrito"
                * Dentro del FORM.
                */

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
                        <style>
                            .higift-designs {
                                border: #555 solid thin;
                            }
                        </style>
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
                    <div id="higift-paso2">
                        <h2>Contenido y datos de la <?php echo $higift_type == 'corona_de_caridad' ? 'corona de caridad' : 'tarjeta solidaria'; ?></h2>

                        <h3>Paso 1: Datos para el envío de la <?php echo $higift_type == 'corona_de_caridad' ? 'corona de caridad' : 'tarjeta solidaria'; ?></h3>

                        <div class="form-group">
                            <label for="higift_to_name">Deudo(s):</label>
                            <input type="text" name="higift_to_name" id="higift_to_name" required placeholder="Nombre del deudo, familia, institución, agrupación etc.">

                            <label for="higift_to_email">Email al que se enviará la tarjeta:</label>
                            <input type="email" id="higift_to_email" name="higift_to_email" required placeholder="destinatario@ejemplo.com">
                        </div>

                        <!-- PASO2: Contenido de la Tarjeta/Corona -->

                        <h3>Paso 2: Texto en la tarjeta </h3>

                        <?php if ($higift_type == 'corona_de_caridad') : ?>
                            <div class="form-group">
                                <label for="higift_other_name">Nombre del difunto:</label>
                                <input type="text" name="higift_other_name" id="higift_other_name" required placeholder="Nombre completo, nombre, apodo cariñoso.">


                            <?php endif; ?>

                            <br>
                            <label for="higift_message">Mensaje (Hasta 200 caracteres):</label>
                            <!--<input type="text" name="higift_message" maxlength="200" required class="largo">-->
                            <textarea id="higift_message" name="higift_message" rows="4" required class="largo" maxlength="200" required></textarea>

                            <label for="higift_predefined_messages">Ideas de mensajes:</label>
                            <p>Puedes elegir un mensaje predefinido y editarlo a tu gusto </p>
                            <select id="higift_predefined_messages" name="higift_predefined_message">
                                <option value="">Ideas de mensaje (se borra lo que ya hayas escrito)</option>

                                <?php
                                /*Generar las opciones del combobox */
                                echo '<option value="' . esc_attr($higift_message_1) . '">' . esc_html($higift_message_1) . '</option>';
                                echo '<option value="' . esc_attr($higift_message_2) . '">' . esc_html($higift_message_2) . '</option>';
                                echo '<option value="' . esc_attr($higift_message_3) . '">' . esc_html($higift_message_3) . '</option>';
                                ?>
                            </select>

                            </div>
                    </div>
                    <div>
                        <h2>Datos del remitente</h2>
                        <div class="form-group">
                        <p>Estos son los datos que se mostrarán en la tarjeta y en el email</p>
                        <label for="higift_sender_name">Nombre del remitente:</label>
                        <input id="higift_sender_name" type="text" name="higift_sender_name" maxlength="20" required>
                        
                        <label for="higift_sender_lastname">Apellido del remitente:</label>
                        <input type="text" name="higift_sender_lastname" maxlength="20" required>

                        <input type="hidden" name="higift_type" value="<?php echo $higift_type; ?>">
                        </div>
                    </div>

                <?php
                } /*cierra el hook ================================================ */
                ?>

                <?php
                do_action('woocommerce_single_product_summary');
                ?>

            </div>

        </div>
    </div>




    <!---------------------------------------------------->
    <!-- Columna Derecha: higift-card-wrapper (vista previa de la tarjeta)--------------------------------------->
    <?php include(HIGIFT_TEMPLATE_DIR . 'higift_card_template.php'); ?>

    <?php if ($higift_type == 'corona_de_caridad') : ?>
        <!-- Código específico para la corona de caridad -->


    <?php else : ?>
        <!-- Código específico para la tarjeta solidaria -->
    <?php endif; ?>

</div> <!-- higift-wrapper -->


<?php
get_footer(); // Incluir el archivo footer.php de tu tema
?>