<?php
session_start();
require '../vendor/autoload.php';
use Clases\Jugador;
use Clases\Conexion;
use Philo\Blade\Blade;
use \Milon\Barcode\DNS1D;
$views = '../views';
$cache = '../cache';
$conexion = new Conexion();

/*
    Genero un bucle infinito. Esto lo hago para que siga generando códigos mientras exista en la base de datos. Es decir, si 
    encuentra uno que ya existe, genera otro. Si el nuevo se vuelve a encontrar en la base de datos, se vuelve a generar. En caso
    de que genere uno que no exista, se guarda en la variable de sesión y se redirige a fcrear.php de nuevo.
*/
while(true){
    //Genera un código de barras para cada jugador
    $digitos = '';
    for ($i = 0; $i < 12; $i++) {
        $digitos .= mt_rand(0, 9);
    }
    //Si no existe el codigo generado en la base de datos,lo meto en una variable de sesión para
    //poder operar con el en otras páginas y redirijo al usuario a la página que carga la vista de 
    //Crear un usuario nuevo. Hago break y salgo del bucle
    if (!existeCodBarras($digitos)) {      
        $_SESSION['codigoGenerado']= $digitos;
        echo $digitos;
        header('Location: fcrear.php');
        break;
    }else{
        echo "El código de barras ya existe";  
        continue;      
    }
}


//Comprueba si el barcode que le pasamos ya existe en la base de datos
function existeCodBarras($barcode){
    global $conexion;
    $existe = false;        
    $resultado = $conexion->query("SELECT barcode FROM jugadores where barcode = $barcode");
    while ($registro = $resultado->fetch()) {
        $existe = true;            
    }
}
?>