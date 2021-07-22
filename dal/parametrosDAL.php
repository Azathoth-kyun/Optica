<?php
require 'conexion.php';


function listParametros() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT idparametro,nombre,descripcion FROM parametros');
    $data = $data->fetchAll();
    return $data;
}
function getParametros($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select idparametro, nombre, descripcion FROM parametros where idparametro=:idU');
    $data->execute(array(':idU' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function updateParametros($id, $nomb, $desc) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update parametros set nombre = :nomb, descripcion = :desc where idparametro = :id');
    $exito = $sent->execute(array(':nomb' => $nomb, ':desc' => $desc, ':id' => $id));
    return $exito;
}
?>
