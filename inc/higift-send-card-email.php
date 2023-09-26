<?php
/*
* Enviar tarjeta, una por cada ITEM de la ORDER
* Se ejecuta con el HOOK woocommerce_order_status_completed
* HOOK
*/
add_action('woocommerce_order_status_processing', 'higift_send_card_email', 10, 1);

function higift_send_card_email($order_id)
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

        $higift_other_name = $item->get_meta('higift_other_name', true);


        // Tipo de tarjeta, a un formato más legible
        $readable_higift_type = str_replace('_', ' ', $higift_type);
        $readable_higift_type = ucwords($readable_higift_type); // Convertir la primera letra de cada palabra a mayúscula

        $higift_image_url = $item->get_meta('higift_image_url',true);
        $higift_image_local_dir = $item->get_meta('higift_image_local_dir',true);

        $higift_item_data = $item->get_meta('higift_item_data',true);

        /*
        * Generar el contenido HTML para el mail y el PDF.
        */

        ob_start();
        //include(HIGIFT_TEMPLATE_DIR. 'higift_mail_template.php');
        include(HIGIFT_TEMPLATE_DIR. DIRECTORY_SEPARATOR.'higift_card_template.php');
        $html_content = ob_get_clean(); //capturar hasta aquí
        
        /*
        * Generar el pdf, usando también $html_content
        */

        require_once(HIGIFT_INC_DIR.'higift-pdf-generate.php');

        /*
        * CONFIGURAR Y ENVIAR EL EMAIL
        * Con el contenido HTML ($html_content), 
        * el PDF adjunto 
        * y todos los datos de header necesarios.
        */
    
        // En este include va la definición de las funciones addEmailContentBefore y... after.

        include(HIGIFT_TEMPLATE_DIR. DIRECTORY_SEPARATOR.'higift_email_template.php');
        $email_pre_content = addEmailContentBefore($higift_to_name, $higift_sender_name, $higift_sender_lastname, $readable_higift_type);
        $email_after_content = addEmailContentAfter();

        $email_html_content = $email_pre_content . $html_content . $email_after_content;
        
       // Guardar el HTML en un archivo de registro (log.txt)
            $logFile = HIGIFT_PLUGIN_DIR . 'log.txt';
            file_put_contents($logFile, $email_html_content);   

        
        
        //Nota: Es posible que $to y $subject sobreescribirán cualquier valor que se ingrese en $headers.
        
        $to = $higift_to_email.',Soporte Hogar Italiano <soporte@hogaritaliano.cl>';
        $subject = $higift_sender_name . ' ' . $higift_sender_lastname . ' te ha enviado una '.$readable_higift_type;
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Tarjetas y coronas Hogar Italiano <soporte@hogaritaliano.cl>',
            'Reply-To: Soporte Hogar Italiano <soporte@hogaritaliano.cl>',
            'BCC: Soporte Dev <contacto@victormellado.cl>, Soporte Hita <soporte@hogaritaliano.cl>', // Añadir direcciones BCC aquí separadas por coma
            // Puedes añadir más campos de encabezado aquí
        );

        $attachments = array($pdfFilePath);   // Adjuntar el PDF al correo electrónico

        // Envía el correo electrónico con el PDF adjunto
        wp_mail($to, $subject, $email_html_content, $headers, $attachments);
    }
}
