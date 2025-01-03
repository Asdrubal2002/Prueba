<?php include('../templates/header.php'); ?>
<?php include('personas.php'); ?>


<div class="col-md-5">
    <form action="" method="post">
        <div class="card">
            <div class="card-header">Alumnos</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="dni" class="form-label">Identificación</label>
                    <input type="text" class="form-control" value="<?php echo $dni;?>" name="dni" id="dni"
                        aria-describedby="helpId" placeholder="" />
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" value="<?php echo $nombre;?>" name="nombre" id="nombre"
                        aria-describedby="helpId" placeholder="" />
                </div>


                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                    <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento"
                        value="<?php echo $fecha_nacimiento;?>" aria-describedby="helpId" placeholder="" />
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" name="direccion" id="direccion"
                        value="<?php echo $direccion;?>" aria-describedby="helpId" placeholder="" />
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" name="telefono" id="telefono"
                        value="<?php echo $telefono;?>" aria-describedby="helpId" placeholder="" />
                </div>

                <div class="mb-3">
                    <label for="listaHorarios" class="form-label">Horarios</label>
                    <select class="form-control" name="horarioID" id="listaHorarios" required>
                        <?php foreach ($horarios as $horario) { ?>
                        <option value="<?php echo $horario['horarioID']; ?>" <?php 
                            // Si el horario actual coincide con el horario escogido, se marca como seleccionado
                            if ($horario['horarioID'] == $horarioEscogido) {
                                echo 'selected';
                            }
                                ?>>
                            <?php echo $horario['horarioID']; ?> - <?php echo htmlspecialchars($horario['horario']); ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="btn-group" role="group" aria-label="Button group name">
                <input type="hidden" name="personaID" value="<?php echo $persona['personaID']; ?>">
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
<div class="col-7">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Identificación</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($personas as $persona):?>
                <tr>
                    <td><?php echo $persona['dni'];?></td>
                    <td>
                        <?php echo $persona['nombre'];?>

                        <?php foreach($persona["horarios"] as $horario){ ?>
                        <br>
                        - <strong><?php echo $horario['horario']; ?></strong>

                        <?php    } ?>

                    </td>
                    <td>

                        <form action="" method="post">
                            <input type="hidden" name="personaID" id="personaID"
                                value="<?php echo $persona['personaID']; ?>">
                            <input type="submit" value="Seleccionar" name="accion" class="btn btn-info">
                        </form>



                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>

</div>


<?php include('../templates/footer.php'); ?>