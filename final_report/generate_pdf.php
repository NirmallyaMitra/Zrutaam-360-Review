<?php
// Include DomPDF library
require '../vendor/autoload.php';
include '../version1/database/connection.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Create Dompdf options
$options = new Options();
$options->set('defaultPaperSize', 'A4'); // Set paper size
$options->set('defaultPaperOrientation', 'portrait'); // Set orientation

$stmt = $conn->prepare("SELECT emp_name FROM mail_original_table WHERE unique_code = ?;");
$stmt->bind_param('s', $_GET['id']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$emp_name = $result['emp_name'];

// Function to fetch file content
function getFileContent($file)
{
    $id = $_GET['id'];
    $var_name = $GLOBALS['emp_name'];
    ob_start(); // Start output buffering
    include $file; // Include the PHP file (execute its code)
    return ob_get_clean(); // Get the buffered content and clean the buffer
}

// Fetch content from the PHP file
$htmlContent = getFileContent('chart_c1.php');
$htmlContent .= getFileContent('chart_c2.php');
$htmlContent .= getFileContent('chart_c3.php');
$htmlContent .= getFileContent('chart_c4.php');
$htmlContent .= getFileContent('chart_c5.php');
$htmlContent .= getFileContent('chart_c6.php');
$htmlContent .= getFileContent('chart_c7.php');
$htmlContent .= getFileContent('chart_c8.php');
$htmlContent .= getFileContent('chart_c9.php');
$htmlContent .= getFileContent('chart_c10.php');
$htmlContent .= getFileContent('chart2.php');
$htmlContent .= getFileContent('chart3.php');
$htmlContent .= getFileContent('chart4.php');
$htmlContent .= getFileContent('chart5.php');
$htmlContent .= getFileContent('chart6.php');
$htmlContent .= getFileContent('chart7.php');
$htmlContent .= getFileContent('chart8.php');
$htmlContent .= getFileContent('chart9.php');
$htmlContent .= getFileContent('review.php');


// Initialize DomPDF
$dompdf = new Dompdf($options);

// Load HTML content
$dompdf->loadHtml($htmlContent);

// Set paper size and orientation
// $dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF (inline or as a download)
$dompdf->stream("generated_pdf.pdf", array("Attachment" => false));
