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

/*Guardar los campos personalizados al cart-item */
// Hook para capturar los valores de los campos personalizados y añadirlos como metadatos al carrito
function agregar_campos_personalizados_al_carrito($cart_item_data, $product_id) {
    if (isset($_POST['higift_to_name'])) {
        $cart_item_data['higift_to_name'] = sanitize_text_field($_POST['higift_to_name']);
    }
    if (isset($_POST['higift_to_email'])) {
        $cart_item_data['higift_to_email'] = sanitize_email($_POST['higift_to_email']);
    }
    return $cart_item_data;
}
add_filter('woocommerce_add_cart_item_data', 'agregar_campos_personalizados_al_carrito', 10, 2);

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
    return $item_data;
}
add_filter('woocommerce_get_item_data', 'mostrar_campos_personalizados_en_carrito', 10, 2);


function mi_contenido_entre_payment_y_submit($cont) {
    echo $cont;
    echo '<p>Mi contenido personalizado entre los métodos de pago y el botón de envío.</p>';
}

add_filter('woocommerce_checkout_order_review', 'mi_contenido_entre_payment_y_submit');
