<?php
/*
* Enviar tarjeta, una por cada ITEM de la ORDER
* Se ejecuta con el HOOK woocommerce_order_status_completed
* HOOK
*/
add_action('woocommerce_order_status_completed', 'enviar_email_tarjeta', 10, 1);

function enviar_email_tarjeta($order_id)
{
    $order = wc_get_order($order_id);
    $items = $order->get_items();
  
    /* 
    *   Extracción de los datos del item de la orden.
    *   Obtener información desde los metadatos de la orden.
    *   Este foreach es por si en un futuro alguien llega a enviar más de una tarjeta.
    *   Por ahora, solo se puede mandar un solo higift por pedido.
    */

    foreach ($items as $item_id => $item) {

        $higift_to_name = $item->get_meta('higift_to_name', true);
        $higift_to_email = $item->get_meta('higift_to_email', true);
        $higift_sender_name = $item->get_meta('higift_sender_name', true);
        $higift_sender_lastname = $item->get_meta('higift_sender_lastname', true);
        $higift_type = $item->get_meta('higift_type', true);   
        $higift_message = $item->get_meta('higift_message', true);

        $higift_image_url = $item->get_meta('higift_image_url',true); // Obtener los metadatos de la imagen => FALSE


        //Comprobación de ruta. Uso de imagen default si no aparece.
        if ($higift_image_url){
            $image_filename = $higift_image_url;
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


        /*GENERAR CONTENIDO DEL EMAIL (HTML) */

            // Convertir el tipo de tarjeta a un formato más legible
            $readable_higift_type = str_replace('_', ' ', $higift_type);
            $readable_higift_type = ucwords($readable_higift_type); // Convertir la primera letra de cada palabra a mayúscula
        

            ob_start();
                include(HIGIFT_TEMPLATE_DIR. 'higift_mail_template.php');
                /*Captura el html*/
            $html_content = ob_get_clean();
 
        /*
        * GENERAR EL PDF 
        */

        require_once(HIGIFT_INC_DIR.'higift-pdf-generate.php');

        /*
        * CONFIGURAR Y ENVIAR EL EMAIL
        * Con el contenido HTML, el PDF adjunto y todos los datos de header necesarios.
        */

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
