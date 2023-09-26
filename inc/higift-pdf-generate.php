<?php
/**
* Generar pdf utilizando la librería DomPDF
* Llamado desde higift-send-card-email.php
*/

/*Generar. Usará los valores definidos en el hook de orden completada en higift-send-card-email.php */

ob_start();
//include(HIGIFT_TEMPLATE_DIR. 'higift_mail_template.php');
include(HIGIFT_TEMPLATE_DIR. DIRECTORY_SEPARATOR.'higift_card_template.php');
$html_content = ob_get_clean(); //capturar hasta aquí

// Incluir la biblioteca Dompdf
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'dompdf' . DIRECTORY_SEPARATOR . 'autoload.inc.php');

// Crear una nueva instancia de Dompdf
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions(); 
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

// Configuración del PDF
$dompdf->setPaper('letter', 'portrait');
$dompdf->loadHtml($html_content);

// Renderizar el HTML en PDF
$dompdf->render();

// Guardar el PDF en una ubicación temporal en el servidor
$pdfFilePath = HIGIFT_PLUGIN_DIR2 . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $higift_type . '_para_' . $higift_to_name . '.pdf';
file_put_contents($pdfFilePath, $dompdf->output());
