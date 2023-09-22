<?php
/**
*Generar pdf utilizando la librería TCPDF (/lib/tcpdf) 
*/

// Incluir la biblioteca TCPDF
        require_once(__DIR__. DIRECTORY_SEPARATOR .'tcpdf'. DIRECTORY_SEPARATOR.'tcpdf.php');

        // Crear una nueva instancia de TCPDF
        $pdf = new TCPDF();

        // Otros ajustes y contenido del PDF
        $pdf->SetTitle($readable_higift_type."para".$higift_to_name);
        $pdf->SetAuthor($higift_sender_name);
        $pdf->AddPage();

        // Agregar contenido HTML al PDF
        $pdf->writeHTML($html_content, true, false, true, false, '');

        // Guardar el PDF en una ubicación temporal en el servidor
        $pdfFilePath = HIGIFT_PLUGIN_DIR2 . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $higift_type.'-para-'.$higift_to_name.'.pdf';
        $pdf->Output($pdfFilePath, 'F'); // 'F' guarda el archivo en el servidor

