<?php

/* Generar texto */
function addEmailContentBefore($higift_to_name, $higift_sender_name, $higift_sender_lastname, $readable_higift_type) {
    $content = '
    <!DOCTYPE html>
        <html lang="es">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $readable_higift_type . ' para '. $higift_to_name. ' </title>
    </head>
    <body>
    Hola ' . $higift_to_name . ', ¿cómo estás?<br>
    ' . $higift_sender_name . ' ' . $higift_sender_lastname . ' te ha enviado una ' . $readable_higift_type . ' con un mensaje. <br>
    La tarjeta se encuentra en este correo adjunta como archivo PDF, en caso de que no puedas verla directamente aquí.
';

    return $content;
}


function addEmailContentAfter() {
    $email_after_content= '
    <footer>
    <p>Hogar Italiano - Residencia para la tercera edad</p>
    <p><a href="https://www.hogaritaliano.cl">www.hogaritaliano.cl</a></p>
    <p><a href="https://www.facebook.com/hogaritalianosantiago">Facebook</a></p>
    <p><a href="https://www.instagram.com/hogaritalianosantiago">Instagram</a></p>
    <p>Dirección: Holanda 3639, Ñuñoa, Santiago de Chile</p>
    <p>Email: contacto@hogaritaliano.cl</p>
    <p>Teléfono: (2) 2204 8386</p>
    <p>Usted ha recibido este mensaje gracias a la donación hecha por una persona hacia nosotros</p>
</footer>
<!-- Fin del Footer -->
    </body>
    '
}
