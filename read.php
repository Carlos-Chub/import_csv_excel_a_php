<?php
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', '300');
$conexion = mysqli_connect("localhost", "root", "", "prueba_nomen");
include 'vendor/autoload.php';

use LDAP\Result;
use PhpOffice\PhpSpreadsheet\IOFactory;

$nombreArchivo = 'ingecop2.xlsx';
//se carga el archivo para leerlo
$documento = IOFactory::load($nombreArchivo);
//encontramos el total de hojas, si solo es uno, devuelve 1
$total_hojas = $documento->getSheetCount();
//total de filas
$hojaActual = $documento->getSheet(0);
//obtengo el numero de filas
$numeroFilas = $hojaActual->getHighestDataRow();
//contador
$contador = 0;

//Mostrar cada uno de los registros recuperados
for ($indiceFila = 1; $indiceFila <= $numeroFilas; $indiceFila++) {

    //lee cada fila del excel
    $id = $indiceFila - 1;
    $idcod = $hojaActual->getCellByColumnAndRow(1, $indiceFila);
    $cod = $hojaActual->getCellByColumnAndRow(2, $indiceFila);
    $desc = $hojaActual->getCellByColumnAndRow(3, $indiceFila);

    $sql = "INSERT INTO ctb_nomenclatura (ccodcta, cdescrip)
    VALUES ('$cod', '$desc')";


    $conexion->query($sql);
    echo $desc;
    echo "<br>";
}
