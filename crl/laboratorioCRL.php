<?php
require '../dal/laboratorioDAL.php';
$action = $_POST['action'];
switch ($action) {
    case 'listLaboratorios':
        $fila = listLaboratorios();
        print (json_encode($fila));
        break;
    case 'saveLaboratorio':
        $laboratorio = $_POST['laboratorio'];
        
        $estado = $_POST['estado'];
        
        $exito = saveLaboratorio($laboratorio, $estado);
        
        $res;
        if ($exito) {
            $res=array('resultado' => 'OK');
        } else {
            $res=array('resultado' => 'NO');
        }
        print (json_encode($res)); 
        break;
    case 'updateLaboratorio':
        $laboratorio = $_POST['laboratorio'];
        $idproclab = $_POST['idprodlab'];
        
        $estado = $_POST['estado'];
        
        $exito = updateLaboratorio($idproclab, $laboratorio, $estado);
        
        $res;
        if ($exito) {
            $res=array('resultado' => 'OK');
        } else {
            $res=array('resultado' => 'NO');
        }
        print (json_encode($res)); 
        break;
    
    case 'listProductos':
        $padre = $_POST['padre'];
        $fila = listProductos($padre);
        print (json_encode($fila));
        break;
    case 'saveProducto':
        $producto = $_POST['producto'];
        $padre = $_POST['padre'];
        $estado = $_POST['estado'];
        $comision = $_POST['comision'];
        
        $exito = saveProducto($producto, $estado, $padre, $comision);
        
        $res;
        if ($exito) {
            $res=array('resultado' => 'OK');
        } else {
            $res=array('resultado' => 'NO');
        }
        print (json_encode($res)); 
        break;
    case 'updateProducto':
        $producto = $_POST['producto'];
        $idprodlab = $_POST['idprodlab'];
        $padre = $_POST['padre'];
        $estado = $_POST['estado'];
        $comision = $_POST['comision'];
        
        $exito = updateProducto($idprodlab, $producto, $estado, $padre, $comision);
        
        $res;
        if ($exito) {
            $res=array('resultado' => 'OK');
        } else {
            $res=array('resultado' => 'NO');
        }
        print (json_encode($res)); 
        break;
    case 'listDetalle':
        $padre = $_POST['padre'];
        $fila = listDetalle($padre);
        print (json_encode($fila));
        break;
    case 'saveDetalle':
        $detalle = $_POST['detalle'];
        $padre = $_POST['padre'];
        $estado = $_POST['estado'];
        $comision = $_POST['comision'];

        $exito = saveDetalle($detalle, $estado, $padre, $comision);
        
        $res;
        if ($exito) {
            $res=array('resultado' => 'OK');
        } else {
            $res=array('resultado' => 'NO');
        }
        print (json_encode($res)); 
        break;
    case 'updateDetalle':
        $detalle = $_POST['detalle'];
        $idprodlab = $_POST['idprodlab'];
        $padre = $_POST['padre'];
        $estado = $_POST['estado'];
        $comision = $_POST['comision'];
        
        $exito = updateProducto($idprodlab, $detalle, $estado, $padre, $comision);
        
        $res;
        if ($exito) {
            $res=array('resultado' => 'OK');
        } else {
            $res=array('resultado' => 'NO');
        }
        print (json_encode($res)); 
        break;
}
?>
