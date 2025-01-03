<?php include('../templates/header.php'); ?>
<?php include('horarios.php'); ?>

<div class="col-md-5">

    <form action="" method="post">
        <div class="card">
            <div class="card-header">Horarios</div>
            <div class="card-body">

                <div class="mb-3">
                    <label for="" class="form-label">ID</label>
                    <input type="text" class="form-control" name="horarioid" id="horarioid" value="<?php echo $horarioid;?>" aria-describedby="helpId"
                        placeholder="" />
                </div>

                <div class="mb-3">
                    <label for="horario" class="form-label">Horario</label>
                    <input type="text" class="form-control" name="horario" id="horario" value="<?php echo $horario;?>" aria-describedby="helpId"
                        placeholder="" />
                </div>
                <div class="btn-group" role="group" aria-label="Button group name">
                    <button type="submit" name="accion" value="agregar" class="btn btn-success">
                        Añadir
                    </button>
                    <button type="submit" name="accion" value="editar" class="btn btn-warning">
                        Editar
                    </button>
                    <button type="submit" name="accion" value="borrar" class="btn btn-danger">
                        Eliminar
                    </button>
                </div>

            </div>
        </div>

    </form>
</div>

<div class="col-md-7">
<div
    class="table-responsive"
>
    <table
        class="table"
    >
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Horario</th>
                <th scope="col">acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaHorarios as $horario){?>
            <tr class="">
                <td> <?php echo $horario['horarioid']; ?> </td>
                <td><?php echo $horario['horario']; ?> </td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="horarioid" id="horarioid" value="<?php echo $horario['horarioid']; ?>">
                        <input type="submit" value="Seleccionar" name="accion" class="btn btn-info">
                    </form>

                </td>
            </tr>
            <?php } ?>
           
        </tbody>
    </table>
</div>


</div>




<?php include('../templates/footer.php'); ?>
