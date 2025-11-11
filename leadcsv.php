<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filePath = 'leads.xlsx';

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';
    $language = $_POST['language'] ?? '';
    $service = $_POST['service'] ?? '';
    $date = date("Y-m-d H:i:s");

    // Load existing file or create new
    if (file_exists($filePath)) {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $nextRow = $sheet->getHighestRow() + 1;
    } else {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Headers
        $sheet->fromArray(['Name', 'Email', 'Phone', 'Message', 'Language', 'Service', 'Date'], NULL, 'A1');
        $nextRow = 2;
    }

    // Add new row
    $sheet->fromArray([$name, $email, $phone, $message, $language, $service, $date], NULL, 'A'.$nextRow);

    // Save file
    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);

    echo "<script>alert('Your details are saved successfully!');window.location.href='thankyou.html';</script>";
    exit;
}
?>
