<?php

require 'conexion.php';

function registroHistInventario($faltantes, $idhistorial) {
    $gdb = getConnection();
    for ($i = 0; $i < count($faltantes); ++$i) {
        $sent = $gdb->prepare('insert into detalleinventario(idmonturas, idhistorial) '
                . ' values(:idmonturas, :idhistorial);');
        $exito = $sent->execute(array(':idmonturas' => $faltantes[$i][0], ':idhistorial' => $idhistorial));
    }
    return $exito;
}

function registroInventario($totalf, $totalv, $total, $idtienda) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into historialinventario(total, totalverificados, totalfaltantes, idtienda, fecha, hora)'
            . 'values(:total, :totalv, :totalf, :idtienda, CURRENT_DATE, curTime())');
    $exito = $sent->execute(array(':total' => $total, ':totalv' => $totalv, ':totalf' => $totalf, ':idtienda' => $idtienda));
    return $exito;
}
function getUltimoIdHistorialInv() {
    $gdb = getConnection();
    $data = $gdb->query('select idhistorial FROM historialinventario ORDER BY idhistorial DESC LIMIT 1;');
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0][0];
    } else {
        return;
    }
}
function listarHistorialInventario($idtienda) {
    $gdb = getConnection();
    $data = $gdb->prepare('select idhistorial, fecha, hora, total, totalfaltantes, totalverificados, idtienda 
from historialinventario where idtienda=:idtienda order by idhistorial DESC;');
    $data->execute(array(':idtienda' => $idtienda));
    $filas = $data->fetchAll();
    return $filas;
}
function listarDetalleInventario($idhistorial) {
    $gdb = getConnection();
    $data = $gdb->prepare('select d.iddetalle, d.idmonturas, concat(m.marca,\' \',m.modelo,\' \',m.tipo,\' \',m.color)as montura 
from detalleinventario d inner join monturas m on d.idmonturas=m.idmonturas where d.idhistorial=:idhistorial order by d.idmonturas;');
    $data->execute(array(':idhistorial' => $idhistorial));
    $filas = $data->fetchAll();
    return $filas;
}
function listarFaltantesByMarca($idhistorial) {
    $gdb = getConnection();
    $data = $gdb->prepare('select count(m.marca) as total, m.marca
from detalleinventario d inner join monturas m on d.idmonturas=m.idmonturas where d.idhistorial=:idhistorial  group by m.marca order by m.marca;');
    $data->execute(array(':idhistorial' => $idhistorial));
    $filas = $data->fetchAll();
    return $filas;
}