<?php 

include_once '../configuraciones/bd.php';
$conexionBD=BD::crearInstancia();


$horarioid=isset($_POST['horarioid'])?$_POST['horarioid']:'';
$horario=isset($_POST['horario'])?$_POST['horario']:'';
$accion=isset($_POST['accion'])?$_POST['accion']:'';

//print_r($_POST);

if($accion!=''){
    switch($accion){
        case 'agregar':
            $sql="INSERT INTO horarios (horarioid, horario) VALUES (NULL,:horario)";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':horario',$horario);
            $consulta->execute();
            break;

        case 'editar':
            $sql="UPDATE horarios SET horario=:horario WHERE horarioid=:horarioid";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':horarioid',$horarioid);
            $consulta->bindParam(':horario',$horario);
            $consulta->execute();
        break;

        case 'borrar':
            $sql="DELETE FROM horarios WHERE horarioid=:horarioid";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':horarioid',$horarioid);
            $consulta->execute();
        break;

        case 'Seleccionar':
            $sql="SELECT * FROM horarios WHERE horarioid=:horarioid";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':horarioid',$horarioid);
            $consulta->execute();
            $horario=$consulta->fetch(PDO::FETCH_ASSOC);
            $horario=$horario['horario'];
            
        break;

    }
}


$consulta=$conexionBD->prepare("SELECT * FROM horarios");
$consulta->execute();
$listaHorarios=$consulta->fetchAll();

?>
