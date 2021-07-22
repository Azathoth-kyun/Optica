<?php
require 'conexion.php';
session_start();

function listarTiendasSelect() {
    $gdb = getConnection();
    $data = $gdb->query('select t.idtienda, t.tienda, t.direccion, t.estado, t.idsuscripcion 
from tienda t where t.estado=1;');
    $data = $data->fetchAll();
    return $data;
}
function listarEmpleados(){
    $gdb = getConnection();
    $data = $gdb->query('SELECT idvendedor, concat(Nombres, " ", Apellidos) as vendedor FROM vendedor where estado=0');
    $data = $data->fetchAll();
    return $data;
}
// function listarlosIDS($marca,$anio){
//     $gdb = getConnection();
//     $data = $gdb->prepare('SELECT hm.idmonturas,count(hm.idmonturas) from historialvendido hm inner join monturas m on hm.idmonturas=m.idmonturas WHERE m.marca= :marca and YEAR(hm.fecha)=:anio GROUP BY hm.idmonturas ORDER BY count(hm.idmonturas) DESC');
//     $data->execute(array(':marca' => $marca, ':anio' => $anio));
//     $data = $data->fetchAll();
//     return $data;
// }
// function listarlasDESC($marca,$anio){
//     $gdb = getConnection();
//     $data = $gdb->prepare('SELECT concat(m1.marca,\' \',m1.modelo,\' \',m1.tipo,\' \',m1.color)as montura from monturas m1 inner join historialvendido hm on m1.idmonturas=hm.idmonturas WHERE m1.marca= :marca and YEAR(hm.fecha)=:anio');
//     $data->execute(array(':marca' => $marca, ':anio' => $anio));
//     $data = $data->fetchAll();
//     return $data;
// }
// function listarlosIDSM($marca,$anio,$mes){
//     $gdb = getConnection();
//     $data = $gdb->prepare('SELECT hm.idmonturas,count(hm.idmonturas) from historialvendido hm inner join monturas m on hm.idmonturas=m.idmonturas WHERE m.marca= :marca and MONTH(hm.fecha)=:mes and YEAR(hm.fecha)=:anio GROUP BY hm.idmonturas ORDER BY count(hm.idmonturas) DESC');
//     $data->execute(array(':marca' => $marca, ':anio' => $anio, ':mes' => $mes));
//     $data = $data->fetchAll();
//     return $data;
// }
// function listarlasDESCM($marca,$anio,$mes){
//     $gdb = getConnection();
//     $data = $gdb->prepare('SELECT concat(m1.marca,\' \',m1.modelo,\' \',m1.tipo,\' \',m1.color)as montura from monturas m1 inner join historialvendido hm on m1.idmonturas=hm.idmonturas WHERE m1.marca= :marca and MONTH(hm.fecha)=:mes and YEAR(hm.fecha)=:anio');
//     $data->execute(array(':marca' => $marca, ':anio' => $anio, ':mes' => $mes));
//     $data = $data->fetchAll();
//     return $data;
// }
function pagarComision($cod_venta){
    $gdb = getConnection();
    $data = $gdb->prepare('UPDATE venta set isPagado=1 where idventa= :idv');
    $exito = $data->execute(array(':idv' => $cod_venta));
    return $exito;
}

function listarlosIDS($marca,$anio){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT hm.idmonturas,count(hm.idmonturas) from historialmovimiento hm WHERE hm.idmonturas IN (SELECT idmonturas FROM monturas m where m.marca= :marca) and YEAR(hm.fecha)=:anio and hm.indicador REGEXP "VENDIDO" GROUP BY hm.idmonturas ORDER BY count(hm.idmonturas) DESC');
    $data->execute(array(':marca' => $marca, ':anio' => $anio));
    $data = $data->fetchAll();
    return $data;
}
function listarlasDESC($marca,$anio){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT concat(m1.marca,\' \',m1.modelo,\' \',m1.tipo,\' \',m1.color)as montura from monturas m1 where m1.idmonturas IN (SELECT hm.idmonturas from historialmovimiento hm WHERE hm.idmonturas IN (SELECT idmonturas FROM monturas m where m.marca= :marca) and YEAR(hm.fecha)=:anio and hm.indicador REGEXP "VENDIDO")');
    $data->execute(array(':marca' => $marca, ':anio' => $anio));
    $data = $data->fetchAll();
    return $data;
}
function listarlosIDSM($marca,$anio,$mes){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT hm.idmonturas,count(hm.idmonturas) from historialmovimiento hm WHERE hm.idmonturas IN (SELECT idmonturas FROM monturas m where m.marca= :marca) and MONTH(hm.fecha)=:mes and YEAR(hm.fecha)=:anio and hm.indicador REGEXP "VENDIDO" GROUP BY hm.idmonturas ORDER BY count(hm.idmonturas) DESC');
    $data->execute(array(':marca' => $marca, ':anio' => $anio, ':mes' => $mes));
    $data = $data->fetchAll();
    return $data;
}
function listarlasDESCM($marca,$anio,$mes){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT concat(m1.marca,\' \',m1.modelo,\' \',m1.tipo,\' \',m1.color)as montura from monturas m1 where m1.idmonturas IN (SELECT hm.idmonturas from historialmovimiento hm WHERE hm.idmonturas IN (SELECT idmonturas FROM monturas m where m.marca= :marca) and MONTH(hm.fecha)=:mes and YEAR(hm.fecha)=:anio and hm.indicador REGEXP "VENDIDO")');
    $data->execute(array(':marca' => $marca, ':anio' => $anio, ':mes' => $mes));
    $data = $data->fetchAll();
    return $data;
}
function vendedoresanio($vendedor,$anio){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT v.fv,v.idventa, v.total from venta v where refraccion=:vendedor and YEAR(STR_TO_DATE(concat(substr(v.fv,1,2),",",substr(v.fv,4,2),",",substr(v.fv,7,4)),"%d,%m,%Y")) = :anio order by v.idventa ASC');
    $data->execute(array(':vendedor' => $vendedor, ':anio' => $anio));
    $data = $data->fetchAll();
    return $data;
}
function vendedoresmes($vendedor,$anio,$mes){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT v.fv,v.idventa, v.total from venta v where refraccion=:vendedor and YEAR(STR_TO_DATE(concat(substr(v.fv,1,2),",",substr(v.fv,4,2),",",substr(v.fv,7,4)),"%d,%m,%Y")) = :anio AND MONTH(STR_TO_DATE(concat(substr(v.fv,1,2),",",substr(v.fv,4,2),",",substr(v.fv,7,4)),"%d,%m,%Y")) = :mes order by v.idventa ASC');
    $data->execute(array(':vendedor' => $vendedor, ':anio' => $anio, ':mes' => $mes));
    $data = $data->fetchAll();
    return $data;
}
function comisionganada($mes,$vendedor){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT dv.idventa, dv.descripcion, pc.comision FROM detalleventa dv inner join productocomision pc on substr(dv.descripcion,6,7) = pc.idarticulo where (dv.tipo="M" or dv.tipo="P") and dv.idventa IN (SELECT v.idventa from venta v WHERE v.refraccion=:vendedor and YEAR(STR_TO_DATE(concat(substr(v.fv,1,2),",",substr(v.fv,4,2),",",substr(v.fv,7,4)),"%d,%m,%Y")) = YEAR(CURDATE()) AND MONTH(STR_TO_DATE(concat(substr(v.fv,1,2),",",substr(v.fv,4,2),",",substr(v.fv,7,4)),"%d,%m,%Y")) = :mes)');
    $data->execute(array(':vendedor' => $vendedor, ':mes' => $mes));
    $data = $data->fetchAll();
    return $data;
}
function comisionganadaLunas($mes,$vendedor){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT dv.idventa, pl.prodlab from productolaboratorio pl inner join detalleventa dv on substr(dv.descripcion,5,3) = pl.idprodlab where dv.tipo="C" and dv.idventa IN (SELECT v.idventa from venta v WHERE v.refraccion=:vendedor and YEAR(STR_TO_DATE(concat(substr(v.fv,1,2),",",substr(v.fv,4,2),",",substr(v.fv,7,4)),"%d,%m,%Y")) = YEAR(CURDATE()) AND MONTH(STR_TO_DATE(concat(substr(v.fv,1,2),",",substr(v.fv,4,2),",",substr(v.fv,7,4)),"%d,%m,%Y")) = :mes)');
    $data->execute(array(':vendedor' => $vendedor, ':mes' => $mes));
    $data = $data->fetchAll();
    return $data;
}
function checked($mes,$vendedor){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT v.isPagado from venta v inner join detalleventa dv on v.idventa=dv.idventa WHERE (dv.tipo="M" or dv.tipo="P") v.refraccion=:vendedor and YEAR(STR_TO_DATE(concat(substr(v.fv,1,2),",",substr(v.fv,4,2),",",substr(v.fv,7,4)),"%d,%m,%Y")) = YEAR(CURDATE()) AND MONTH(STR_TO_DATE(concat(substr(v.fv,1,2),",",substr(v.fv,4,2),",",substr(v.fv,7,4)),"%d,%m,%Y")) = :mes order by v.idventa asc');
    $data->execute(array(':vendedor' => $vendedor, ':mes' => $mes));
    $data = $data->fetchAll();
    return $data;
}
function checkedLunas($mes,$vendedor){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT v.isPagado from venta v inner join detalleventa dv on v.idventa=dv.idventa WHERE dv.tipo="C" and v.refraccion=:vendedor and YEAR(STR_TO_DATE(concat(substr(v.fv,1,2),",",substr(v.fv,4,2),",",substr(v.fv,7,4)),"%d,%m,%Y")) = YEAR(CURDATE()) AND MONTH(STR_TO_DATE(concat(substr(v.fv,1,2),",",substr(v.fv,4,2),",",substr(v.fv,7,4)),"%d,%m,%Y")) = :mes order by v.idventa asc');
    $data->execute(array(':vendedor' => $vendedor, ':mes' => $mes));
    $data = $data->fetchAll();
    return $data;
}
function listarMarcas(){
    $gdb = getConnection();
    $data = $gdb->query('SELECT DISTINCT marca FROM monturas where marca NOT IN (SELECT DISTINCT marca FROM monturas where marca LIKE "+%" or marca like "-%" or marca like "OD-%" or marca like "OI-%" or marca like "OD+%" or marca like "OI+%" or marca like "OI%" or marca like "OD%" or marca like "CYL%" or marca like "CLY%" or marca like "0%" or marca like "1%" or marca like "2%" or marca like "ADD%")');
    $data = $data->fetchAll();
    return $data;
}
function listarTiendasSelectNoLogin() {
    $gdb = getConnection();
    $idtienda = $_SESSION['tienda'];
    $data = $gdb->prepare('select t.idtienda, t.tienda, t.direccion, t.estado, t.idsuscripcion 
from tienda t where t.estado=1 and t.idtienda!=:idtienda;');
    $data->execute(array(':idtienda' => $idtienda));
    $data = $data->fetchAll();
    return $data;
}
function listTiendas() {
    $gdb = getConnection();
    $data = $gdb->query('select t.idtienda, t.tienda, t.direccion, t.estado, t.idsuscripcion from tienda t');
    $data = $data->fetchAll();
    return $data;
}
function getTiendas($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select * FROM tienda where idtienda=:idU');
    $data->execute(array(':idU' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function getTiendasName($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select tienda FROM tienda where idtienda=:idU');
    $data->execute(array(':idU' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function insertTiendas($nomb, $desc) {
    $gdb = getConnection();
    $sent = $gdb->prepare('INSERT INTO tienda(tienda,direccion,estado) values(:tienda,:direccion,:estado)');																									
    $exito = $sent->execute(array(':tienda' => $nomb, ':direccion' => $desc, ':estado' => 1));
    return $exito;
}

function insertTienda($nomb, $desc) {
    $gdb = getConnection();
    $sent = $gdb->prepare('INSERT INTO tienda(tienda,direccion, estado) values(:tienda,:direccion,:estado)');																									
    $exito = $sent->execute(array(':tienda' => $nomb, ':direccion' => $desc, ':estado' => 1));
    return $exito;
}

function updateIdSuscripcion($idsuscripcion, $id) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update tienda set idsuscripcion = :idsuscripcion where idtienda = :id');
    $exito = $sent->execute(array(':idsuscripcion' => $idsuscripcion, ':id' => $id));
    return $exito;
}

function getIdTienda() {
    $gdb = getConnection();
    $data = $gdb->query('select idtienda FROM tienda ORDER BY idtienda DESC LIMIT 1;');
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0][0];
    } else {
        return;
    }
}

function insertSuscripcionTienda($idsuscripcion, $idtienda, $idsuscriptor, $plan) {
    $gdb = getConnectionAdmin();
    $sent = $gdb->prepare('insert into suscripcion(idsuscripcion, idtienda, idsuscriptor, idplan, idestado) 
        values(:idsuscripcion, :idtienda, :idsuscriptor, :idplan, :idestado);');
    $exito = $sent->execute(array(':idsuscripcion' => $idsuscripcion,':idtienda' => $idtienda, ':idsuscriptor' => $idsuscriptor, ':idplan' => $plan, ':idestado' => 1));
    return $exito;
}

function updateTiendas($id, $nomb, $desc) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update tienda set tienda = :nomb, direccion = :desc where idtienda = :id');
    $exito = $sent->execute(array(':nomb' => $nomb, ':desc' => $desc, ':id' => $id));
    return $exito;
}

function getTiendasByUsuario() {
    $idusuario = $_SESSION['userID'];
    $gdb = getConnection();
    $data = $gdb->prepare('select t.idtienda, t.tienda FROM tienda t INNER JOIN usuario u ON t.idtienda = u.codtienda WHERE u.idusuario=:idusuario;');
    $data->execute(array(':idusuario' => $idusuario));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function insertVoucherSuscripcion($rutaimagen, $idsuscripcion) {
    $gdb = getConnectionAdmin();
    $sent = $gdb->prepare('update suscripcion set voucher = :voucher, idestado=:estado where idsuscripcion = :id');
    $exito = $sent->execute(array(':voucher' => $rutaimagen, ':estado' => '4', ':id' => $idsuscripcion));
    return $exito;
}
?>
