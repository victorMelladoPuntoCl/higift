<?php
// Enviar tarjeta, una por item cart.


add_action('woocommerce_order_status_completed', 'enviar_email_tarjeta', 10, 1);

function enviar_email_tarjeta($order_id)
{
    $order = wc_get_order($order_id);
    $items = $order->get_items();

    //Generar el HTML y guardarlo en una variable.
    foreach ($items as $item_id => $item) {

        $higift_to_name = $item->get_meta('higift_to_name', true);
        $higift_to_email = $item->get_meta('higift_to_email', true);
        $higift_sender_name = $item->get_meta('higift_sender_name', true);
        $higift_sender_lastname = $item->get_meta('higift_sender_lastname', true);
        $higift_type = $item->get_meta('higift_type', true);   
        
        /**
        * @param int $higift_image_id ID de la imagen del item en la biblioteca de Wordpress.
        * @param array $image_metadata Datos de imagen: https://developer.wordpress.org/reference/functions/wp_get_attachment_metadata/
        */

        $higift_image_id = $item->get_meta('higift_image_id', true); // Recuperar el ID de la imagen
        $image_metadata = wp_get_attachment_metadata($higift_image_id); // Obtener los metadatos de la imagen

        if ($image_metadata && isset($image_metadata['file'])) {
            $image_filename = $image_metadata['file']; // Obtener la ruta local completa del archivo de la imagen
        } else {
           // Usar una imagen predeterminada que tengas en la carpeta 'img' de tu directorio de plugin
            $image_filename = HIGIFT_PLUGIN_DIR2.DIRECTORY_SEPARATOR. 'img/tarjeta_higift_default.jpg';
        }



        $is_email_template = true;

        // Obtener la URL de la imagen con el tamaño específico
        // genera $higift_image_url
        $image_attributes = wp_get_attachment_image_src($higift_image_id, 'tarjeta_higift');

        if ($image_attributes) { //si hay imagen
            $higift_image_url = $image_attributes[0];
            $image_data = file_get_contents($image_filename);

        } else {
            // URL de la imagen predeterminada //porsiaca no hay...
            $higift_image_url = plugin_dir_url(dirname(__FILE__)) . 'img/tarjeta_higift_default.jpg';
            $image_data = file_get_contents($image_filename);

        }


        /*Carga el template y le pasa las variables */
        ob_start();
            include(HIGIFT_TEMPLATE_DIR. 'higift_mail_template.php');
        /*Captura el html*/
        $html_content = ob_get_clean();
    
  
        /*Establecer los parámetros y enviar con wp_mail  */
        /*TO, SUBJECT, HEADERS, FROM... */


        // Convertir el tipo de tarjeta a un formato más legible
        $readable_higift_type = str_replace('_', ' ', $higift_type);
        $readable_higift_type = ucwords($readable_higift_type); // Convertir la primera letra de cada palabra a mayúscula

        /*Generar PDF */ 
        require_once(HIGIFT_INC_DIR.'higift-pdf-generate.php');

        // Establecer los parámetros y enviar con wp_mail
        $subject = $higift_sender_name . ' ' . $higift_sender_lastname . ' te ha enviado un saludo especial';

        $to = $higift_to_email;

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Tarjetas y coronas Hogar Italiano <soporte@hogaritaliano.cl>',
            'Reply-To: Soporte Hogar Italiano <soporte@hogaritaliano.cl>',
            'BCC: contacto+higift@victormellado.cl, soporte+pdf@hogaritaliano.cl', // Añadir direcciones BCC aquí separadas por coma
            // Puedes añadir más campos de encabezado aquí
        );

        // Adjuntar el PDF al correo electrónico
        $attachments = array($pdfFilePath);

        // Envía el correo electrónico con el PDF adjunto
        wp_mail($to, $subject, $html_content, $headers, $attachments);
    }
}
