<?php
/*
Plugin Name: My Dompdf Plugin
Description: Intégration de Dompdf dans WordPress.
Version: 1.0
*/

// Inclure Dompdf
require_once __DIR__ . '/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

function generate_pdf() {
    // Vérifier si la requête est valide
    if (isset($_GET['generate_pdf'])) {
        $dompdf = new Dompdf();
        $html = '<h1>Génération du pdf</h1>';
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("document.pdf", ["Attachment" => false]);
        exit;
    }
}

add_action('init', 'generate_pdf');
