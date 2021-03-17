<?php
namespace Clases;
use Clases\Conexion;
use PDO;
use PDOException;
use \Milon\Barcode\DNS1D;


class Jugador{
    private $nombre;
    private $apellidos;
    private $posicion;
    private $dorsal;
    private $codigoBarras;


    //Constructor
    public function __construct($n, $a, $p,$d,$codBarras){
        $this->nombre=$n;
        $this ->apellidos=$a;
        $this->posicion=$p;
        $this ->dorsal=$d;
        $this ->codigoBarras=$codBarras;
    }

    


    public function getNombre(){
        return $this->nombre;
    }

    public function getApellidos(){
        return $this->apellidos;
    }

    public function getPosicion(){
        return $this->posicion;
    }

    public function getDorsal(){
        return $this->dorsal;
    }
 
    public function getCodigoBarras(){
        return $this->codigoBarras;
    }


    public function setNombre($n){
        $this->nombre = $n;
    }

    public function setApellidos($a){
        $this->apellidos = $a;
    }

    public function setPosicion($p){
        $this->posicion = $p;
    }

    public function setDorsal($d){
        $this->dorsal = $d;
    }

    public function setCodigoBarras($c){
        $this->codigoBarras = $c;
    }

    //Comprueba si existe un jugador, lo utilizo sobretodo antes de insertar para evitar duplicados.
    //Le paso como parámetro el dorsal, que es único por cada jugador y no se repite
    public static function existeJugador($dorsal){
        $conexion = new Conexion();
        $existe = false;     
        $resultado = $conexion->query("SELECT * FROM jugadores where dorsal = $dorsal");
        //Si el jugador existe se mete al while y pongo el booleano a true    
        while ($registro = $resultado->fetch()) {
            $existe = true;            
        }

        return $existe;
    }

    /*
        Compruebo si existe el barcode que le paso en la base de datos. Lo utilizo antes de insertar
        porque no pueden existir dos jugadores con el mismo barcode
    */
    public static function existeBarcode($barcode){
        $conexion = new Conexion();
        $existe = false;     
        $resultado = $conexion->query("SELECT * FROM jugadores where barcode = $barcode");
        //Si el jugador existe se mete al while y pongo el booleano a true    
        while ($registro = $resultado->fetch()) {
            $existe = true;            
        }

        return $existe;
    }

    //Para insertar el jugador
    public function insertarJugador(Jugador $jug)
    {
        $resultado = -1; //Variable que retorno para saber si se ha insertado o se ha producido error
        //Si no existe el jugador ni el barcode, lo inserto
        if (!Jugador::existeJugador($jug->getDorsal())) {
            if (!Jugador::existeBarcode(($jug->getCodigoBarras()))) {
                $conexion = new Conexion();
                //Configuro el atributo para que me muestre los errores sql
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                try {
                    //Abro la transacción y preparo la consulta
                    $conexion->beginTransaction();
                    $stmt = $conexion->prepare("INSERT INTO jugadores (nombre, apellidos, dorsal, posicion, barcode) 
                 VALUES (:nombre, :apellidos, :dorsal, :posicion, :barcode )");
                    // Bind 
                    $stmt->execute([
                        'nombre' => $jug->getNombre(),
                        'apellidos' => $jug->getApellidos(),
                        'dorsal' => $jug->getDorsal(),
                        'posicion' => $jug->getPosicion(),
                        'barcode' => $jug->getCodigoBarras()
                    ]);
                    $resultado = 0; //Resultado = 0 es que la inserción se ha hecho bien
                    $conexion->commit();
                } catch (PDOException $e) {
                    //Manejo de errores
                    echo 'Ha surgido un error y no se puede realizar la inserción. Detalle: ' . $e->getMessage();
                }
            } else {
                $resultado = 1; //Devuelve 1 si ya existe el codigo de barras
                //echo "Ya existe el codigo de barras";
            }
        } else {
            $resultado = 2; //Devuelve 2 si el  jugador ya existe en la bd
            //echo "El jugador ya existe";
        }

        return $resultado;
    }

    //Para pintar el codigo de barras del usuario con el nº de dorsal que le pasamos
    public static function pintaCodigobarras($dorsal){
        $conexion = new Conexion();
        $cod= '';        
        $resultado = $conexion->query("SELECT barcode FROM jugadores where dorsal = $dorsal");
        //Si el producto existe se mete al while y pongo el booleano a true    
        while ($registro = $resultado->fetch()) {
            $cod = $registro[0];         
        }

        //Objeto DNS1D, le paso el barcode obtenido de la base de datos y lo imprimo con echo
        $d = new DNS1D();
        $d->setStorPath(__DIR__.'/cache/');
        echo $d->getBarcodeHTML($cod, 'EAN13'); 

    }

    //Devuelve un litado con todos los jugadores que existan
    public function listadoJugadores(){
        $conexion = new Conexion();
        $existe = false;        
        $resultado = $conexion->query("SELECT * FROM jugadores");
        while ($registro = $resultado->fetch()) {
            echo $registro[0], $registro[1], $registro[2],$registro[3],$registro[4], Jugador::pintaCodigobarras($registro[3]);
        }
    }


    //Devuelve en formato String los atributos del objeto
    public function __toString(){
        echo $this->nombre ;
        echo "<br>";
        echo $this->apellidos ;
        echo "<br>";
        echo $this->posicion;
        echo "<br>";
        echo $this->dorsal;
        echo "<br>";
        echo $this ->codigoBarras;

    }

   

  
}
