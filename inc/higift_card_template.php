<?php
if (!defined('ABSPATH')) {
  exit; // Salir si se accede directamente
}

/*Estilos*/

// Incrustar CSS
// Leer el contenido del archivo CSS
$css_content = file_get_contents(HIGIFT_PLUGIN_DIR . 'css/card-template-styles.css');

// Imprimir el contenido del archivo CSS dentro de una etiqueta <style>
echo '<style type="text/css">' . $css_content . '</style>';

// Incrustar imagen de fondo en el estilo si es email.
if (isset($is_email_template) && $is_email_template) {
  // Código PHP para cargar la imagen de fondo en el correo electrónico
  echo '<style>#higift-view { background-image: url("' . $higift_image_url . '"); }</style>';
  echo '<style>#higift-view { position: inherit!important;}</style>';

  /*El template si es llamado sin las variables, definirá valores por defecto */
  $higift_type = $higift_type ?? $item->get_meta('higift_message', true);
  $higift_message = $higift_message ?? $item->get_meta('higift_message', true);
  echo '<style>#higift-view { background-image: url("' . $higift_image_url . '"); }</style>';
} else {
  // Aquí podrías poner el código JavaScript para la página de configuración del producto
}


$higift_to_name = $higift_to_name ?? "Destinatarios";
$higift_to_email = $higift_to_email ?? "destinatario@correo.com";
$higift_sender_name = $higift_sender_name ?? "Nombre remitente";
$higift_sender_lastname = $higift_sender_lastname ?? "Apellido remitente";

?>


<div id="higift-card-wrapper">

  <div id="higift-view">
    
  <!--parte superior de la tarjeta-->
    <div id="higift_view_top" style="background-image: url(<?php $higift_image_url?>);" >
    

</div>

    <!--parte inferior de la tarjeta -->
    <div id="higift_view_bottom">
      <?php if ($higift_type == 'corona_de_caridad') : ?>
        <div style="text-align: center;">
          <p class="texto-sm">Hogar Italiano ha recibido una Corona de Caridad:</p>
          <p>En memoria de: </p>
          <p id="higift_other_name_preview" class="cursiva"><?php echo $higift_to_name; ?></p>
          <p id="higift_message_preview">Mensaje personalizado</p>
          <p>Enviada por:
          <p>
            <span id="higift_sender_name_preview" class="cursiva">Nombre del remitente
          </p>

          </span></p>
        <?php else : ?>
          <div style="text-align: center;">
            <p id="higift_to_name_preview"></p>
            <p id="higift_message_preview"></p>
            <p id="higift_sender_name_preview"></p>
          </div>

        <?php endif; ?>
        </div>

    </div>
  </div>
</div>