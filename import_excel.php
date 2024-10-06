<?php
require 'vendor/autoload.php'; // Include the Composer autoload file

use PhpOffice\PhpSpreadsheet\IOFactory;

// require 'phpspreadsheet/PhpOffice/PhpSpreadsheet/Spreadsheet.php';
// require 'phpspreadsheet/PhpOffice/PhpSpreadsheet/IOFactory.php';
// require 'phpspreadsheet/PhpOffice/PhpSpreadsheet/Shared/File.php';
// // require 'phpspreadsheet/PhpOffice/PhpSpreadsheet/Reader/Xlsx.php';
// require_once 'phpspreadsheet/PhpOffice/PhpSpreadsheet/Reader/BaseReader.php';
// require_once 'phpspreadsheet/PhpOffice/PhpSpreadsheet/Reader/IReader.php';

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit'])) {
    $file = $_FILES['excel_file']['tmp_name'];

    // Load the Excel file
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    
    // Get the highest row and column numbers
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    echo "<table border='1'>";
    // Loop through each row of the spreadsheet
    for ($row = 1; $row <= $highestRow; $row++) {
        echo "<tr>";
        // Loop through each column of the spreadsheet
        for ($col = 'A'; $col <= $highestColumn; $col++) {
            $cellValue = $sheet->getCell($col . $row)->getValue();
            echo "<td>" . htmlspecialchars($cellValue) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Excel File</title>
</head>
<body>
    <h1>Import Excel File</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="excel_file" accept=".xlsx, .xls" required>
        <button type="submit" name="submit">Import</button>
    </form>
</body>
</html>