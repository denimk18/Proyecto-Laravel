<?php
require '../vendor/autoload.php';

use Clases\Jugador;
use Philo\Blade\Blade;
use \Milon\Barcode\DNS1D;
$views = '../views';
$cache = '../cache';
$faker = Faker\Factory::create(); //Instancio objeto de Fzaninotto faker
$valores = array(); //Creo array para guardar los nº aleatorios para dorsal que genero. Evita duplicados
$x = 0; //Variable de control para el método que genera nºs aleatorios para dorsales

//Para crear 10 jugadores con datos aleatorios
for ($i = 0; $i <= 9; $i++) {
  //Creo un objeto del tipo Jugador y le inserto atributos aleatorios
  $jugadores=(new Jugador($faker->firstname,$faker->lastname, posicionAleatoria(),dorsalAleatorio(), codigoBarras()));
  $jugadores->insertarJugador($jugadores); //Inserto el jugador en la base de datos
}

echo "<script>alert('Se han instalado los datos de prueba. Redirigiendo a jugadores...')
window.location.href=\"jugadores.php\";
</script>"; 

//Devuelve un nº aleatorio entre 1 y 6 equivalente al enum de la base de datos para la posicion
function posicionAleatoria(){
  $d=rand(1,6);
  return $d ;
}

//Genera un nº de dorsal aleatorio del 1 al 10 evitando que se repitan 
function dorsalAleatorio(){
  global $valores;
  global $x;
  while ($x<10) { //Mientras x sea menor que 10 (el nº de jugadores)
    $num_aleatorio = rand(1,10); //Creo nº aleatorio
    if (!in_array($num_aleatorio,$valores)) { //Compruebo si está en el array, si no lo está lo añado
      array_push($valores,$num_aleatorio);
      $x++; //Incremento x para la siguiente vuelta
      return $num_aleatorio; //Retorno un nº aleatorio del 1 al 10 sin repetir
    }
  }  
}

//Genera un código de barras para cada jugador
function codigoBarras(){
  //Con este bucle for genero un nº aleatorio de 13 cifras
  $digitos = '';
  for($i = 0; $i < 12; $i++){
     $digitos .= mt_rand(0,9);
  }
 
  //CÓDIGO QUE HE USADO PARA PROBAR A IMPRIMIRLO, NO LO UTILIZO AQUÍ ES UNA SIMPLE PRUEBA
  /*Creo el objeto DNS1D, usado por Milon Barcode, le añado el path de la caché
  $d = new DNS1D();
  $d->setStorPath(__DIR__.'/cache/');
  echo $d->getBarcodeHTML($digitos, 'EAN13'); Para imprimir el código de barras*/
  return $digitos;  //Retorno la numeración
} 

?>