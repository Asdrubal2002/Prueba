<?php include('../templates/header.php'); ?>
<?php include('personas.php'); ?>

<?php
if (isset($_POST['accion']) && $_POST['accion'] == 'limpiar') {
    $dni = '';
    $nombre = '';
    $fecha_nacimiento = '';
    $direccion = '';
    $telefono = '';
    $horarioEscogido = '';
    $persona = null;
}
?>

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
                    <select class="form-control" name="horarioid" id="listaHorarios" required>
                        <?php foreach ($horarios as $horario) { ?>
                        <option value="<?php echo $horario['horarioid']; ?>" <?php 
                            if ($horario['horarioid'] == $horarioEscogido) {
                                echo 'selected';
                            }
                                ?>>
                            <?php echo $horario['horarioid']; ?> - <?php echo htmlspecialchars($horario['horario']); ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="btn-group" role="group" aria-label="Button group name">
                    <?php if ($persona != null) { ?>
                    <input type="hidden" name="personaid" value="<?php echo $persona['personaid']; ?>">
                    <?php } ?>
                    <button type="submit" name="accion" value="agregar" class="btn btn-success">
                        Añadir
                    </button>
                    <button type="submit" name="accion" value="editar" class="btn btn-warning"
                        <?php echo ($persona == null ? 'disabled' : ''); ?>>
                        Editar
                    </button>
                    <button type="submit" name="accion" value="borrar" class="btn btn-danger"
                        <?php echo ($persona == null ? 'disabled' : ''); ?>>
                        Eliminar
                    </button>
                    <button type="submit" name="accion" value="limpiar" class="btn btn-info">
                        Limpiar formulario
                    </button>
                </div>

            </div>
        </div>

    </form>
</div>
<div class="col-7">
    <div class="table-responsive">
        
        <input type="text" id="filtroBusqueda" class="form-control" placeholder="Buscar por nombre o identificación"
            onkeyup="filtrarTabla()">
            <br>
        <table class="table" id="tablaPersonas">
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
                        <strong> Censo - <?php echo $horario['horario']; ?></strong>
                        <?php } ?>
                    </td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="personaid" id="personaid"
                                value="<?php echo $persona['personaid']; ?>">
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

<script>
function filtrarTabla() {
    var input, filtro, tabla, tr, td, i, txtValue;
    input = document.getElementById("filtroBusqueda");
    filtro = input.value.toUpperCase();
    tabla = document.getElementById("tablaPersonas");
    tr = tabla.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        if (td.length > 0) {
            txtValue = td[0].textContent || td[0].innerText; 
            if (txtValue.toUpperCase().indexOf(filtro) > -1) {
                tr[i].style.display = "";
            } else {
                txtValue = td[1].textContent || td[1].innerText; 
                if (txtValue.toUpperCase().indexOf(filtro) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}
</script>
