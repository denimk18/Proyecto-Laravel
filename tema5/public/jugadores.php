<?php
require '../vendor/autoload.php';

use Clases\Jugador;
use Clases\Conexion;
use \Milon\Barcode\DNS1D;
use Philo\Blade\Blade;

$views = '../views';
$cache = '../cache';
$blade = new Blade($views, $cache);
$pinta = (new pintaDatosJugadores())->listadoJugadores();
$titulo = 'Listado de jugadores';
$encabezado = 'Listado de jugadores';

echo $blade
    ->view()
    ->make('vjugadores', compact('titulo', 'encabezado', 'pinta'))
    ->render();

/*
    Esto es una clase interna que he creado debido a que, no veo la manera de crear un constructor vacío 
    para Jugador. Le definí un constructor con parámetros (nombre,apellidos,dorsal...), pero pensé 
    que al igual que en Java, me permitiría tener uno sin parámetros para poder instanciarlo y
    llamar a métodos sin necesidad de pasarle los atributos necesarios. Al no poder hacer esto, me he 
    creado esta clase interna que contiene dos métodos: uno para listar todas las personas, y otro
    para pintar sus códigos de barras en función del dorsal recibido. Este último méetodo lo utilizo
    en la vista vjugadores.blade.php
*/
class pintaDatosJugadores
{
    private $nombre;
    private $apellidos;
    private $posicion;
    private $dorsal;
    private $codigoBarras;

    //Para pintar el codigo de barras del usuario con el nº de dorsal que le pasamos
    public static function pintaCodigobarras($dorsal)
    {
        $conexion = new Conexion();
        $cod = '';
        //Consulta sql, donde busco el barcode correspondiente al dorsal pasado
        $resultado = $conexion->query("SELECT barcode FROM jugadores where dorsal = $dorsal");

        //Ejecuto la consulta y en función de lo obtenido creo un objeto DNS1D que posteriormente
        //pinto por pantalla con echo y también retorno para que sea visible en la vista.
        try {
            $d = new DNS1D();
            while ($registro = $resultado->fetch()) {
                $cod = $registro[0]; //Cod equivale al barcode almacenado en la base de datos
                $d->setStorPath(__DIR__ . '/cache/');
                echo  $d->getBarcodeHTML($cod, 'EAN13');
            }
        } catch (PDOException $ex) {
            die("Error al recuperar: " . $ex->getMessage());
        }
        return $d;
    }

    //Devuelve un listado de todos los jugadores
    public function listadoJugadores()
    {
        $conexion = new Conexion();
        $resultado = $conexion->query("SELECT * FROM jugadores order by dorsal");
        try {
            $resultado->execute();
        } catch (PDOException $ex) {
            die("Error al recuperar: " . $ex->getMessage());
        }
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }
}
