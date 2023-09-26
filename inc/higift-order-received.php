<?php
/*
* Pasa los meta_data del item del carro a item del pedido.
* 
*/
add_action('woocommerce_checkout_create_order_line_item', 'guardar_campos_personalizados_en_pedido', 10, 4);

function guardar_campos_personalizados_en_pedido($item, $cart_item_key, $values, $order) {
    if (isset($values['higift_to_name'])) {
        $item->add_meta_data('higift_to_name', $values['higift_to_name']);
    }
    if (isset($values['higift_to_email'])) {
        $item->add_meta_data('higift_to_email', $values['higift_to_email']);
    }
    if (isset($values['higift_sender_name'])) {
        $item->add_meta_data('higift_sender_name', $values['higift_sender_name']);
    }
    if (isset($values['higift_sender_lastname'])) {
        $item->add_meta_data('higift_sender_lastname', $values['higift_sender_lastname']);
    }
    if (isset($values['higift_other_name'])) {
        $item->add_meta_data('higift_other_name', $values['higift_other_name']);
    }
    if (isset($values['higift_type'])) {
        $item->add_meta_data('higift_type', $values['higift_type']);
    }
    if (isset($values['higift_message'])) {
        $item->add_meta_data('higift_message', $values['higift_message']);
    }
    if (isset($values['higift_image_url'])) {
        $item->add_meta_data('higift_image_url', $values['higift_image_url']);
    }


    //No olvides pasar el array de higift!
    if (isset($values['higift_item_data'])) {
        $item->add_meta_data('higift_item_data', $values['higift_item_data']);
    }
    
}

