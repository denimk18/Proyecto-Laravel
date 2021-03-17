<!--Vista de crear jugadores. Extiende de la plantilla principal, plantilla1-->

<?php $__env->startSection('titulo'); ?>
<?php echo e($titulo); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('encabezado'); ?>
<?php echo e($encabezado); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>

<?php
require_once('crearJugador.php');
?>
<!--Manejo los datos en un formulario el cuál manda la info por POST. Lo mando fcrear.php donde proceso
los datos-->
<br>
<br>
<br>
<form name="formulario1" action="crearJugador.php" method="POST">
   <div class="container">
      <div class="col-xs-4">
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="nombre">Nombre</label>
               <div class="input-group mb-3">
                  <input type="text" class="form-control" id="nombre" name="nombre" required>
               </div>
            </div>
            <div class="form-group col-md-6">
               <label for="apellidos">Apellidos</label>
               <div class="input-group mb-3">
                  <input type="text" class="form-control" id="apellidos" name="apellidos" required>
               </div>
            </div>

            <div class="row">
               <div class="form-group col-sm-4">
                  <label for="dorsal">Dorsal</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                     </div>
                     <input type="number" min="1" max="999999999" class="form-control" id="dorsal" name="dorsal" required>
                  </div>
               </div>

               <div class="form-group col-sm-4">
                  <label for="posicion">Posici&oacute;n</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                     </div>
                     <select name="posicion" class="form-control" placeholder="Seleccione posición" required>
                        <option value="Portero">Portero</option>
                        <option value="Defensa">Defensa</option>
                        <option value="Lateral Izquierdo">Lateral Izquierdo</option>
                        <option value="Lateral Derecho">Lateral Derecho</option>
                        <option value="Central">Central</option>
                        <option value="Delantero">Delantero</option>
                     </select>
                  </div>
               </div>

               <div class="form-group col-sm-4">
                  <label for="codigoBarras">C&oacute;digo de barras</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                     </div>
                     <!--En este campo pinto el código que he generado. Dicho código lo almaceno en una variable de sesión llamada codigoGenerado, de manera
                     que puedo operar con él a través de las distintas páginas. En este input, compruebo si dicha variable de sesión contiene datos, y si los
                     tiene, llamo al método pintaCodBarras creado en crearJugador.php, el cual se encarga de pintarlo en formato HTML. -->
                     <input type="text"  readonly class="form-control" id="codBarras" name="codBarras" required value=<?php
                                                                                                                     if (isset($_SESSION['codigoGenerado'])) {
                                                                                                                        pintaCodBarras($_SESSION['codigoGenerado']);
                                                                                                                     }
                                                                                                                     ?>>
                  </div>
               </div>

            </div>
         </div>

         <!----->
         <div class="pomodoro">
            <div class="action"></div>
            <div class="time"></div>
            <div id="contenedor">
               <input type="submit" value="Crear" name="crear" class="btn btn-primary">
               <input type="reset" value="Limpiar" class="btn btn-success" />
               <input type="submit" value="Volver" name="volverDeCrear" class="btn btn-info" formnovalidate="">
               <!--Aunque es un enlace a generarCode que contiene los métodos necesarios para generar
         el código jugador, generarCode.php contiene un Location header que vuelve a mandar al usuario 
         a esta misma página (fcrear.php), de manera que visualmente no parezca que se ha hecho el 
         cambio de página. -->

               <a href="generarCode.php"><input style="background-color: #C0C0C0"  type="button" class="btn btn-default" value="Generar c&oacute;digo" name="generarCodigo"></a>
            </div>
         </div>
      </div>
      <!----->
   </div>


</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.plantilla1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\tema5\views/vcrear.blade.php ENDPATH**/ ?>