<?php
//Creo una clase conexion que extiende de PDO
namespace Clases;
use PDO;
use PDOException;
class Conexion extends PDO { 
    //Indico los datos para hacer la conexión
    private $tipo_de_base = 'mysql';
    private $host = '127.0.0.1';
    private $nombre_de_base = 'practicaunidad5';
    private $usuario = 'gestor';
    private $contrasena = 'secreto'; 

    //Sobreescribo el método constructor de PDO
    public function __construct() {
       try{
         parent::__construct("{$this->tipo_de_base}:dbname={$this->nombre_de_base};host={$this->host};charset=utf8",
         $this->usuario, $this->contrasena);
       }catch(PDOException $e){
           //Manejo de errores
          echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
          exit;
       }
    } 
  } 


 ?>