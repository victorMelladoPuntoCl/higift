<?php
/*
* Plantilla de tarjeta
* Usada en vista previa, email y PDF.
* requiere teneer definidos los valores.
*/

if (!defined('ABSPATH')) {
  exit; // Salir si se accede directamente
}

//Contenido del css de la tarjeta template para incrustar
$css_content = file_get_contents(HIGIFT_PLUGIN_DIR . 'css/card-template-styles.css');

//Si no hay imagen, usar default.
$higift_image_url = isset($higift_image_url) && $higift_image_url !== null ? $higift_image_url : HIGIFT_PLUGIN_DIR . 'img/tarjeta_higift_default.jpg';

$higift_ahoradir = (__DIR__); // "C:\Users\conta\Local Sites\hogaritaliano\app\public\wp-content\plugins\higift\templates"

/*
* VALORES DEFAULT
* Verifica si están seteados. Si no lo están (estás probablemente en la página de producto) llena con estos valores.
*/

$higift_to_name = $higift_to_name ?? "Nombre";
$higift_other_name = $higift_to_name ?? "Nombre del ser querido";
$higift_to_email = $higift_to_email ?? "destinatario@correo.com";
$higift_sender_name = $higift_sender_name ?? "Nombre (y apellido) del remitente";
$higift_sender_lastname = $higift_sender_lastname ?? "Apellido remitente";
$higift_other_name = $higift_other_name ?? "Nombre difunto";
$higift_message = $higift_message ?? "Mensaje personalizado";

?>

<head>
  <style>
    #higift-view {
      background-image: url(<?php echo ($higift_image_url); ?>);
      background-position: top center;
      background-repeat: no-repeat;
    }
    <?php echo ($css_content); // incrusta el resto del CSS?>
  </style>
  
</head>

<body>
  <div id="higift-card-wrapper">

    <div id="higift-view" class="hi">
      <!--parte superior de la tarjeta-->
      <div id="higift_view_top">


      </div>

      <!--parte inferior de la tarjeta -->
      <div id="higift_view_bottom">
        
        <?php if ($higift_type == 'corona_de_caridad') : ?>
          <div style="text-align: center;">
            <p class="texto-sm">Hogar Italiano ha recibido una Corona de Caridad:</p>
            <p>En memoria de: </p>
            <p id="higift_other_name_preview" class="cursiva"><?php echo $higift_other_name; ?></p>
            <p id="higift_message_preview"><?php echo($higift_message);?></p>
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

</body>