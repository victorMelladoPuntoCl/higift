<?php
function add_custom_css()
{
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


/* GUARDAR los datos del formulario en el cart item */
/*Agregar los datos al OBJETO del item del carrito */

add_filter('woocommerce_add_cart_item_data', 'agregar_campos_personalizados_al_carrito', 10, 3);

function agregar_campos_personalizados_al_carrito($cart_item_data, $product_id, $variation_id)
{
    $higift_item_data = array();

    if (isset($_POST['higift_to_name'])) {
        $cart_item_data['higift_to_name'] = sanitize_text_field($_POST['higift_to_name']);
        $higift_item_data['to_name'] = $cart_item_data['higift_to_name'];
    }
    if (isset($_POST['higift_to_email'])) {
        $cart_item_data['higift_to_email'] = sanitize_email($_POST['higift_to_email']);
        $higift_item_data['to_email'] = $cart_item_data['higift_to_email'];
    }
    if (isset($_POST['higift_sender_name'])) {
        $cart_item_data['higift_sender_name'] = sanitize_text_field($_POST['higift_sender_name']);
        $higift_item_data['sender_email'] = $cart_item_data['higift_sender_name'];
    }
    if (isset($_POST['higift_sender_lastname'])) {
        $cart_item_data['higift_sender_lastname'] = sanitize_text_field($_POST['higift_sender_lastname']);
        $higift_item_data['sender_lastname'] = sanitize_text_field($_POST['higift_sender_lastname']);
    }
    if (isset($_POST['higift_type'])) {
        $cart_item_data['higift_type'] = sanitize_text_field($_POST['higift_type']);
        $higift_item_data['higift_type'] = sanitize_text_field($_POST['higift_type']);
    }
    if (isset($_POST['higift_message'])) {
        $cart_item_data['higift_message'] = sanitize_text_field($_POST['higift_message']);
        $higift_item_data['message'] = sanitize_text_field($_POST['higift_message']);
    }
    if (isset($_POST['higift_other_name'])) {
        $cart_item_data['higift_other_name'] = sanitize_text_field($_POST['higift_other_name']);
        $higift_item_data['other_name'] = sanitize_text_field($_POST['higift_other_name']);
    }


    if ($variation_id) {
        $image_id = get_post_thumbnail_id($variation_id);
        $image_info = wp_get_attachment_image_src($image_id, 'full'); 
        
        $cart_item_data['higift_image_url']  = $image_info[0];  // guarda la URL en el cart item
        $higift_item_data['image_url']  = $image_info[0];  // guarda la URL en el cart item
        
        $cart_item_data['higift_image_local_dir'] = get_attached_file($image_id);
        $higift_item_data['image_local_dir'] = get_attached_file($image_id);
    }

        // Guardar el arreglo $higift
        $cart_item_data['higift_item_data']  = $higift_item_data; 


    return $cart_item_data;
}



/* 
* RECUPERAR los datos personalizados del itemcart.
* Usar un FILTER al obtener los items del carrito y añadirle un campo personalizado
* Los datos se obtienen desde el POST.
*/

// Función para vaciar el carrito antes de agregar un nuevo producto
function vaciar_carrito_al_agregar_producto($cart_item_data, $product_id) {
    // Vacía todo el contenido del carrito
    WC()->cart->empty_cart();
    
    // Retorna los datos del producto actual para agregarlo al carrito
    return $cart_item_data;
}

// Agrega el gancho al evento de agregar producto al carrito
add_filter('woocommerce_add_cart_item_data', 'vaciar_carrito_al_agregar_producto', 10, 2);

add_filter('woocommerce_get_item_data', 'mostrar_campos_personalizados_en_carrito', 10, 2);

function mostrar_campos_personalizados_en_carrito($item_data, $cart_item) {
    if (isset($cart_item['higift_type'])) {
        $item_data[] = array(
            'key' => 'Regalo:',
            'value' => $cart_item['higift_type']
        );
    }

    
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


        if (isset($cart_item['higift_message'])) {
            $item_data[] = array(
                'key' => 'Mensaje:',
                'value' => $cart_item['higift_message']
            );
    }
    return $item_data;
}


