<?php 
include_once '../configuraciones/bd.php';
$conexionBD=BD::crearInstancia();

$personaID = isset($_POST['personaID']) ? $_POST['personaID'] : '';
$dni=isset($_POST['dni'])?$_POST['dni']:'';
$nombre=isset($_POST['nombre'])?$_POST['nombre']:'';
$fecha_nacimiento=isset($_POST['fecha_nacimiento'])?$_POST['fecha_nacimiento']:'';
$direccion=isset($_POST['direccion'])?$_POST['direccion']:'';
$telefono=isset($_POST['telefono'])?$_POST['telefono']:'';
$accion=isset($_POST['accion'])?$_POST['accion']:'';

$horarios=isset($_POST['horarios'])?$_POST['horarios']:'';   

//print_r($_POST['accion']);

if($accion!=''){

    switch($accion){
        case 'agregar':
            $dni = $_POST['dni'] ?? null;
            $nombre = $_POST['nombre'] ?? null;
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
            $direccion = $_POST['direccion'] ?? null;
            $telefono = $_POST['telefono'] ?? null;
            $horarioID = $_POST['horarioID'] ?? null;
        
            if (!$dni || !$nombre || !$fecha_nacimiento || !$direccion || !$telefono || !$horarioID) {
                die("Error: Todos los campos son obligatorios.");
            }
        
            try {
                $sql = "INSERT INTO tbl_personas (personaID, dni, nombre, fecha_nacimiento, direccion, telefono) 
                        VALUES (NULL, :dni, :nombre, :fecha_nacimiento, :direccion, :telefono)";
                $consulta = $conexionBD->prepare($sql);
                $consulta->bindParam(':dni', $dni);
                $consulta->bindParam(':nombre', $nombre);
                $consulta->bindParam(':fecha_nacimiento', $fecha_nacimiento);
                $consulta->bindParam(':direccion', $direccion);
                $consulta->bindParam(':telefono', $telefono);
        
                if (!$consulta->execute()) {
                    print_r($consulta->errorInfo());
                    die("Error al insertar en tbl_personas.");
                }
        
                $idPersona = $conexionBD->lastInsertId();
        
                $sql = "INSERT INTO horario_persona (id, personaID, horarioID) VALUES (NULL, :personaID, :horarioID)";
                $consulta = $conexionBD->prepare($sql);
                $consulta->bindParam(':personaID', $idPersona);
                $consulta->bindParam(':horarioID', $horarioID);
        
                if (!$consulta->execute()) {
                    print_r($consulta->errorInfo());
                    die("Error al insertar en horario_persona.");
                }
        
                echo "Registro agregado correctamente.";
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
            break;
        

            case 'Seleccionar':
                
                $sql = "SELECT * FROM tbl_personas WHERE personaID=:personaID";
                $consulta = $conexionBD->prepare($sql);
                $consulta->bindParam(':personaID', $personaID);
                $consulta->execute();
                $persona = $consulta->fetch(PDO::FETCH_ASSOC);
                $personaID = $persona['personaID'];
                
                $nombre = $persona['nombre'];
                $dni = $persona['dni'];
                $fecha_nacimiento= $persona['fecha_nacimiento'];

                $telefono= $persona['telefono'];
                $direccion= $persona['direccion'];

                $sql = "SELECT * FROM horario_persona WHERE personaID = :personaID";
                $consulta = $conexionBD->prepare($sql); 
                $consulta->bindParam(':personaID', $personaID, PDO::PARAM_INT); 
                $consulta->execute(); 
                $horariosPersona = $consulta->fetchAll(PDO::FETCH_ASSOC); 
                
                foreach ($horariosPersona as $horario) {
                    $horarioEscogido=$horario['horarioID'];
                }

            break;
            
            case 'borrar':
                $sql="DELETE FROM tbl_personas WHERE personaID=:personaID";
                $consulta=$conexionBD->prepare($sql);
                $consulta->bindParam(':personaID',$personaID);
                $consulta->execute();
            break;

            case 'editar':
                // Verificar si personaID está presente en $_POST
                if (isset($_POST['personaID'])) {
                    $personaID = $_POST['personaID'];
            
                    // Consultar la persona a editar
                    $sql = "SELECT * FROM tbl_personas WHERE personaID = :personaID";
                    $consulta = $conexionBD->prepare($sql);
                    $consulta->bindParam(':personaID', $personaID);
                    $consulta->execute();
                    $persona = $consulta->fetch(PDO::FETCH_ASSOC);
            
                    if ($persona) {
                        // Obtener los valores a actualizar (de los campos del formulario)
                        $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
                        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
                        $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';
                        $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
                        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
            
                        // Ejecutar la actualización
                        $sql = "UPDATE tbl_personas 
                                SET dni = :dni, nombre = :nombre, fecha_nacimiento = :fecha_nacimiento, direccion = :direccion, telefono = :telefono
                                WHERE personaID = :personaID";
            
                        $consulta = $conexionBD->prepare($sql);
                        $consulta->bindParam(':dni', $dni);
                        $consulta->bindParam(':nombre', $nombre);
                        $consulta->bindParam(':fecha_nacimiento', $fecha_nacimiento);
                        $consulta->bindParam(':direccion', $direccion);
                        $consulta->bindParam(':telefono', $telefono);
                        $consulta->bindParam(':personaID', $personaID);
                        $consulta->execute();
            
                        echo "Persona actualizada correctamente.";
                    } else {
                        echo "Persona no encontrada.";
                    }
                } else {
                    echo "ID de persona no recibido.";
                }
                break;
            
    }

}
$sql="SELECT * FROM tbl_personas";
$listaPersonas=$conexionBD->query($sql);
$personas=$listaPersonas->fetchAll();

foreach($personas as $clave => $persona){
    $sql = "SELECT h.* 
            FROM horarios h 
            INNER JOIN horario_persona hp ON h.horarioID = hp.horarioID 
            WHERE hp.personaID = :personaID";
    $consulta=$conexionBD->prepare($sql);
    $consulta->bindParam(':personaID',$persona['personaID']);
    $consulta->execute();
    $horariosPersona=$consulta->fetchAll();
    $personas[$clave]['horarios']=$horariosPersona;
}

$sql="SELECT * FROM horarios";
$listaHorarios=$conexionBD->query($sql);
$horarios=$listaHorarios->fetchAll();



?>