<?php

require 'conexion.php';

function getProveedor($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT * FROM proveedor where idproveedor=:id');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function listProveedor() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT * FROM proveedor');
    $data = $data->fetchAll();
    return $data;
}

function insertProveedor($proveedor,$razonsocial,$ruc,$direccion,$telefono,$celular,$comentario,$estado) {
    $gdb = getConnection();
    $sent = $gdb->prepare('INSERT INTO proveedor(razonsocial,ruc,direccion,telefono,contacto,celular,comentario,estado)  
        values(:razonsocial,:ruc,:direccion,:telefono,:contacto,:celular,:comentario,:estado)');
    $exito = $sent->execute(array(':razonsocial'=>$razonsocial,':ruc'=>$ruc,':direccion'=>$direccion,':telefono'=>$telefono,':contacto'=>$proveedor,':celular'=>$celular,':comentario'=>$comentario,':estado'=>$estado));
    return $exito;
}

function updateProveedor($idproveedor,$proveedor,$razonsocial,$ruc,$direccion,$telefono,$celular,$comentario) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update proveedor set contacto=:proveedor,razonsocial=:razonsocial,ruc=:ruc,direccion=:direccion,telefono=:telefono,celular=:celular,comentario=:comentario WHERE idproveedor=:idproveedor');
    $exito = $sent->execute(array(':idproveedor'=>$idproveedor,':proveedor'=>$proveedor,':razonsocial'=>$razonsocial,':ruc'=>$ruc,':direccion'=>$direccion,':telefono'=>$telefono,':celular'=>$celular,':comentario'=>$comentario));
    return $exito;
}

function deleteProveedor($id) {
    $gdb = getConnection();
    $sent = $gdb->prepare('DELETE FROM proveedor WHERE idproveedor=:id');
    $exito = $sent->execute(array(':id' => $id));
    return $exito;
}
?>
