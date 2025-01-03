<?php 

include_once '../configuraciones/bd.php';
$conexionBD=BD::crearInstancia();


$horarioID=isset($_POST['horarioID'])?$_POST['horarioID']:'';
$horario=isset($_POST['horario'])?$_POST['horario']:'';
$accion=isset($_POST['accion'])?$_POST['accion']:'';

//print_r($_POST);

if($accion!=''){
    switch($accion){
        case 'agregar':
            $sql="INSERT INTO horarios (horarioID, horario) VALUES (NULL,:horario)";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':horario',$horario);
            $consulta->execute();
            break;

        case 'editar':
            $sql="UPDATE horarios SET horario=:horario WHERE horarioID=:horarioID";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':horarioID',$horarioID);
            $consulta->bindParam(':horario',$horario);
            $consulta->execute();
            echo $sql;
        break;

        case 'borrar':
            $sql="DELETE FROM horarios WHERE horarioID=:horarioID";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':horarioID',$horarioID);
            $consulta->execute();
            echo $sql;
        break;

        case 'Seleccionar':
            $sql="SELECT * FROM horarios WHERE horarioID=:horarioID";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':horarioID',$horarioID);
            $consulta->execute();
            $horario=$consulta->fetch(PDO::FETCH_ASSOC);
            $horario=$horario['horario'];
            
        break;

    }
}


$consulta=$conexionBD->prepare("SELECT * FROM horarios ");
$consulta->execute();
$listaHorarios=$consulta->fetchAll();

?>