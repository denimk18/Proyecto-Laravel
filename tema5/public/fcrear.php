<?php
require '../vendor/autoload.php';
use \Milon\Barcode\DNS1D;
use Philo\Blade\Blade;

$views = '../views';
$cache = '../cache';
$blade = new Blade($views, $cache);

$titulo = 'Crear jugador';
$encabezado = 'Crear jugador';
echo $blade
    ->view()
    ->make('vcrear', compact('titulo', 'encabezado'))
    ->render();
?>
