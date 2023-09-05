<?php
// Enviar tarjeta, una por item cart.


add_action('woocommerce_order_status_completed', 'enviar_email_tarjeta', 10, 1);

function enviar_email_tarjeta($order_id)
{
    $order = wc_get_order($order_id);
    $items = $order->get_items();

    foreach ($items as $item_id => $item) {

        $higift_to_name = $item->get_meta('higift_to_name', true);
        $higift_to_email = $item->get_meta('higift_to_email', true);
        $higift_sender_name = $item->get_meta('higift_sender_name', true);
        $higift_sender_lastname = $item->get_meta('higift_sender_lastname', true);
        $higift_type = $item->get_meta('higift_type', true);
        $higift_image_id = $item->get_meta('higift_image_id', true); // Recuperar el ID de la imagen

        $is_email_template = true;

        // Obtener la URL de la imagen con el tamaño específico
        // genera $higift_image_url
        $image_attributes = wp_get_attachment_image_src($higift_image_id, 'tarjeta_higift');
        
        if ($image_attributes) {
            $higift_image_url = $image_attributes[0];
            $image_data = file_get_contents($higift_image_url);
            $base64_image = 'data:image/jpeg;base64,' . base64_encode($image_data);

        } else {
            // URL de la imagen predeterminada
            $higift_image_url = plugin_dir_url(dirname(__FILE__)) . 'img/tarjeta_higift_default.jpg';
            $image_data = file_get_contents($higift_image_url);
            $base64_image = 'data:image/jpeg;base64,' . base64_encode($image_data);
        }


        /*Carga el template y le pasa las variables */

        ob_start();

        if (file_exists(plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR . 'higift_card_template.php')) {
            include(plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR . 'higift_card_template.php');
        } else {
            error_log('El archivo higift_card_template.php no se encuentra en la ruta especificada.');
        }

        /*Captura el html y envía el mail*/

        $html_content = ob_get_clean();

        /*Establecer los parámetros y enviar con wp_mail  */
        /*TO, SUBJECT, HEADERS, FROM... */


        // Convertir el tipo de tarjeta a un formato más legible
        $readable_higift_type = str_replace('_', ' ', $higift_type);
        $readable_higift_type = ucwords($readable_higift_type); // Convertir la primera letra de cada palabra a mayúscula

        // Formatear el asunto del correo
        $subject = "{$higift_sender_name} {$higift_sender_lastname} te ha enviado una {$readable_higift_type}";

        $to = $higift_to_email;

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Tarjetas y coronas Hogar Italiano <soporte@hogaritaliano.cl>',
            'Reply-To: Soporte Hogar Italiano <soporte@hogaritaliano.cl>',
            'BCC: contacto@victormellado.cl', // Añadir direcciones BCC aquí separads con coma
            // Puedes añadir más campos de encabezado aquí
        );
        

        wp_mail($to, $subject, $html_content, $headers);
    }
}
