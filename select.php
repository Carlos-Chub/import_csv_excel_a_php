<?php

// $connect = new PDO("mysql:host=localhost;dbname=prueba_nomen", "root", "");
$conexion=mysqli_connect("localhost","root","","prueba_nomen"); 
// mysqli_set_charset($conexion, 'utf8');
// header('Content-Type: text/html; charset=ISO-8859-1');  

$sql = "SELECT * FROM ctb_nomenclatura";
$result = mysqli_query($conexion, $sql);
if($result->num_rows>0){
   while($fila=$result->fetch_assoc()){
         $item_1 = $fila["id"];
         $item_2 = $fila["ccodcta"];
        $item_3 = $fila["cdescrip"];
        //  $name = html_entity_decode($name, ENT_QUOTES | ENT_HTML401, "UTF-8");
         echo $item_1 ." - ".$item_2." - ".$item_3;
        echo "<br>";
   }
}
mysqli_close($conexion);