
<!--Vista muy sencilla, contiene el botón de instalar que lleva a crearDatos.php. Ahí genero
datos aleatorios que luego inserto en la base de datos -->
@extends('plantillas.plantilla1')
@section('titulo')
{{$titulo}}
@endsection
@section('encabezado')
{{$encabezado}}
@endsection
@section('contenido')

<form name="formulario1" action="crearDatos.php" method="POST">
    <div class="container">
        <div class="col-xs-3 text-center">
            <form action="metodos.php" method="POST">
            <input type="submit" value="Instalar datos de ejemplo" name="instalar" class="btn btn-success">
            </form>
        </div>
    </div>
</form>
@endsection