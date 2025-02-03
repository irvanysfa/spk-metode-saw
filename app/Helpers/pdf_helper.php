<?php

use Dompdf\Dompdf;
use Dompdf\Options;

if (!function_exists('generate_pdf')) {
    function generate_pdf($html, $filename)
    {
        // Set options for DomPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Create DomPDF instance
        $dompdf = new Dompdf($options);

        // Load HTML content
        $dompdf->loadHtml($html);

        // Set paper size
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (first pass)
        $dompdf->render();

        // Stream PDF to browser
        $dompdf->stream($filename, array("Attachment" => false));
    }
}
