<?php
require '../dal/gastodetalleventaDAL.php';
$action = $_POST['action'];
switch ($action) {
    case 'getDetalleGasto':
        $id = $_POST['iddetalle'];
        $fila = getDetalleGasto($id);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'SaveGastosDetalle':
        $iddetalle = $_POST['iddetalle'];
        $idgastodetalle = $_POST['idgastodetalle'];
        $fecha = $_POST['fecha'];
        $serie = $_POST['serie'];
        $correlativo = $_POST['correlativo'];
        $costo = $_POST['costo'];
        $idproveedor = $_POST['idproveedor'];
        $descripcion = $_POST['descripcion'];
        $observacion = $_POST['observacion'];
        $tipodocumento = $_POST['tipodocumento'];
        $tienda = $_POST['tienda'];
        
        $exito = SaveGastosDetalle($iddetalle, $idgastodetalle, $fecha, $serie, $correlativo, $costo, $idproveedor, $descripcion, $tienda, $observacion, $tipodocumento);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'UpdateGastosDetalle':
        $iddetalle = $_POST['iddetalle'];
        $idgastodetalle = $_POST['idgastodetalle'];
        $fecha = $_POST['fecha'];
        $serie = $_POST['serie'];
        $correlativo = $_POST['correlativo'];
        $costo = $_POST['costo'];
        $idproveedor = $_POST['idproveedor'];
        $observacion = $_POST['observacion'];
        $tipodocumento = $_POST['tipodocumento'];
        $descripcion = $_POST['descripcion'];
        
        $exito = UpdateGastosDetalle($iddetalle, $idgastodetalle, $fecha, $serie, $correlativo, $costo, $idproveedor, $descripcion, $observacion, $tipodocumento);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'DeleteGastosDetalle':
        $iddetalle = $_POST['iddetalle'];
        
        $exito = DeleteGastosDetalle($iddetalle);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'SaveGastosGOP':
        $idgasto = $_POST['idgasto'];
        $fecha = $_POST['fecha'];
        $serie = $_POST['serie'];
        $correlativo = $_POST['correlativo'];
        $costo = $_POST['costo'];
        $idproveedor = $_POST['idproveedor'];
        $descripcion = $_POST['descripcion'];
        $tienda = $_POST['tienda'];
        $observacion = $_POST['observacion'];
        $venta = $_POST['venta'];
        
        $exito = SaveGastosGOP($idgasto, $fecha, $serie, $correlativo, $costo, $idproveedor, $descripcion, $tienda, $observacion, $venta);
        print($exito);
        break;
    case 'UpdateGastosGOP':
        $idgasto = $_POST['idgasto'];
        $fecha = $_POST['fecha'];
        $serie = $_POST['serie'];
        $correlativo = $_POST['correlativo'];
        $costo = $_POST['costo'];
        $idproveedor = $_POST['idproveedor'];
        $descripcion = $_POST['descripcion'];
        $tienda = $_POST['tienda'];
        $observacion = $_POST['observacion'];
        $venta = $_POST['venta'];
        
        $exito = UpdateGastosGOP($idgasto, $fecha, $serie, $correlativo, $costo, $idproveedor, $descripcion, $tienda, $observacion, $venta);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'habilitareditar':
        $idgasto = $_POST['idgasto'];
        
        $exito = habilitareditar($idgasto);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'pedidorealizado':
        $idventa = $_POST['idventa'];
        
        $exito = pedidorealizado($idventa);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'llamadarealizada':
        $idventa = $_POST['idventa'];
        
        $exito = llamadarealizada($idventa);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
}
?>