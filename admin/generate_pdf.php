<?php
require_once 'vendor/autoload.php';

function generatePdfFromHtml($htmlContent)
{
    // Create a new instance of Dompdf
    $dompdf = new Dompdf\Dompdf();

    // Load the HTML content
    $dompdf->loadHtml($htmlContent);

    // (Optional) Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML content as PDF
    $dompdf->render();

    // Set the headers for the response
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="report.pdf"');

    // Output the PDF as a file
    $dompdf->stream('report.pdf');
}

// Get the HTML content from the element with ID #content
$htmlContent = '<html><body>' . file_get_contents('report.php') . '</body></html>';

// Generate PDF from HTML content
generatePdfFromHtml($htmlContent);
