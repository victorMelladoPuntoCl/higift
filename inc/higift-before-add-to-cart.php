
<?php
function mostrar_metadatos_en_pagina_pedido_recibido($order) {
    error_log("El archivo higift-order-received.php se ha incluido correctamente.");

    
    // Obtener los elementos de la orden
    $items = $order->get_items();

    // Iterar a través de cada elemento
    foreach ($items as $item_id => $item) {
        var_dump($item->get_meta_data());
        // Obtener y mostrar los metadatos personalizados
        $nombre_destinatario = $item->get_meta('higift_to_name', true);
        $email_destinatario = $item->get_meta('higift_to_email', true);
        $nombre_remitente = $item->get_meta('higift_sender_name', true);
        $apellido_remitente = $item->get_meta('higift_sender_lastname', true);

        // Mostrar los datos
        echo '<h2>Detalles adicionales del destinatario</h2>';
        echo '<ul>';
        echo '<li><strong>Nombre del destinatario:</strong> ' . $nombre_destinatario . '</li>';
        echo '<li><strong>Email del destinatario:</strong> ' . $email_destinatario . '</li>';
        echo '<li><strong>Nombre del remitente:</strong> ' . $nombre_remitente . '</li>';
        echo '<li><strong>Apellido del remitente:</strong> ' . $apellido_remitente . '</li>';
        echo '</ul>';
    }
}

add_action('woocommerce_order_details_after_order_table', 'mostrar_metadatos_en_pagina_pedido_recibido');
