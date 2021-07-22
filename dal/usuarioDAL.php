<?php

require 'conexion.php';

function GetUser($nombUser) {
    $gdb = getConnection();
    $data = $gdb->prepare('select idUsuario, nombUser, apellidos, nombres, password, tipo, estado ,codtienda FROM usuario where nombUser=:nombUser && estado=1');
    $data->execute(array(':nombUser' => $nombUser));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function getuserDistLog($nombUser, $id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select idUsuario, nombUser, apellidos, nombres, password, tipo, estado ,codtienda FROM usuario where idusuario<>:idusuario and nombUser=:nombUser && estado=1');
    $data->execute(array(':nombUser' => $nombUser, ':idusuario' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function getMsg() {
   $gdb = getConnection();
    $data = $gdb->query('SELECT descripcion FROM parametros where idparametro=14');
    $data = $data->fetchAll();
    return $data;
}

function getUsuario($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select u.idUsuario, u.nombUser, u.apellidos, u.nombres, u.password, u.tipo, u.estado ,u.codtienda,t.tienda FROM usuario u  left join tienda t on u.codtienda=t.idtienda  where u.idUsuario=:idU and u.estado = 1');
    $data->execute(array(':idU' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function listUsuarios() {
    $gdb = getConnection();
    $data = $gdb->query('select u.idUsuario, u.nombUser, u.apellidos, u.nombres, u.password, u.tipo, u.estado ,u.codtienda,t.tienda FROM usuario u  left join tienda t on u.codtienda=t.idtienda  where u.estado=1');
    $data = $data->fetchAll();
    return $data;
}

function insertUsuario($unom, $ape, $nom, $pass, $tipo, $codt) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into usuario(nombUser, apellidos, nombres, password, tipo, estado, codtienda) 
        values(:unom, :ape, :nom, md5(:pass), :tipo, \'1\',:codt)');
    $exito = $sent->execute(array(':unom' => $unom, ':ape' => $ape, ':nom' => $nom,
        ':pass' => $pass, ':tipo' => $tipo,':codt'=>$codt));
    return $exito;
}

function updateUsuario($id, $unom, $ape, $nom, $pass, $tipo, $estado,$codt) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update usuario set nombUser = :unom, apellidos = :ape, nombres = :nom, password = :pass, tipo = :tipo ,estado = :estado,codtienda=:codt where idUsuario = :idu');
    $exito = $sent->execute(array(':unom' => $unom, ':ape' => $ape, ':nom' => $nom, ':pass' => $pass, ':tipo' => $tipo, ':estado' => $estado, ':idu' => $id,':codt'=>$codt));
    return $exito;
}

function removeUsuario($id) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update usuario set estado = 0 where  idUsuario= :id');
    $exito = $sent->execute(array(':id' => $id));
    return $exito;
}

function loadVendedores(){
    $gdb = getConnection();
    $sent = $gdb->query('SELECT idvendedor, Nombres, Apellidos, NumDocu from vendedor where estado=0');
    $sent = $sent->fetchAll();
    return $sent;
}

function saveSech($nombre,$apellido,$tipo,$numDoc){
    $gdb = getConnection();
    $sent = $gdb->prepare('INSERT into vendedor(Nombres, Apellidos, TipoDocu, NumDocu) values(:nombre,:apellido,:tipo,:numDoc)');
    $exito = $sent->execute(array(':nombre' => $nombre, ':apellido' => $apellido, ':tipo' => $tipo, ':numDoc' => $numDoc));
    return $exito;
}

function getVendedor($id){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT idvendedor, Nombres, Apellidos, TipoDocu, NumDocu from vendedor where idvendedor= :idU');
    $data->execute(array(':idU' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function updateSech($id,$nombre,$apellido,$tipo,$numDoc) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update vendedor set Nombres=:nombre, Apellidos=:apellido, TipoDocu=:tipo, NumDocu=:numDoc where  idvendedor= :id');
    $exito = $sent->execute(array(':id' => $id, ':nombre' => $nombre, ':apellido' => $apellido, ':tipo' => $tipo, ':numDoc' => $numDoc));
    return $exito;
}

function removeVendedor($id){
    $gdb = getConnection();
    $dorime = $gdb->prepare('UPDATE vendedor set estado=1 where idvendedor= :id');
    $exito = $dorime->execute(array(':id' => $id));
    return $exito;
}

function GetTiendaByIdUsuario($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select idtienda, tienda, estado FROM tienda where idtienda=:idU');
    $data->execute(array(':idU' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
?>
