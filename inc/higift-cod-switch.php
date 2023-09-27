<?php
/*
* cod swich... creo que puedo mejorar el nombre.
* 
*/
function habilitar_cod_solo_para_registrados($available_gateways) {
    if (is_user_logged_in()) {
        return $available_gateways;
    } else {
        // Si el usuario no está registrado, deshabilita el método de pago COD.
        if (isset($available_gateways['cod'])) {
            unset($available_gateways['cod']);
        }
        return $available_gateways;
    }
}

add_filter('woocommerce_available_payment_gateways', 'habilitar_cod_solo_para_registrados');