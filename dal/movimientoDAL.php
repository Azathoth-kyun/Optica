<?php

require 'conexion.php';
session_start();

function listmovimiento() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT m.idmovimiento, m.fecha, m.hora, m.responsable,concat(u.nombres,\' \',u.apellidos) as recepcion, m.estado, t.tienda FROM movimiento m left join tienda t on t.idtienda=m.responsable left join usuario u on m.recepcion=u.idUsuario order by m.idmovimiento desc LIMIT 80');
    $data = $data->fetchAll();
    return $data;
}

function listmovsinfactura() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT m.idmovimiento, m.fecha, m.hora, m.responsable,concat(u.nombres,\' \',u.apellidos) as recepcion, m.estado, t.tienda, m.documento FROM movimiento m left join tienda t on t.idtienda=m.responsable left join usuario u on m.recepcion=u.idUsuario where m.estado="recibido" and m.documento != "Factura" order by m.idmovimiento desc');
    $data = $data->fetchAll();
    return $data;
}

function listmovimientoP($tienda) {
    $gdb = getConnection();
    $data = $gdb->query('SELECT m.idmovimiento, m.fecha, m.hora, m.responsable,concat(u.nombres,\' \',u.apellidos) as recepcion, m.estado , t.tienda FROM movimiento m left join usuario u on m.recepcion=u.idUsuario left join tienda t on t.idtienda=m.responsable where m.estado=\'pendiente\' and t.idtienda=' . $tienda . ' order by m.idmovimiento desc');
    $data = $data->fetchAll();
    return $data;
}

function listmovimientoProd() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT m.idmovimiento, m.fecha, m.hora, m.responsable,concat(u.nombres,\' \',u.apellidos) as recepcion, m.estado, t.tienda FROM movimientop m left join tienda t on t.idtienda=m.responsable left join usuario u on m.recepcion=u.idUsuario order by m.idmovimiento desc LIMIT 30');
    $data = $data->fetchAll();
    return $data;
}

function listmovimientoPProd($tienda) {
    $gdb = getConnection();
    $data = $gdb->query('SELECT m.idmovimiento, m.fecha, m.hora, m.responsable,concat(u.nombres,\' \',u.apellidos) as recepcion, m.estado , t.tienda FROM movimientop m left join usuario u on m.recepcion=u.idUsuario left join tienda t on t.idtienda=m.responsable where m.estado=\'pendiente\' and t.idtienda=' . $tienda . ' order by m.idmovimiento desc');
    $data = $data->fetchAll();
    return $data;
}

function listDetalle($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT p.idmonturas,concat(p.marca,\' \',p.modelo,\' \',p.tipo,\' \',p.color) as Montura, p.idTienda, t.tienda,p.marca FROM  monturas p left join detallemovimiento d  on p.idmonturas=d.idMontura left join tienda t on d.idTienda=t.idtienda  where d.idmovimiento=:id');
    $data->execute(array(':id' => $id));
    $data = $data->fetchAll();
    return $data;
}

function listDetalleProd($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT p.codigobarras, p.idproducto, p.producto, d.cantidad FROM detallemovimientop d left join productos p on p.idproducto=d.idproducto where d.idmovimiento=:id');
    $data->execute(array(':id' => $id));
    $data = $data->fetchAll();
    return $data;
}

function updrmovimiento($id, $productos, $rec) {
    $gdb = getConnection();
    $data = $gdb->prepare('UPDATE movimiento SET estado=\'recibido\', recepcion=:rec WHERE idmovimiento=:id');
    $result = $data->execute(array(':id' => $id, ':rec' => $rec));
    $productos = stdAArreglo($productos);
    for ($i = 0; $i < count($productos); ++$i) {
        $data = $gdb->prepare('select idTienda FROM detallemovimiento where idmovimiento=:id and idMontura=:mon');
        $data->execute(array(':id' => $id, ':mon' => $productos[$i][0]));
        $tienda = $data->fetchAll();

        $sent = $gdb->prepare('update monturas set enmovimiento=NULL,idTienda=:idT WHERE idmonturas=:id');
        $exito = $sent->execute(array(':idT' => $tienda[0][0], ':id' => $productos[$i][0]));
        
        $sent = $gdb->prepare('insert into historialmovimiento(idmonturas, fecha, hora, indicador, idtiendaubi)'
                . 'values(:id, CURRENT_DATE, curTime(), :indicador, :idtiendaubi)');
        $exito = $sent->execute(array(':id' => $productos[$i][0], ':indicador' => 'RECEPCIONADO', ':idtiendaubi' => $tienda[0][0]));
    }

    return $result;
}
function updrmovimientop($id, $productos, $rec) {
    $gdb = getConnection();
    $data = $gdb->prepare('UPDATE movimientop SET estado=\'recibido\', recepcion=:rec WHERE idmovimiento=:id');
    $result = $data->execute(array(':id' => $id, ':rec' => $rec));
    $productos = stdAArreglo($productos);
    for ($i = 0; $i < count($productos); ++$i) {
        $data = $gdb->prepare('select idTienda FROM detallemovimientop where idmovimiento=:id and idproducto=:idp');
        $data->execute(array(':id' => $id, ':idp' => $productos[$i][1]));
        $tienda = $data->fetchAll();
        
        $data = $gdb->prepare('SELECT canttienda FROM stock where idproducto=:id and idTienda=:idt');
        $data->execute(array(':id' => $productos[$i][1], ':idt' => $tienda[0][0]));
        $cantidadP = $data->fetchAll();
        
        if (count($cantidadP) == 0) {
            $sent = $gdb->prepare('INSERT INTO stock(idproducto,idTienda,canttienda,smt)values(:idP, :idt,:cant, \'0\')');
            $exito = $sent->execute(array(':idP' => $productos[$i][1], ':idt' => $tienda[0][0], ':cant' => $productos[$i][3]));

        } else {
            $cantidadP[0][0] = $cantidadP[0][0] + $productos[$i][3];
            $sent = $gdb->prepare('update stock set canttienda=:ca WHERE idproducto=:id and idTienda=:idt');
            $exito = $sent->execute(array(':ca' => $cantidadP[0][0], ':id' => $productos[$i][1], ':idt' => $tienda[0][0]));
        }
    }

    return $result;
}

function delmovimiento($id) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update movimiento set estado = \'eliminado\' where  idmovimiento=:id');
    $exito = $sent->execute(array(':id' => $id));

    $data = $gdb->prepare('select idMontura from detallemovimiento where idmovimiento=:id');
    $data->execute(array(':id' => $id));
    $prod = $data->fetchAll();
    for ($i = 0; $i < count($prod); ++$i) {
        $sent = $gdb->prepare('update monturas set enmovimiento=NULL WHERE idmonturas=:id');
        $exito = $sent->execute(array(':id' => $prod[$i][0]));
        
        $data = $gdb->prepare('SELECT idhistorial, idtiendaubi FROM historialmovimiento where idmonturas=:id order by idhistorial desc;');
        $data->execute(array(':id' => $prod[$i][0]));
        $filas = $data->fetchAll();
        if (count($filas) > 0) {
            $sent = $gdb->prepare('insert into historialmovimiento(idmonturas, fecha, hora, indicador, idtiendaubi)'
                    . 'values(:id, CURRENT_DATE, curTime(), :indicador, :idtiendaubi)');
            $exito = $sent->execute(array(':id' => $prod[$i][0], ':indicador' => 'CANCELADO', ':idtiendaubi' => $filas[1][1]));
        }
    }
    return $exito;
}

function delmovimientop($id) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update movimientop set estado = \'eliminado\' where  idmovimiento=:id');
    $exito = $sent->execute(array(':id' => $id));

    $data = $gdb->prepare('select idproducto,cantidad from detallemovimientop where idmovimiento=:id');
    $data->execute(array(':id' => $id));
    $prod = $data->fetchAll();
    for ($i = 0; $i < count($prod); ++$i) {
        $data = $gdb->prepare('select cantalmacen FROM productos where idproducto=:id');
        $data->execute(array(':id' => $prod[$i][0]));
        $cantidadP = $data->fetchAll();

        $cantidadP[0][0] = $cantidadP[0][0] + $prod[$i][1];

        $sent = $gdb->prepare('update productos set cantalmacen=:ca WHERE idproducto=:id');
        $exito = $sent->execute(array(':ca' => $cantidadP[0][0], ':id' => $prod[$i][0]));
    }
    return $exito;
}

function insertmovimiento($fecha, $hora, $responsable, $idPer, $estado, $productos, $ruc, $razonsocial, $documento, $nrodocumento, $fechafacturacion) {
    $gdb = getConnection();
    $data = $gdb->prepare('INSERT INTO movimiento(fecha,hora,responsable,recepcion,estado, ruc, razonsocial, documento, nrodocumento, fechafacturacion)VALUES(:fecha,:hora,:res,:rec,:est,:ruc,:razonsocial,:documento,:nrodocumento,:fechafacturacion);');
    $result = $data->execute(array(':fecha' => $fecha, ':hora' => $hora, ':res' => $responsable, ':rec' => $idPer, ':est' => $estado, ':ruc' => $ruc, ':razonsocial' => $razonsocial, ':documento' => $documento, ':nrodocumento' => $nrodocumento, ':fechafacturacion' => $fechafacturacion));
    if ($result) {
        $insertId = $gdb->lastInsertId();
    } else {
        $insertId = '';
    }
    for ($i = 0; $i < count($productos); ++$i) {
        $sent = $gdb->prepare('insert into detallemovimiento(idmovimiento, idMontura, idTienda) values(:idI, :idP, :cant)');
        $exito = $sent->execute(array(':idI' => $insertId, ':idP' => $productos[$i][0], ':cant' => $responsable));

        $sent = $gdb->prepare('update monturas set enmovimiento=:ca WHERE idmonturas=:id');
        $exito = $sent->execute(array(':ca' => $responsable, ':id' => $productos[$i][0]));
        
        $sent = $gdb->prepare('insert into historialmovimiento(idmonturas, fecha, hora, indicador, idtiendaubi)'
                . 'values(:id, CURRENT_DATE, curTime(), :indicador, :idtiendaubi)');
        $exito = $sent->execute(array(':id' => $productos[$i][0], ':indicador' => 'ENVIO', ':idtiendaubi' => $responsable));
    }
    return $exito;
}

function updatedatosfacturacion($ruc, $razonsocial, $documento, $nrodocumento, $fechafacturacion, $movimiento) {
    $gdb = getConnection();
    $data = $gdb->prepare('update  movimiento set ruc=:ruc, razonsocial=:razonsocial, documento=:documento, nrodocumento=:nrodocumento, fechafacturacion=:fechafacturacion where idmovimiento=:idmovimiento');
    $result = $data->execute(array(':ruc' => $ruc, ':razonsocial' => $razonsocial, ':documento' => $documento, ':nrodocumento' => $nrodocumento, ':fechafacturacion' => $fechafacturacion, ':idmovimiento' => $movimiento));
    
    return $result;
}

function insertmovimientop($fecha, $hora, $responsable, $idPer, $estado, $productos) {
    $gdb = getConnection();
    $data = $gdb->prepare('INSERT INTO movimientop(fecha,hora,responsable,recepcion,estado)VALUES(:fecha,:hora,:res,:rec,:est)');
    $result = $data->execute(array(':fecha' => $fecha, ':hora' => $hora, ':res' => $responsable, ':rec' => $idPer, ':est' => $estado));
    if ($result) {
        $insertId = $gdb->lastInsertId();
    } else {
        $insertId = '';
    }
    for ($i = 0; $i < count($productos); ++$i) {
        $sent = $gdb->prepare('insert into detallemovimientop(idmovimiento, idproducto, idTienda,cantidad) values(:idI, :idP,:idt, :cant)');
        $exito = $sent->execute(array(':idI' => $insertId, ':idP' => $productos[$i][1], ':idt' => $responsable, ':cant' => $productos[$i][3]));

        $data = $gdb->prepare('select cantalmacen FROM productos where idproducto=:id');
        $data->execute(array(':id' => $productos[$i][1]));
        $cantidadP = $data->fetchAll();
        $cantidadP[0][0] = $cantidadP[0][0] - $productos[$i][3];

        $sent = $gdb->prepare('update productos set cantalmacen=:ca WHERE idproducto=:id');
        $exito = $sent->execute(array(':ca' => $cantidadP[0][0], ':id' => $productos[$i][1]));
        /*
        $data = $gdb->prepare('SELECT canttienda FROM stock where idproducto=:id and idTienda=:idt');
        $data->execute(array(':id' => $productos[$i][1], ':idt' => $responsable));
        $cantidadP = $data->fetchAll();
        $cantSalida = 0;

        if (count($cantidadP) == 0) {
            $sent = $gdb->prepare('INSERT INTO stock(idproducto,idTienda,canttienda,smt)values(:idP, :idt,:cant, \'0\')');
            $exito = $sent->execute(array(':idP' => $productos[$i][1], ':idt' => $responsable, ':cant' => $productos[$i][3]));

            $sent = $gdb->prepare('update productos set cantalmacen=:ca WHERE idproducto=:id');
            $exito = $sent->execute(array(':ca' => $cantidadP[0][0], ':id' => $productos[$i][1]));
        } else {
            $cantidadP[0][0] = $cantidadP[0][0] - $productos[$i][3];
            $sent = $gdb->prepare('update productos set cantalmacen=:ca WHERE idproducto=:id');
            $exito = $sent->execute(array(':ca' => $cantidadP[0][0], ':id' => $productos[$i][1]));
        }*/
    }
    return $exito;
}

function getmovimiento($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT m.idmovimiento, m.fecha, m.hora, m.responsable,concat(u.nombres,\' \',u.apellidos) as recepcion, m.recepcion as idR , m.estado, t.tienda, m.ruc, m.razonsocial, m.documento, m.nrodocumento, m.fechafacturacion FROM movimiento m left join usuario u on m.recepcion=u.idUsuario left join tienda t on t.idtienda=m.responsable where m.idmovimiento=:id');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function getmovimientop($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT m.idmovimiento, m.fecha, m.hora, m.responsable,concat(u.nombres,\' \',u.apellidos) as recepcion, m.recepcion as idR , m.estado, t.tienda FROM movimientop m left join usuario u on m.recepcion=u.idUsuario left join tienda t on t.idtienda=m.responsable where m.idmovimiento=:id');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function stdAArreglo($d) {
    if (is_object($d)) {
        $d = get_object_vars($d);
    }
    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    } else {
        return $d;
    }
}

?>
