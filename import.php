<?php
header('Content-Type: text/html; charset=UTF-8'); 
// header('Content-Type: text/html; charset=ISO-8859-1');

//import.php

include 'vendor/autoload.php';

$connect = new PDO("mysql:host=localhost;dbname=prueba_nomen", "root", "");

if ($_FILES["import_excel"]["name"] != '') {
    $allowed_extension = array('xls', 'csv', 'xlsx');
    $file_array = explode(".", $_FILES["import_excel"]["name"]);
    $file_extension = end($file_array);

    if (in_array($file_extension, $allowed_extension)) {
        $file_name = time() . '.' . $file_extension;
        move_uploaded_file($_FILES['import_excel']['tmp_name'], $file_name);
        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

        $spreadsheet = $reader->load($file_name);

        unlink($file_name);

        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $row) {
            $insert_data = array(
                ':ccodcta'  => $row[1],
                ':cdescrip'  => utf8_encode($row[2]) 
            );

            $query = "INSERT INTO ctb_nomenclatura (ccodcta, cdescrip) VALUES (:ccodcta, :cdescrip)
   ";

            $statement = $connect->prepare($query);
            $statement->execute($insert_data);
        }
        $message = '<div class="alert alert-success">Data Imported Successfully</div>';
    } else {
        $message = '<div class="alert alert-danger">Only .xls .csv or .xlsx file allowed</div>';
    }
} else {
    $message = '<div class="alert alert-danger">Please Select File</div>';
}

echo $message;
