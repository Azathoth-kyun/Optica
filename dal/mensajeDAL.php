<?php
require 'conexion.php';
session_start();

function insertMensajeTienda($idtienda, $asunto, $mensaje) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into mensaje(idtienda, asunto, mensaje, fecha, hora, estado) 
        values(:idtienda, :asunto, :mensaje, CURRENT_DATE, curTime(), 0);');
    $exito = $sent->execute(array(':idtienda' => $idtienda, ':asunto' => $asunto, ':mensaje' => $mensaje));
    return $exito;
}

function listMensajesByTienda($idtienda) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT idmensaje, idtienda, asunto, mensaje, fecha, hora, estado 
    FROM mensaje 
    WHERE idtienda=:idtienda ORDER BY idmensaje desc limit 10;');
    $data->execute(array(':idtienda' => $idtienda));
    $data = $data->fetchAll();
    return $data;
}

function updateMensajesLeido($idtienda) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update mensaje set estado=1 where idtienda=:idtienda;');
    $exito = $sent->execute(array(':idtienda' => $idtienda));
    return $exito;
}