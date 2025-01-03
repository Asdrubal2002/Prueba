<?php 
include_once '../configuraciones/bd.php';
$conexionBD=BD::crearInstancia();

$personaid = isset($_POST['personaid']) ? $_POST['personaid'] : '';
$dni=isset($_POST['dni'])?$_POST['dni']:'';
$nombre=isset($_POST['nombre'])?$_POST['nombre']:'';
$fecha_nacimiento=isset($_POST['fecha_nacimiento'])?$_POST['fecha_nacimiento']:'';
$direccion=isset($_POST['direccion'])?$_POST['direccion']:'';
$telefono=isset($_POST['telefono'])?$_POST['telefono']:'';
$accion=isset($_POST['accion'])?$_POST['accion']:'';

$horarios=isset($_POST['horarios'])?$_POST['horarios']:'';   

//print_r($_POST);

if($accion!=''){

    switch($accion){
        case 'agregar':
            $dni = $_POST['dni'] ?? null;
            $nombre = $_POST['nombre'] ?? null;
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
            $direccion = $_POST['direccion'] ?? null;
            $telefono = $_POST['telefono'] ?? null;
            $horarioid = $_POST['horarioid'] ?? null;
        
            if (!$dni || !$nombre || !$fecha_nacimiento || !$direccion || !$telefono || !$horarioid) {
                die("Error: Todos los campos son obligatorios.");
            }
        
            try {
                $sql = "INSERT INTO tbl_personas (dni, nombre, fecha_nacimiento, direccion, telefono) 
                        VALUES (:dni, :nombre, :fecha_nacimiento, :direccion, :telefono)";
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
        
                $sql = "INSERT INTO horario_persona (personaid, horarioid) VALUES (:personaid, :horarioid)";
                $consulta = $conexionBD->prepare($sql);
                $consulta->bindParam(':personaid', $idPersona);
                $consulta->bindParam(':horarioid', $horarioid);
        
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
                
                $sql = "SELECT * FROM tbl_personas WHERE personaid=:personaid";
                $consulta = $conexionBD->prepare($sql);
                $consulta->bindParam(':personaid', $personaid);
                $consulta->execute();
                $persona = $consulta->fetch(PDO::FETCH_ASSOC);
                $personaid = $persona['personaid'];
                
                $nombre = $persona['nombre'];
                $dni = $persona['dni'];
                $fecha_nacimiento= $persona['fecha_nacimiento'];

                $telefono= $persona['telefono'];
                $direccion= $persona['direccion'];

                $sql = "SELECT * FROM horario_persona WHERE personaid = :personaid";
                $consulta = $conexionBD->prepare($sql); 
                $consulta->bindParam(':personaid', $personaid, PDO::PARAM_INT); 
                $consulta->execute(); 
                $horariosPersona = $consulta->fetchAll(PDO::FETCH_ASSOC); 
                
                foreach ($horariosPersona as $horario) {
                    $horarioEscogido=$horario['horarioid'];
                }

            break;
            
            case 'borrar':
                $sql="DELETE FROM tbl_personas WHERE personaid=:personaid";
                $consulta=$conexionBD->prepare($sql);
                $consulta->bindParam(':personaid',$personaid);
                $consulta->execute();
            break;

            case 'editar':
                if (isset($_POST['personaid'])) {
                    $personaid = $_POST['personaid'];
            
                    $sql = "SELECT * FROM tbl_personas WHERE personaid = :personaid";
                    $consulta = $conexionBD->prepare($sql);
                    $consulta->bindParam(':personaid', $personaid);
                    $consulta->execute();
                    $persona = $consulta->fetch(PDO::FETCH_ASSOC);
            
                    if ($persona) {
                        $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
                        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
                        $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';
                        $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
                        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
            
                        $sql = "UPDATE tbl_personas 
                                SET dni = :dni, nombre = :nombre, fecha_nacimiento = :fecha_nacimiento, direccion = :direccion, telefono = :telefono
                                WHERE personaid = :personaid";
            
                        $consulta = $conexionBD->prepare($sql);
                        $consulta->bindParam(':dni', $dni);
                        $consulta->bindParam(':nombre', $nombre);
                        $consulta->bindParam(':fecha_nacimiento', $fecha_nacimiento);
                        $consulta->bindParam(':direccion', $direccion);
                        $consulta->bindParam(':telefono', $telefono);
                        $consulta->bindParam(':personaid', $personaid);
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
            INNER JOIN horario_persona hp ON h.horarioid = hp.horarioid 
            WHERE hp.personaid = :personaid";
    $consulta=$conexionBD->prepare($sql);
    $consulta->bindParam(':personaid',$persona['personaid']);
    $consulta->execute();
    $horariosPersona=$consulta->fetchAll();
    $personas[$clave]['horarios']=$horariosPersona;
}

$sql="SELECT * FROM horarios";
$listaHorarios=$conexionBD->query($sql);
$horarios=$listaHorarios->fetchAll();



?>
