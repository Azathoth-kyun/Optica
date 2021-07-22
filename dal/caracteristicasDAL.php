<?php

require 'conexion.php';

function getCracteristica($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select id,caracteristica,tipocaracteristica FROM caracteristica where id=:id');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function findCracteristica($car) {
    $gdb = getConnection();
    $data = $gdb->prepare('select id,caracteristica,tipocaracteristica FROM caracteristica where caracteristica=:id');
    $data->execute(array(':id' => $car));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function listCaracteristicas() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT id,caracteristica,tipocaracteristica FROM caracteristica ORDER BY id DESC');
    $data = $data->fetchAll();
    return $data;
}

function listCaracteristicasTipo($tipo) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT id,caracteristica,tipocaracteristica FROM caracteristica WHERE tipocaracteristica=:tipo ORDER BY caracteristica');
    $data->execute(array(':tipo' => $tipo));
    $data = $data->fetchAll();
    return $data;
}

function insertCaracteristica($car, $tipo) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into caracteristica(caracteristica,tipocaracteristica) 
        values(:car, :tipo)');
    $exito = $sent->execute(array(':car' => $car, ':tipo' => $tipo));
    return $exito;
}

function updateCaracteristica($id, $car, $tipo) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update caracteristica set caracteristica = :car, tipocaracteristica = :tipo WHERE id=:id');
    $exito = $sent->execute(array(':car' => $car, ':tipo' => $tipo, ':id' => $id));
    return $exito;
}

function deleteCaracteristica($id) {
    $gdb = getConnection();
    $sent = $gdb->prepare('DELETE FROM caracteristica WHERE id=:id');
    $exito = $sent->execute(array(':id' => $id));
    return $exito;
}

?>
