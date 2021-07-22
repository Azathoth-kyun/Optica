<?php

require 'conexion.php';
session_start();
//Busca todas las variables que ya no van, [LISTO]
function insert($nombre, $apellido, $comentario, $fv, $hv, $tipo, $material, $subtipo, $ptrat, $strat, $tipoVision, $esfi, $cili, $ejei, $avi, $pioi, $dip, $esfd, $cild, $ejed, $avd, $piod, $addd, $id_at, $telefono) {
    $gdb = getConnection();
    //cambio en sent y exito, agrega el parametro arriba btw
    $sent = $gdb->prepare('INSERT INTO medida(apellido,nombre,fecha,comentario,idUser,hora,direccion,telefono)VALUES (:apellido,:nombre,:fecha,:comentario,:idUser,:hora,:direccion,:telefono)');
    $exito = $sent->execute(array(':apellido' => $apellido, ':nombre' => $nombre, ':fecha' => $fv, ':comentario' => $comentario, ':idUser' => $_SESSION['userID'],':hora'=>$hv,':direccion' => $id_at, ':telefono' => $telefono));
    if ($exito) {
        $insertId = $gdb->lastInsertId();
    } else {
        $insertId = '"';
    }
    $ojo = 'OD';
    $sent = $gdb->prepare('INSERT INTO detallemedida(idMedida,ojo,tipo,material,variacion,ptratamiento,stratamiento,tipoVision,esf,cil,eje,av,pio,addd,dip)VALUES(:idMedida,:ojo,:tipo,:material,:variacion,:ptratamiento,:stratamiento,:tipoVision,:esf,:cil,:eje,:av,:pio,:addd,:dip)');
    $exito = $sent->execute(array(':idMedida' => $insertId, ':ojo' => $ojo, ':tipo' => $tipo, ':material' => $material, ':variacion' => $subtipo, ':ptratamiento' => $ptrat, ':stratamiento' => $strat, ':tipoVision' => $tipoVision, ':esf' => $esfd, ':cil' => $cild, ':eje' => $ejed, ':av' => $avd, ':pio' => $piod, ':addd' => $addd, ':dip' => $dip));
    $ojo = 'OI';
    $sent = $gdb->prepare('INSERT INTO detallemedida(idMedida,ojo,tipo,material,variacion,ptratamiento,stratamiento,tipoVision,esf,cil,eje,av,pio,addd,dip)VALUES(:idMedida,:ojo,:tipo,:material,:variacion,:ptratamiento,:stratamiento,:tipoVision,:esf,:cil,:eje,:av,:pio,:addd,:dip)');
    $exito = $sent->execute(array(':idMedida' => $insertId, ':ojo' => $ojo, ':tipo' => $tipo, ':material' => $material, ':variacion' => $subtipo, ':ptratamiento' => $ptrat, ':stratamiento' => $strat, ':tipoVision' => $tipoVision, ':esf' => $esfi, ':cil' => $cili, ':eje' => $ejei, ':av' => $avi, ':pio' => $pioi, ':addd' => $addd, ':dip' => $dip));
    return $insertId;
}
function upd($id,$nombre, $apellido,$comentario, $fv, $hv, $tipo, $material, $subtipo, $ptrat, $strat, $tipoVision, $esfi, $cili, $ejei, $avi, $pioi, $dip, $esfd, $cild, $ejed, $avd, $piod, $addd) {
    $gdb = getConnection();

    $sent = $gdb->prepare('UPDATE medida SET apellido = :apellido, nombre = :nombre, fecha = :fecha,  comentario = :comentario, idUser = :idUser,hora= :hora WHERE idMedida = :idMedida');
    $exito = $sent->execute(array(':apellido' => $apellido, ':nombre' => $nombre, ':fecha' => $fv,':comentario' => $comentario, ':idUser' => $_SESSION['userID'],':hora'=>$hv,':idMedida'=>$id));
    
    $ojo = 'OD';
    $sent = $gdb->prepare('UPDATE detallemedida SET tipo = :tipo, material = :material, variacion = :variacion, ptratamiento = :ptratamiento, stratamiento = :stratamiento, tipoVision = :tipoVision, esf = :esf, cil = :cil, eje = :eje, av = :av, pio = :pio, addd = :addd, dip =:dip WHERE idMedida = :idMedida and ojo = :ojo');
    $exito = $sent->execute(array(':idMedida' => $id, ':ojo' => $ojo, ':tipo' => $tipo, ':material' => $material, ':variacion' => $subtipo, ':ptratamiento' => $ptrat, ':stratamiento' => $strat, ':tipoVision' => $tipoVision, ':esf' => $esfd, ':cil' => $cild, ':eje' => $ejed, ':av' => $avd, ':pio' => $piod, ':addd' => $addd, ':dip' => $dip));
    $ojo = 'OI';
    $sent = $gdb->prepare('UPDATE detallemedida SET tipo = :tipo, material = :material, variacion = :variacion, ptratamiento = :ptratamiento, stratamiento = :stratamiento, tipoVision = :tipoVision, esf = :esf, cil = :cil, eje = :eje, av = :av, pio = :pio, addd = :addd, dip =:dip WHERE idMedida = :idMedida and ojo = :ojo');
    $exito = $sent->execute(array(':idMedida' => $id, ':ojo' => $ojo, ':tipo' => $tipo, ':material' => $material, ':variacion' => $subtipo, ':ptratamiento' => $ptrat, ':stratamiento' => $strat, ':tipoVision' => $tipoVision, ':esf' => $esfi, ':cil' => $cili, ':eje' => $ejei, ':av' => $avi, ':pio' => $pioi, ':addd' => $addd, ':dip' => $dip));
    return $id;
}

function cambiarAtencion($id_at){
    $gdb = getConnection();
    $sent = $gdb->prepare('UPDATE envio_optometra set atendido_optometra = 1 where id = :id_at');
    $exito = $sent->execute(array(':id_at' => $id_at));
    return $exito;
}
function listDetalle($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT * FROM detallemedida WHERE idMedida=:id');
    $data->execute(array(':id' => $id));
    $data = $data->fetchAll();
    return $data;
}
function lisMedicion() {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT * FROM medida WHERE idUser=:id Order by idMedida Desc ' );
    $data->execute(array(':id' => $_SESSION['userID']));
    $data = $data->fetchAll();
    return $data;
}
function lisMedicionVenta($fec) {
    $gdb = getConnection();
    //Cambio aquí
    $data = $gdb->prepare('SELECT m.*,concat(u.apellidos,\' \',u.nombres),t.tienda as medico FROM medida m left join  usuario u on m.idUser=u.idUsuario right join envio_optometra eo on m.direccion=eo.id inner join tienda t on eo.tienda=t.idtienda where fecha=:fec  order by idMedida desc');
    $data->execute(array(':fec' => $fec));
    $data = $data->fetchAll();
    return $data;
}
function cerrarmedida($id){
    $gdb = getConnection();
    $data = $gdb->prepare('UPDATE medida set estado=1 where idMedida=:id');
    $exito = $data->execute(array(':id' => $id));
    return $exito;
}
function findMedicionVenta($path) {
    $gdb = getConnection();
    $data = $gdb->query('SELECT m.*,concat(u.apellidos,\' \',u.nombres) as medico FROM medida m left join  usuario u on m.idUser=u.idUsuario and concat(apellido,\' \',nombre) like \''.$path.'%\' order by idMedida desc');
    $data = $data->fetchAll();
    return $data;
}
function findMedicion($path) {
    $gdb = getConnection();
    $data = $gdb->query('SELECT * FROM medida where concat(apellido,\' \',nombre) like \'%'.$path.'%\'  Order by idMedida Desc');
    $data = $data->fetchAll();
    return $data;
}
function listByFecha($fecha) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT * FROM medida where idUser=:id and fecha = \''.$fecha.'\'  Order by idMedida Desc');
    $data->execute(array(':id' => $_SESSION['userID']));
    $data = $data->fetchAll();
    return $data;
}
function getMedicion($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT * FROM medida where idMedida=:id');
    $data->execute(array(':id' => $id));
    $data = $data->fetchAll();
    if (count($data) > 0) {
        return $data[0];
    } else {
        return;
    }
}
function getTelefono($id_at){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT telefono FROM envio_optometra where id=:id');
    $data->execute(array(':id' => $id_at));
    $data = $data->fetchAll();
    if (count($data) > 0) {
        return $data[0];
    } else {
        return;
    }
}

?>