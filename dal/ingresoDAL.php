<?php

require 'conexion.php';

function listingreso() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT i.idingreso, i.fecha, i.hora, i.idproveedor,p.razonsocial, p.contacto,i.documento, i.numerodocu FROM ingreso i left join proveedor p on i.idproveedor=p.idproveedor order by idingreso desc');
    $data = $data->fetchAll();
    return $data;
}

function listDetallep($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT p.codigobarras, p.idproducto, p.producto, d.cantidad, d.costo, d.venta, p.tope FROM detalleingresop d left join productos p on p.idproducto=d.idproducto where d.idingreso=:id');
    $data->execute(array(':id' => $id));
    $data = $data->fetchAll();
    return $data;
}

function insertingreso($fecha, $hora, $id, $doc, $numDoc, $productos, $inicio) {
    $gdb = getConnection();
    //$gdb->beginTransaction();

    $data = $gdb->prepare('INSERT INTO ingreso(fecha,hora,idproveedor,documento,numerodocu)VALUES(:fecha,:hora,:idProveedor,:doc,:numDoc)');
    $exito = $data->execute(array(':fecha' => $fecha, ':hora' => $hora, ':idProveedor' => $id, ':doc' => $doc, ':numDoc' => $numDoc));
    if ($exito) {
        $insertId = $gdb->lastInsertId();
    } else {
        $insertId = '';
    }
    for ($i = 0; $i < count($productos); ++$i) {
        $estado = "1";
        $idTienda = "1";
        $idMontura=$productos[$i][0];
        $sent = $gdb->prepare('INSERT INTO monturas(idmonturas,marca,modelo,tipo,color,estuche,comentario,costo,venta,tope,idIngreso,estado,idTienda) values(:idmonturas,:marca,:modelo,:tipo,:color,:estuche,:comentario,:costo,:venta,:tope,:idIngreso,:estado,:idTienda)');
        $exito = $sent->execute(array(':idmonturas' => $idMontura, ':marca' => $productos[$i][1], ':modelo' => $productos[$i][2], ':tipo' => $productos[$i][3], ':color' => $productos[$i][4], ':estuche' => $productos[$i][5], ':comentario' => $productos[$i][6], ':costo' => $productos[$i][7], ':venta' => $productos[$i][8], ':tope' => $productos[$i][9], ':idIngreso' => $insertId, ':estado' => $estado, ':idTienda' => $idTienda));

        $sent = $gdb->prepare('insert into detalleingreso(idingreso, idMontura) values(:idI, :idP)');
        $exito = $sent->execute(array(':idI' => $insertId, ':idP' => $idMontura));

        //$data = $gdb->prepare('select cantalmacen FROM productos where idproducto=:id');
        //$data->execute(array(':id' => $productos[$i][1]));
        //$cantidadP = $data->fetchAll();
        //$cantidadP[0][0]=$cantidadP[0][0]+$productos[$i][3];

        $sent = $gdb->prepare('update parametros set descripcion=:inicio WHERE idparametro=1');
        $exito = $sent->execute(array(':inicio' => ($inicio-1)));
        
        $sent = $gdb->prepare('insert into historialmovimiento(idmonturas, fecha, hora, indicador, idtiendaubi)'
                . 'values(:id, CURRENT_DATE, curTime(), :indicador, :idtiendaubi)');
        $exito = $sent->execute(array(':id' => $idMontura, ':indicador' => 'INGRESO', ':idtiendaubi' => $idTienda));
        
    }
    //$gdb->rollBack();
    return $exito;
}
function insertingresop($fecha, $hora, $id, $doc, $numDoc, $productos) {
    $gdb = getConnection();

    $data = $gdb->prepare('INSERT INTO ingresop(fecha,hora,idproveedor,documento,numerodocu)VALUES(:fecha,:hora,:idProveedor,:doc,:numDoc)');
    $exito = $data->execute(array(':fecha' => $fecha, ':hora' => $hora, ':idProveedor' => $id, ':doc' => $doc, ':numDoc' => $numDoc));
    if ($exito) {
        $insertId = $gdb->lastInsertId();
    } else {
        $insertId = '';
    }
    for ($i = 0; $i < count($productos); ++$i) {
        $sent = $gdb->prepare('insert into detalleingresop(idingreso, idproducto, cantidad, costo, venta, tope) values(:idI, :idP, :cant, :costo, :venta, :tope)');
        $exito = $sent->execute(array(':idI' => $insertId, ':idP' => $productos[$i][1], ':cant' => $productos[$i][3], ':costo' => $productos[$i][4], ':venta' => $productos[$i][5], ':tope' => $productos[$i][6]));

        $data = $gdb->prepare('select cantalmacen FROM productos where idproducto=:id');
        $data->execute(array(':id' => $productos[$i][1]));
        $cantidadP = $data->fetchAll();
        
        $cantidadP[0][0]=$cantidadP[0][0]+$productos[$i][3];
        
        $sent = $gdb->prepare('update productos set costo=:costo, venta=:venta, tope=:tope, cantalmacen=:ca WHERE idproducto=:id');
        $exito = $sent->execute(array(':costo' => $productos[$i][4], ':venta' => $productos[$i][5], ':tope' => $productos[$i][6], ':ca' => $cantidadP[0][0], ':id' => $productos[$i][1]));
    }
    return $exito;
}
function getingresop($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT i.idingreso, i.fecha, i.hora, i.idproveedor,p.razonsocial,i.documento, i.numerodocu FROM ingresop i left join proveedor p on i.idproveedor=p.idproveedor where i.idingreso=:id');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

?>
