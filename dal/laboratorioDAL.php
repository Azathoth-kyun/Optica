<?php
require 'conexion.php';
session_start();

function listLaboratorios(){
    $gdb = getConnection();
    $data = $gdb->prepare('select idprodlab, prodlab, estado from productolaboratorio where nivel=1 and estado=1;');
    $data->execute();
    $data = $data->fetchAll();
    return $data;
}

function saveLaboratorio($laboratorio, $estado) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into productolaboratorio(prodlab, estado, nivel) 
        values(:prodlab, :estado, :nivel);');
    $exito = $sent->execute(array(':prodlab' => $laboratorio, ':estado' => $estado, ':nivel' => '1'));
    return $exito;
}

function updateLaboratorio($idprodlab, $laboratorio, $estado) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update productolaboratorio set prodlab = :prodlab, estado = :estado '
            . ' where idprodlab = :idprodlab;');
    $exito = $sent->execute(array(':prodlab' => $laboratorio, ':estado' => $estado, ':idprodlab' => $idprodlab));
    return $exito;
}

function listProductos($padre){
    $gdb = getConnection();
    $data = $gdb->prepare('select idprodlab, prodlab, estado, padre from productolaboratorio where nivel=2 and estado=1 and padre=:padre;');
    $data->execute(array(':padre' => $padre));
    $data = $data->fetchAll();
    return $data;
}

function saveProducto($laboratorio, $estado, $padre, $comision) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into productolaboratorio(prodlab, estado, nivel, padre, comisionable)
        values(:prodlab, :estado, :nivel, :padre, :comision);');
    $exito = $sent->execute(array(':prodlab' => $laboratorio, ':estado' => $estado, ':nivel' => '2', ':padre' => $padre, ':comision' => $comision));
    return $exito;
}

function updateProducto($idprodlab, $producto, $estado, $padre, $comision) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update productolaboratorio set prodlab = :prodlab, estado = :estado, padre=:padre, comisionable=:comision '
            . ' where idprodlab = :idprodlab;');
    $exito = $sent->execute(array(':prodlab' => $producto, ':estado' => $estado, ':idprodlab' => $idprodlab, ':padre' => $padre, ':comision' => $comision));
    return $exito;
}

function listDetalle($padre){
    $gdb = getConnection();
    $data = $gdb->prepare('select pp.idprodlab, pp.prodlab, pp.estado, pp.padre, pl.padre as padrel from productolaboratorio pp 
inner join productolaboratorio pl on pp.padre=pl.idprodlab where pp.nivel=3 and pp.estado=1 and pp.padre=:padre;');
    $data->execute(array(':padre' => $padre));
    $data = $data->fetchAll();
    return $data;
}

function saveDetalle($detalle, $estado, $padre, $comision) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into productolaboratorio(prodlab, estado, nivel, padre, comisionable)
        values(:prodlab, :estado, :nivel, :padre, :comision);');
    $exito = $sent->execute(array(':prodlab' => $detalle, ':estado' => $estado, ':nivel' => '3', ':padre' => $padre, ':comision' => $comision));
    return $exito;
}

function updateDetalle($idprodlab, $detalle, $estado, $padre, $comision) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update productolaboratorio set prodlab = :prodlab, estado = :estado, padre=:padre, comisionable=:comision '
            . ' where idprodlab = :idprodlab;');
    $exito = $sent->execute(array(':prodlab' => $detalle, ':estado' => $estado, ':idprodlab' => $idprodlab, ':padre' => $padre, ':comision' => $comision));
    return $exito;
}
?>
