<?php
require 'conexion.php';
session_start();

function listaGastosVariables(){
    $gdb = getConnection();
    $data = $gdb->prepare('select g.IdGastos,g.descripcion from gastos g inner join tiposgastos tg on g.IdTipoGastos=tg.IdTipoGastos where tg.IdTipoGastos=2');
    $data->execute();
    $data = $data->fetchAll();
    return $data;
}

function listTipoGasto() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT idtipogasto, tipogasto FROM tipogasto WHERE estado=1;');
    $data = $data->fetchAll();
    return $data;
}

function listCategoriaGasto() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT c.idcategoria, c.idtipogasto, c.categoria, t.tipogasto, c.estado, c.soloadmin 
    FROM categoriagasto c INNER JOIN tipogasto t ON c.idtipogasto=t.idtipogasto ORDER BY c.idcategoria;');
    $data = $data->fetchAll();
    return $data;
}

function listCategoriaGastoActiva() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT c.idcategoria, c.idtipogasto, c.categoria, t.tipogasto, c.estado 
    FROM categoriagasto c INNER JOIN tipogasto t ON c.idtipogasto=t.idtipogasto WHERE c.estado=1 and c.soloadmin=0 ORDER BY c.idcategoria;');
    $data = $data->fetchAll();
    return $data;
}

function listCategoriaGastoActivaSoloadmin() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT c.idcategoria, c.idtipogasto, c.categoria, t.tipogasto, c.estado 
    FROM categoriagasto c INNER JOIN tipogasto t ON c.idtipogasto=t.idtipogasto WHERE c.estado=1 ORDER BY c.idcategoria;');
    $data = $data->fetchAll();
    return $data;
}

function getcategoriagasto($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT c.idcategoria, c.idtipogasto, c.categoria, c.estado, c.soloadmin 
    FROM categoriagasto c WHERE c.idcategoria=:id;');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function insertCategoriaGasto($categoria, $idtipo, $estado, $soloadmin) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into categoriagasto(idtipogasto, categoria, estado, soloadmin) 
        values(:idtipo, :categoria, :estado, :soloadmin);');
    $exito = $sent->execute(array(':idtipo' => $idtipo, ':categoria' => $categoria, ':estado' => $estado, ':soloadmin' => $soloadmin));
    return $exito;
}

function updateCategoriaGasto($idcategoria, $categoria, $idtipo, $estado, $soloadmin) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update categoriagasto set idtipogasto = :idtipo, categoria = :categoria, estado = :estado, soloadmin = :soloadmin where idcategoria = :id');
    $exito = $sent->execute(array(':idtipo' => $idtipo, ':categoria' => $categoria, ':estado' => $estado, ':id' => $idcategoria, ':soloadmin' => $soloadmin));
    return $exito;
}

function listDetalleGastos($idtienda) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT g.idgasto, g.descripcion, g.observacion, g.monto, g.fecha, g.idcategoria, c.categoria, t.tipogasto 
    FROM gasto g INNER JOIN categoriagasto c ON g.idcategoria=c.idcategoria 
    INNER JOIN tipogasto t ON c.idtipogasto=t.idtipogasto
    WHERE g.idtienda=:idtienda and g.tipouserpago=:tipouserpago ORDER BY g.idgasto;');
    $data->execute(array(':idtienda' => $idtienda, ':tipouserpago' => 'tienda'));
    $data = $data->fetchAll();
    return $data;
}

function listDetalleGastosByTiendaAdmin($idtienda) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT g.idgasto, g.descripcion, g.observacion, g.monto, g.fecha, g.idcategoria, c.categoria, t.tipogasto 
    FROM gasto g INNER JOIN categoriagasto c ON g.idcategoria=c.idcategoria 
    INNER JOIN tipogasto t ON c.idtipogasto=t.idtipogasto
    WHERE g.idtienda=:idtienda ORDER BY g.idgasto;');
    $data->execute(array(':idtienda' => $idtienda));
    $data = $data->fetchAll();
    return $data;
}
// ':idTienda' => $_SESSION['tienda'], ':idUser' => $_SESSION['userID']

function getDetalleGasto($idgasto) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT g.idgasto, g.idcategoria, g.monto, g.descripcion, g.observacion, g.fecha, c.categoria 
    FROM gasto g INNER JOIN categoriagasto c ON g.idcategoria=c.idcategoria WHERE g.idgasto=:idgasto;');
    $data->execute(array(':idgasto' => $idgasto));
    $data = $data->fetchAll();
    return $data;
}

function insertDetalleGasto($idcategoria, $monto, $descripcion, $observacion, $idtienda, $tipouserpago) {
    $gdb = getConnection();
    $sent = $gdb->prepare('insert into gasto(idcategoria, monto, descripcion, observacion, idtienda, idusuario, fecha, tipouserpago) 
        values(:idcategoria, :monto, :descripcion, :observacion, :idtienda, :idusuario, CURRENT_DATE, :tipouserpago);');
    $exito = $sent->execute(array(':idcategoria' => $idcategoria, ':monto' => $monto, ':descripcion' => $descripcion, ':observacion' => $observacion, ':idtienda' => $idtienda, ':idusuario' => $_SESSION['userID'], ':tipouserpago' => $tipouserpago));
    return $exito;
}

function updateDetalleGasto($id, $idcategoria, $monto, $descripcion, $observacion) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update gasto set idcategoria = :idcategoria, monto = :monto, descripcion = :descripcion, observacion = :observacion where idgasto = :id');
    $exito = $sent->execute(array(':idcategoria' => $idcategoria, ':monto' => $monto, ':descripcion' => $descripcion, ':observacion' => $observacion, ':id' => $id));
    return $exito;
}

function listDetalleGastosByFecha($idtienda, $fec) {
    $gdb = getConnection();
    $data;
    
    if($idtienda==0){
        $data = $gdb->prepare('SELECT g.idgasto, g.descripcion, g.observacion, g.monto, g.fecha, g.idcategoria, c.categoria, t.tipogasto, 
        ti.tienda, concat(u.nombres, " ", u.apellidos) as usuario, g.tipouserpago 
        FROM gasto g INNER JOIN categoriagasto c ON g.idcategoria=c.idcategoria 
        INNER JOIN tienda ti ON g.idtienda=ti.idtienda 
        INNER JOIN usuario u ON g.idusuario=u.idusuario 
        INNER JOIN tipogasto t ON c.idtipogasto=t.idtipogasto 
        WHERE g.fecha=:fecha ORDER BY g.idgasto;');
        $data->execute(array(':fecha' => $fec));
    }else{
        $data = $gdb->prepare('SELECT g.idgasto, g.descripcion, g.observacion, g.monto, g.fecha, g.idcategoria, c.categoria, t.tipogasto, 
        ti.tienda, concat(u.nombres, " ", u.apellidos) as usuario, g.tipouserpago 
        FROM gasto g INNER JOIN categoriagasto c ON g.idcategoria=c.idcategoria 
        INNER JOIN tienda ti ON g.idtienda=ti.idtienda 
        INNER JOIN usuario u ON g.idusuario=u.idusuario 
        INNER JOIN tipogasto t ON c.idtipogasto=t.idtipogasto
        WHERE g.idtienda=:idtienda and g.fecha=:fecha ORDER BY g.idgasto;');
        $data->execute(array(':idtienda' => $idtienda, ':fecha' => $fec));
    }
    
    $data = $data->fetchAll();
    return $data;
}

function listDetalleGastosByMes($idtienda, $anio, $mes) {
    $gdb = getConnection();
    $data;
    $fec = $anio.'-'.$mes.'-%';
    if($idtienda==0){
        $data = $gdb->prepare('SELECT g.idgasto, g.descripcion, g.observacion, g.monto, g.fecha, g.idcategoria, c.categoria, t.tipogasto, 
        ti.tienda, concat(u.nombres, " ", u.apellidos) as usuario, g.tipouserpago 
        FROM gasto g INNER JOIN categoriagasto c ON g.idcategoria=c.idcategoria 
        INNER JOIN tienda ti ON g.idtienda=ti.idtienda 
        INNER JOIN usuario u ON g.idusuario=u.idusuario 
        INNER JOIN tipogasto t ON c.idtipogasto=t.idtipogasto 
        WHERE g.fecha like :fecha ORDER BY g.idgasto;');
        $data->execute(array(':fecha' => $fec));
    }else{
        $data = $gdb->prepare('SELECT g.idgasto, g.descripcion, g.observacion, g.monto, g.fecha, g.idcategoria, c.categoria, t.tipogasto, 
        ti.tienda, concat(u.nombres, " ", u.apellidos) as usuario, g.tipouserpago 
        FROM gasto g INNER JOIN categoriagasto c ON g.idcategoria=c.idcategoria 
        INNER JOIN tienda ti ON g.idtienda=ti.idtienda 
        INNER JOIN usuario u ON g.idusuario=u.idusuario 
        INNER JOIN tipogasto t ON c.idtipogasto=t.idtipogasto
        WHERE g.idtienda = :idtienda and g.fecha like :fecha ORDER BY g.idgasto;');
        $data->execute(array(':idtienda' => $idtienda, ':fecha' => $fec));
    }
    
    $data = $data->fetchAll();
    return $data;
}

function listDetalleGastosByAnio($idtienda, $anio) {
    $gdb = getConnection();
    $data;
    $fec = $anio.'-%';
    if($idtienda==0){
        $data = $gdb->prepare('SELECT g.idgasto, g.descripcion, g.observacion, g.monto, g.fecha, g.idcategoria, c.categoria, t.tipogasto, 
        ti.tienda, concat(u.nombres, " ", u.apellidos) as usuario, g.tipouserpago 
        FROM gasto g INNER JOIN categoriagasto c ON g.idcategoria=c.idcategoria 
        INNER JOIN tienda ti ON g.idtienda=ti.idtienda 
        INNER JOIN usuario u ON g.idusuario=u.idusuario 
        INNER JOIN tipogasto t ON c.idtipogasto=t.idtipogasto 
        WHERE g.fecha like :fecha ORDER BY g.idgasto;');
        $data->execute(array(':fecha' => $fec));
    }else{
        $data = $gdb->prepare('SELECT g.idgasto, g.descripcion, g.observacion, g.monto, g.fecha, g.idcategoria, c.categoria, t.tipogasto, 
        ti.tienda, concat(u.nombres, " ", u.apellidos) as usuario, g.tipouserpago 
        FROM gasto g INNER JOIN categoriagasto c ON g.idcategoria=c.idcategoria 
        INNER JOIN tienda ti ON g.idtienda=ti.idtienda 
        INNER JOIN usuario u ON g.idusuario=u.idusuario 
        INNER JOIN tipogasto t ON c.idtipogasto=t.idtipogasto
        WHERE g.idtienda = :idtienda and g.fecha like :fecha ORDER BY g.idgasto;');
        $data->execute(array(':idtienda' => $idtienda, ':fecha' => $fec));
    }
    
    $data = $data->fetchAll();
    return $data;
}
?>