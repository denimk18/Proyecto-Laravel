<?php $__env->startSection('titulo'); ?>
<?php echo e($titulo); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('encabezado'); ?>
<?php echo e($encabezado); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>

<form name="formulario1" action="crearDatos.php" method="POST">
    <div class="container">
        <div class="col-xs-3 text-center">
            <form action="metodos.php" method="POST">
            <input type="submit" value="Instalar datos de ejemplo" name="instalar" class="btn btn-success">
            </form>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.plantilla1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\tema5\views/vinstalacion.blade.php ENDPATH**/ ?>