<?php
session_start();
require '../vendor/autoload.php';

use \Milon\Barcode\DNS1D;
use Philo\Blade\Blade;
use Clases\Conexion;
use Clases\Jugador;

//RECOJO TODOS LOS DATOS DEL FORMULARIO EN VARIABLES DE SESIÓN PARA CONSERVAR SUS DATOS AUNQUE 
//SE PULSE SOBRE EL ENLACE QUE GENERA UN CÓDIGO
if (isset($_POST['nombre'])) {
    $_SESSION['sesNombre'] = $_POST['nombre'];
}

if (isset($_POST['apellidos'])) {
    $_SESSION['sesApellidos'] = $_POST['apellidos'];
}

if (isset($_POST['dorsal'])) {
    $_SESSION['sesDorsal'] = $_POST['dorsal'];
}

if (isset($_POST['posicion'])) {
    $_SESSION['sesPosicion'] = $_POST['posicion'];
}

if(isset($_POST['volverDeCrear'])){
    session_unset();
    header('Location: jugadores.php');
}


//Si recibo la variable crear
if (isset($_POST['crear'])) {
    //Compruebo si hay algún barcode en la variable de sesión, de no ser así aviso al usuario para que genere uno
    if(isset($_SESSION['codigoGenerado'])){
        //Creo un objeto del tipo jugador con los datos recogidos de las variables de sesión
        $jugadores = (new Jugador(
            $_SESSION['sesNombre'],
            $_SESSION['sesApellidos'],
            $_SESSION['sesPosicion'],
            $_SESSION['sesDorsal'],
            $_SESSION['codigoGenerado']
        ));

         //En resultado guardo lo que me devuelve el método insertarJugador
    $resultado = $jugadores->insertarJugador($jugadores);

    //Si me devuelve 0, significa que lo ha insertado bien. Muestro alert al usuario y borro
    //los datos de las variables de sesión. Vuelvo a fcrear.php para ver el formulario
    if($resultado == 0){
        echo "<script> alert('Jugador insertado');
        window.location.href=\"fcrear.php\";
         </script>";
        session_unset();
    }
  
    /*
        Si resultado = 1 significa que el barcode generado ya existe en la base de datos,
        le muestro alert al usuario para que genere otro y lo redirijo al formulario tambien
    */
   if($resultado == 1){
    echo "<script> alert('El barcode generado ya existe, por favor genere otro'); 
    window.location.href=\"fcrear.php\";
    </script>";
    }

    /*
        Si resultado = 2 significa que el jugador que intenta insertar ya existe en la base de datos.
        Muestro alert al usuario indicándolo y vuelvo a redirigirlo a la página del formulario
    */
    if($resultado == 2){
        echo "<script> alert('El jugador que intenta insertar ya existe.');
        window.location.href=\"fcrear.php\";
         </script>";     
    }

    }else{
        echo "<script> alert('Genere un código para el jugador');
        window.location.href=\"fcrear.php\";
         </script>";
    }
  

   

}

//Pinta el código de barras en el formulario de crear jugador
function pintaCodBarras($cod)
{
    if(isset($_SESSION['codigoGenerado'])){
        $d = new DNS1D();
        $d->setStorPath(__DIR__ . '/cache/');
        echo $d->getBarcodeHTML($cod, 'EAN13');
    }else{
        echo "";
    }  
}
