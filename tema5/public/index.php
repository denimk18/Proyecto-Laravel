<?php
require '../vendor/autoload.php';
use Clases\Jugador;
use Clases\Conexion;

$conexion = new Conexion(); 

//Si existe registros devuelve true, llevo al usuario a la tabla donde se muestran
if(existeRegistros()){
    header('Location:jugadores.php');
}else{
    header('Location:instalacion.php');
    //De lo contrario lo llevo a la pagina instalacion para crear datos de prueba
}

//Compruebo si la tabla tiene datos. Si me devuelve 0 es que no tiene registros
 function existeRegistros(){
    global $conexion;
    $existe = false;        
    $resultado = $conexion->query("SELECT COUNT(*) FROM jugadores");
    //Si el producto existe se mete al while y pongo el booleano a true    
    while ($registro = $resultado->fetch()) {
        if($registro[0] != 0)  {
            $existe = true;
        }         
    }
        return $existe;
    }
?>