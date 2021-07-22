<?php

require 'conexion.php';

function getMerma($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT m.idmerma,p.codigobarras,m.idProducto,p.producto,m.cantidad FROM merma m left join productos p on m.idProducto=p.idproducto where idmerma=:id');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function listMerma() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT m.idmerma,p.codigobarras,m.idProducto,p.producto,m.cantidad FROM merma m left join productos p on m.idProducto=p.idproducto');
    $data = $data->fetchAll();
    return $data;
}

function insertMerma($idp, $can) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into merma(idProducto,cantidad) values(:idp, :can)');
    $exito = $sent->execute(array(':idp' => $idp, ':can' => $can));

    $data = $gdb->prepare('select cantalmacen FROM productos where idproducto=:id');
    $data->execute(array(':id' => $idp));
    $cantidadP = $data->fetchAll();

    $cantidadP[0][0] = $cantidadP[0][0] - $can;

    $sent = $gdb->prepare('update productos set cantalmacen=:ca WHERE idproducto=:id');
    $exito = $sent->execute(array(':ca' => $cantidadP[0][0], ':id' => $idp));

    return $exito;
}

function updateMerma($id, $idp, $can) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update merma set idProducto = :idp, cantidad = :can WHERE idmerma=:id');
    $exito = $sent->execute(array(':idp' => $idp, ':can' => $can, ':id' => $id));
    return $exito;
}

?>
