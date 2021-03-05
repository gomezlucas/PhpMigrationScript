<?php 
 $mysqliOld = new mysqli('localhost', 'lucas', 'lucas', 'cotr');
 
/* Testeamos que se haya conectado correctamente */
if (mysqli_connect_error()) {
    echo "Error en la conexión: " . mysqli_connect_error();
    die();
}else{
    echo "Connected to the Old database"."</br>";
}

?>