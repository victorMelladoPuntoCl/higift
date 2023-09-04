<?php
function add_custom_css() {
    echo '<style type="text/css">
        #ship-to-different-address-checkbox {display:none};
    </style>';
}
add_action('woocommerce_before_checkout_form', 'add_custom_css');


    /*Siempre marcado el ship_to_different_address*/
    add_filter('woocommerce_ship_to_different_address_checked', '__return_true');

    /*Modificar los campos del checkout*/
    add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields', 99);


    function custom_override_checkout_fields($fields)
    {
        /*Toda esta funcionalidad se traspasó al plugin "Select MkRapel Regiones y Ciudades de Chile para WC */
        return $fields;

    }


    /* CAMBIOS EN LOS TEXTOS */

    add_filter('gettext', 'custom_text_strings', 20, 3);
    
    function custom_text_strings($translated_text, $text, $domain)
    {
        if ($translated_text === '¿Enviar a una dirección diferente?') {
            $translated_text = 'Dirección a la que se enviará la tarjeta física';
        }
        if ($translated_text === 'Detalles de facturación') {
            $translated_text = 'Datos de tu donación';
        }
        // Puedes seguir añadiendo más "if" aquí
        return $translated_text;
    }


    /*Agregar los datos al objeto carrito */
    
    function agregar_campos_personalizados_al_carrito($cart_item_data, $product_id) {
        if (isset($_POST['higift_to_name'])) {
            $cart_item_data['higift_to_name'] = sanitize_text_field($_POST['higift_to_name']);
        }
        if (isset($_POST['higift_to_email'])) {
            $cart_item_data['higift_to_email'] = sanitize_email($_POST['higift_to_email']);
        }
        if (isset($_POST['higift_sender_name'])) {
            $cart_item_data['higift_sender_name'] = sanitize_text_field($_POST['higift_sender_name']);
        }
        if (isset($_POST['higift_sender_lastname'])) {
            $cart_item_data['higift_sender_lastname'] = sanitize_text_field($_POST['higift_sender_lastname']);
        }
    
        return $cart_item_data;
    }
    
    add_filter('woocommerce_add_cart_item_data', 'agregar_campos_personalizados_al_carrito', 10, 2);
    

// MOSTRAR los datos de la tarjeta (nombre, mensaje, etc) en la página de checkout (carrito)
// Mostrar los campos personalizados en el carrito y en la página de finalizar compra

function mostrar_campos_personalizados_en_carrito($item_data, $cart_item) {
    if (isset($cart_item['higift_to_name'])) {
        $item_data[] = array(
            'key' => 'Nombre del destinatario',
            'value' => $cart_item['higift_to_name']
        );
    }
    if (isset($cart_item['higift_to_email'])) {
        $item_data[] = array(
            'key' => 'Email del destinatario',
            'value' => $cart_item['higift_to_email']
        );
    }
    if (isset($cart_item['higift_sender_name'])) {
        $item_data[] = array(
            'key' => 'Nombre del remitente',
            'value' => $cart_item['higift_sender_name']
        );
    }
    if (isset($cart_item['higift_sender_lastname'])) {
        $item_data[] = array(
            'key' => 'Apellido del remitente',
            'value' => $cart_item['higift_sender_lastname']
        );
    }
    return $item_data;
}
add_filter('woocommerce_get_item_data', 'mostrar_campos_personalizados_en_carrito', 10, 2);



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
