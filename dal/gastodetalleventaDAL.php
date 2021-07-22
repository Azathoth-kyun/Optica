<?php
require 'conexion.php';
session_start();

function getDetalleGasto($idgasto) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT g.idgasto, g.fecharegistro, g.fecha, g.serie, g.correlativo, g.monto, g.idproveedor, g.descripcion, g.iddetalle, g.observacion, g.tipodocumento, g.editar 
    FROM gasto g WHERE g.iddetalle=:iddetalle;');
    $data->execute(array(':iddetalle' => $idgasto));
    $data = $data->fetchAll();
    return $data;
}

function SaveGastosDetalle($iddetalle, $idgastodetalle, $fecha, $serie, $correlativo, $costo, $idproveedor, $descripcion, $tienda, $observacion, $tipodocumento) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into gasto(idcategoria, fecharegistro, fecha, serie, correlativo, monto, idproveedor, descripcion, iddetalle, idusuario, idtienda, observacion, tipodocumento) 
        values(5, CURRENT_DATE, :fecha, :serie, :correlativo, :costo, :idproveedor, :descripcion, :iddetalle, :idusuario, :idtienda, :observacion, :tipodocumento);');
    $exito = $sent->execute(array(':fecha' => $fecha, ':serie' => $serie, ':correlativo' => $correlativo, ':costo' => $costo, ':idproveedor' => $idproveedor, 
        ':descripcion' => $descripcion, ':iddetalle' => $iddetalle, ':idusuario' => $_SESSION['userID'], ':idtienda' => $tienda, ':observacion' => $observacion, ':tipodocumento' => $tipodocumento));
    
    $sent = $gdb->prepare('update detalleventa set isgasto = 1 where iddetalle = :iddetalle');
    $exito = $sent->execute(array(':iddetalle' => $iddetalle));
    return $exito;
}

function UpdateGastosDetalle($iddetalle, $idgastodetalle, $fecha, $serie, $correlativo, $costo, $idproveedor, $descripcion, $observacion, $tipodocumento) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update gasto set fecha = :fecha, idproveedor = :idproveedor, serie = :serie, '
            . ' correlativo = :numero, monto = :costo, observacion = :observacion, tipodocumento=:tipodocumento where iddetalle = :iddetalle');
    $exito = $sent->execute(array(':fecha' => $fecha, ':idproveedor' => $idproveedor, ':serie' => $serie, 
                ':numero' => $correlativo, ':costo' => $costo, ':iddetalle' => $iddetalle, ':observacion' => $observacion, ':tipodocumento' => $tipodocumento));
    return $exito;
}

function DeleteGastosDetalle($iddetalle) {
    $gdb = getConnection();
    $sent = $gdb->prepare('delete from gasto where iddetalle = :iddetalle');
    $exito = $sent->execute(array(':iddetalle' => $iddetalle));
    $sent = $gdb->prepare('update detalleventa set isgasto = 0 where iddetalle = :iddetalle');
    $exito = $sent->execute(array(':iddetalle' => $iddetalle));
    return $exito;
}

function SaveGastosGOP($idgasto, $fecha, $serie, $correlativo, $costo, $idproveedor, $descripcion, $tienda, $observacion, $venta) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into gasto(idcategoria, fecharegistro, fecha, serie, correlativo, monto, idproveedor, descripcion, idusuario, idtienda, observacion, idventa) 
        values(5, CURRENT_DATE, :fecha, :serie, :correlativo, :costo, :idproveedor, :descripcion, :idusuario, :idtienda, :observacion, :idventa);');
    $exito = $sent->execute(array(':fecha' => $fecha, ':serie' => $serie, ':correlativo' => $correlativo, ':costo' => $costo, ':idproveedor' => $idproveedor, ':descripcion' => $descripcion, ':idusuario' => $_SESSION['userID'], ':idtienda' => $tienda, ':observacion' => $observacion, ':idventa' => $venta));
    $insertId = $gdb->lastInsertId();
    return $insertId;
}

function UpdateGastosGOP($idgasto, $fecha, $serie, $correlativo, $costo, $idproveedor, $descripcion, $tienda, $observacion, $venta) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update gasto set fecha = :fecha, idproveedor = :idproveedor, serie = :serie, '
            . ' correlativo = :numero, monto = :costo, observacion=:observacion, descripcion=:descripcion where idgasto = :idgasto');
    $exito = $sent->execute(array(':fecha' => $fecha, ':idproveedor' => $idproveedor, ':serie' => $serie, 
                ':numero' => $correlativo, ':costo' => $costo, ':observacion' => $observacion, ':descripcion' => $descripcion, ':idgasto' => $idgasto));
    return $exito;
}

function habilitareditar($idgasto) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update gasto set editar=1 where idgasto=:idgasto;');
    $exito = $sent->execute(array(':idgasto' => $idgasto));
    
    return $exito;
}

function pedidorealizado($idventa) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update venta set estadopedido = 1 where idventa = :idventa');
    $exito = $sent->execute(array(':idventa' => $idventa));
    return $exito;
}

function llamadarealizada($idventa) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update venta set estadollamada = 1 where idventa = :idventa');
    $exito = $sent->execute(array(':idventa' => $idventa));
    return $exito;
}
?>