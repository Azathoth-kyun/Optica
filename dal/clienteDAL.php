<?php

require 'conexion.php';

function getCliente($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select id, doc, nombre, estado FROM cliente where id=:id and estado=1');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function findCliente($doc) {
    $gdb = getConnection();
    $data = $gdb->prepare('select id, doc, nombre, estado FROM cliente where doc=:doc and estado=1');
    $data->execute(array(':doc' => $doc));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function listCliente() {
    $gdb = getConnection();
    $data = $gdb->query('select id,doc,nombre FROM cliente where estado=1 ORDER BY id');
    $data = $data->fetchAll();
    return $data;
}

function insertCliente($doc, $nom) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into cliente(doc,nombre,estado) values(:doc, :nom, 1)');
    $exito = $sent->execute(array(':doc' => $doc, ':nom' => $nom));
    return $exito;
}

function updateCliente($id, $doc, $nom) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update cliente set doc = :doc, nombre = :nom WHERE id=:id');
    $exito = $sent->execute(array(':doc' => $doc, ':nom' => $nom, ':id' => $id));
    return $exito;
}

function deleteCliente($id) {
 $gdb = getConnection();
 $sent = $gdb->prepare('update cliente set estado = 0 WHERE id=:id');
 $exito = $sent->execute(array(':id' => $id));
 return $exito;
}

?>