<?php
require '../dal/detallegastosDAL.php';
$action = $_POST['action'];
switch ($action) {
    case 'insertarDetalleGastos':
        $idTipoGasto=$_POST["idTipoGasto"];
        $idGastos=$_POST["idGastos"];
        $fecha=$_POST["fecha"];
        $descripcion=$_POST["descripcion"];
        $observacion=$_POST["observacion"];
        $monto=$_POST["monto"];
        $idTienda=$_POST["idTienda"];
        $detalleGastos = maxdetalleGasto($idGastos);
        if($detalleGastos[0][0]==null){
           $id=1; 
        }
        else{
            $id=$detalleGastos[0][0]+1;
        }
        $exito=insertdetalleGasto($idTipoGasto,$idGastos,$id,$fecha,$descripcion,$observacion,$monto,$idTienda);
        print (json_encode($exito));
        break;
    case 'listarDetallesGastos':
        $idTienda=$_POST["idTienda"];
        $lista=listardetalleGastos($idTienda);
        echo json_encode($lista);
        break;
}       
?>