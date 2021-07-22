<?php

require 'conexion.php';

function listconceciones() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT idconceciones,fecha,hora,cliente,acambio,estado FROM conceciones;');
    $data = $data->fetchAll();
    return $data;
}

function listDetalle($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT p.codigobarras, p.idproducto, p.producto, d.cantidad FROM detalleconceciones d left join productos p on p.idproducto=d.idproducto where d.idconceciones=:id');
    $data->execute(array(':id' => $id));
    $data = $data->fetchAll();
    return $data;
}

function delconceciones($id) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update conceciones set estado = \'finalizado\' where  idconceciones=:id');
    $exito = $sent->execute(array(':id' => $id));
    $data = $gdb->prepare('select idproducto, cantidad from detalleconceciones where idconceciones=:id');
    $data->execute(array(':id' => $id));
    $prod = $data->fetchAll();
    for ($i = 0; $i < count($prod); ++$i) {
        $data = $gdb->prepare('select canttienda FROM productos where idproducto=:id');
        $data->execute(array(':id' => $prod[$i][0]));
        $cantidadP = $data->fetchAll();

        $cantidadP[0][0] = $cantidadP[0][0] + $prod[$i][1];

        $sent = $gdb->prepare('update productos set canttienda=:ca WHERE idproducto=:id');
        $exito = $sent->execute(array(':ca' => $cantidadP[0][0], ':id' => $prod[$i][0]));
    }
    return $exito;
}

function insertconceciones($fecha, $hora, $responsable, $idPer, $estado, $productos) {
    $gdb = getConnection();
    $data = $gdb->prepare('INSERT INTO conceciones(fecha,hora,cliente,acambio,estado)VALUES(:fecha,:hora,:res,:rec,:est)');
    $result = $data->execute(array(':fecha' => $fecha, ':hora' => $hora, ':res' => $responsable, ':rec' => $idPer, ':est' => $estado));
    if ($result) {
        $insertId = $gdb->lastInsertId();
    } else {
        $insertId = '';
    }
    for ($i = 0; $i < count($productos); ++$i) {
        $sent = $gdb->prepare('insert into detalleconceciones(idconceciones, idproducto, cantidad) values(:idI, :idP, :cant)');
        $exito = $sent->execute(array(':idI' => $insertId, ':idP' => $productos[$i][1], ':cant' => $productos[$i][3]));

        $data = $gdb->prepare('select canttienda FROM productos where idproducto=:id');
        $data->execute(array(':id' => $productos[$i][1]));
        $cantidadP = $data->fetchAll();
        $cantidadP[0][0] = $cantidadP[0][0] - $productos[$i][3];

        $sent = $gdb->prepare('update productos set canttienda=:ca WHERE idproducto=:id');
        $exito = $sent->execute(array(':ca' => $cantidadP[0][0], ':id' => $productos[$i][1]));
    }
    return $exito;
}

function getconceciones($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT idconceciones,fecha,hora,cliente,acambio,estado FROM conceciones WHERE idconceciones=:id;');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function stdAArreglo($d) {
    if (is_object($d)) {
        $d = get_object_vars($d);
    }
    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    } else {
        return $d;
    }
}

?>
