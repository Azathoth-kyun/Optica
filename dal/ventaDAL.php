<?php

require 'conexion.php';
session_start();


function listVenta() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT * FROM venta order by idventa desc');
    $data = $data->fetchAll();
    return $data;
}

function getDia($fec, $idTienda) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT a.codVenta, a.fecha,a.hora,v.refraccion,concat(v.nombre,\' \',v.apellido) as paciente,a.efectivo,a.tarjeta,a.tipoTarjeta,v.estado, v.tipocomp, v.estadopedido FROM acuenta a left join venta v on a.codVenta=v.idventa where a.fecha=:fec  and v.idTienda=:idT order by  a.codVenta desc');
    $data->execute(array(':fec' => $fec, ':idT' => $idTienda));
    $filas = $data->fetchAll();
    return $filas;
}

function getDiaPen($fec, $idTienda) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT distinct a.codVenta, a.fecha,a.hora,v.refraccion,concat(v.nombre,\' \',v.apellido) as paciente,a.efectivo,a.tarjeta,a.tipoTarjeta,v.estado, v.tipocomp, v.estadopedido FROM acuenta a left join venta v on a.codVenta=v.idventa where v.idTienda=:idT and estado=\'pendiente\' order by  a.codVenta desc');
    $data->execute(array(':idT' => $idTienda));
    $filas = $data->fetchAll();
    $fila2 = $filas;
    $filaa = $filas;
    $conteo2 = count($filaa);
    $conteo = count($fila2);
    for ($i=0; $i < $conteo; $i++) { 
        $aux = $i+1;
        for ($k=$aux; $k <= $conteo2 ; $k++) { 
            if($fila2[$i][0]==$filaa[$k][0]){
                $filaa[$k][5]=$filaa[$k][5] + $fila2[$i][5];
                $filaa[$k][5]=number_format((float)$filaa[$k][5], 2, '.', '');
                array_splice($filaa, $i, 1);
                $conteo2 = count($filaa);
                break;
            }
        }
    }
    $filas=$filaa;
    return $filas;
}


function getDiaPac($fec, $idTienda, $criterio) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT a.codVenta, a.fecha,a.hora,v.refraccion,concat(v.nombre,\' \',v.apellido) as paciente,a.efectivo,a.tarjeta,a.tipoTarjeta,v.estado, v.tipocomp, v.estadopedido FROM acuenta a left join venta v on a.codVenta=v.idventa where v.idTienda=:idT and concat(trim(v.nombre),\' \',trim(v.apellido))  like \'%' . $criterio . '%\' order by  a.codVenta desc');
    $data->execute(array(':idT' => $idTienda));
    $filas = $data->fetchAll();
    return $filas;
}

function listVentaCaja() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT * FROM venta where estado=\'pendiente\' order by idventa desc');
    $data = $data->fetchAll();
    return $data;
}

function listCliente() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT cliente FROM venta group by cliente;');
    $data = $data->fetchAll();
    return $data;
}

function listDetalle($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT d.tipo,d.cantidad,d.descripcion,d.precio,d.importe,d.iddetalle,g.idgasto, d.isgasto 
             FROM detalleventa d left join gasto g on d.iddetalle=g.iddetalle 
             where d.idventa=:id order by iddetalle;');
    $data->execute(array(':id' => $id));
    $data = $data->fetchAll();
    return $data;
}

function isPagoConTarjeta($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT codventa FROM acuenta where codventa=:id and tarjeta>0;');
    $data->execute(array(':id' => $id));
    $cantidad = $data->rowCount();
    
    return $cantidad;
}

function insertVenta($fecha, $hora, $tc, $idclie, $doc, $cliente, $total, $estado, $productos) {
    $gdb = getConnection();
    //$gdb->beginTransaction();

    $data = $gdb->prepare('INSERT INTO venta(fecha,hora,tc,idClie,doc,cliente,total,estado)VALUES(:fecha,:hora,:tc,:idClie,:doc,:cliente,:total,:estado)');
    $exito = $data->execute(array(':fecha' => $fecha, ':hora' => $hora, ':tc' => $tc, ':idClie' => $idclie, ':doc' => $doc, ':cliente' => $cliente, ':total' => $total, ':estado' => $estado));
    if ($exito) {
        $insertId = $gdb->lastInsertId();
    } else {
        $insertId = '"';
    }
    for ($i = 0; $i < count($productos); ++$i) {
        $sent = $gdb->prepare('insert into detalleventa(idventa, idproducto,precio, cantidad) values(:idv, :idP, :prec, :cant)');
        $exito = $sent->execute(array(':idv' => $insertId, ':idP' => $productos[$i][1], ':prec' => $productos[$i][4], ':cant' => $productos[$i][3]));

        $data = $gdb->prepare('select canttienda FROM productos where idproducto=:id');
        $data->execute(array(':id' => $productos[$i][1]));
        $cantidadP = $data->fetchAll();

        $cantidadP[0][0] = $cantidadP[0][0] - $productos[$i][3];

        $sent = $gdb->prepare('update productos set canttienda=:ca WHERE idproducto=:id');
        $exito = $sent->execute(array(':ca' => $cantidadP[0][0], ':id' => $productos[$i][1]));
    }
    //$gdb->rollBack();
    return $exito;
}

function insertVentaC($nombre, $apellido, $direccion, $telefono, $fv, $hv, $fe, $he, $total, $estado, $documento, $numDoc, $refraccion, $observacion, $fc, $anulado, $descAnulado, $productos, $saldo, $efectivo, $tarjeta, $tipot, $tipocompro) {
    $gdb = getConnection();
    $data = $gdb->prepare('INSERT INTO venta(nombre,apellido,direccion,telefono,fv,hv,fe,he,total,estado,documento,numDoc,refraccion,observacion,fc,anulado,descAnulado, idTienda,idUser,saldo,costProd,costLunas,tecnico,laboratorio)VALUES (:nombre,:apellido,:direccion,:telefono,:fv,:hv,:fe,:he,:total,:estado,:documento,:numDoc,:refraccion,:observacion,:fc,:anulado,:descAnulado, :idTienda,:idUser,:saldo,\'\',\'\',\'\',\'\')');
    $exito = $data->execute(array(':nombre' => $nombre, ':apellido' => $apellido, ':direccion' => $direccion, ':telefono' => $telefono, ':fv' => $fv, ':hv' => $hv, ':fe' => $fe, ':he' => $he, ':total' => $total, ':estado' => $estado, ':documento' => $documento, ':numDoc' => $numDoc, ':refraccion' => $refraccion, ':observacion' => $observacion, ':fc' => $fc, ':anulado' => $anulado, ':descAnulado' => $descAnulado, ':idTienda' => $_SESSION['tienda'], ':idUser' => $_SESSION['userID'], ':saldo' => $saldo));
    if ($exito) {
        $insertId = $gdb->lastInsertId();
    } else {
        $insertId = '';
    }
    for ($i = 0; $i < count($productos); $i++) {
        if ($productos[$i][0] == 'D') {
            $sent = $gdb->prepare('INSERT INTO dioptrias(ojo,tipo,material,variacion,ptratamiento,stratamiento,tipoVision,esf,cil,eje,addd,dip,venta,codVenta)VALUES(:ojo,:tipo,:material,:variacion,:ptratamiento,:stratamiento,:tipoVision,:esf,:cil,:eje,:addd,:dip,:venta,:codVenta)');
            $exito = $sent->execute(array(':ojo' => $productos[$i][5], ':tipo' => $productos[$i][6], ':material' => $productos[$i][7], ':variacion' => $productos[$i][8], ':ptratamiento' => $productos[$i][9], ':stratamiento' => $productos[$i][10], ':tipoVision' => $productos[$i][11], ':esf' => $productos[$i][12], ':cil' => $productos[$i][13], ':eje' => $productos[$i][14], ':addd' => $productos[$i][16], ':dip' => $productos[$i][15], ':venta' => $productos[$i][17], ':codVenta' => $insertId));
        } else if ($productos[$i][0] == 'M') {
            $sent = $gdb->prepare('update monturas set idVenta=:ca WHERE idmonturas=:id');
            $exito = $sent->execute(array(':ca' => $insertId, ':id' => $productos[$i][5]));
        } else if ($productos[$i][0] == 'P') {
            $data = $gdb->prepare('SELECT canttienda FROM stock where idproducto=:id and idTienda=:idt');
            $data->execute(array(':id' => $productos[$i][5], ':idt' => $_SESSION['tienda']));
            $cantidadP = $data->fetchAll();
            $cantidadP[0][0] = $cantidadP[0][0] - $productos[$i][1];
            $sent = $gdb->prepare('update stock set canttienda=:ca WHERE idproducto=:id and idTienda=:idt');
            $exito = $sent->execute(array(':ca' => $cantidadP[0][0], ':id' => $productos[$i][5], ':idt' => $_SESSION['tienda']));
        }
        $sent = $gdb->prepare('INSERT INTO detalleventa(idventa,tipo,cantidad,descripcion,precio,importe)VALUES(:idventa,:tipo,:cantidad,:descripcion,:precio,:importe)');
        $exito = $sent->execute(array(':idventa' => $insertId, ':tipo' => $productos[$i][0], ':cantidad' => $productos[$i][1], ':descripcion' => $productos[$i][2], ':precio' => $productos[$i][3], ':importe' => $productos[$i][4]));
        
        if ($productos[$i][0] == 'M') {
            $sent = $gdb->prepare('insert into historialmovimiento(idmonturas, fecha, hora, indicador, idtiendaubi)'
                    . 'values(:id, CURRENT_DATE, curTime(), :indicador, :idtiendaubi)');
            $exito = $sent->execute(array(':id' => $productos[$i][5], ':indicador' => 'VENDIDO', ':idtiendaubi' => $_SESSION['tienda']));
        }
    }
    $varAux = (double) $saldo;
    if (!$varAux > 0) {
        $sent = $gdb->prepare('update venta set estado=\'cancelado\' WHERE idVenta=:ca');
        $exito = $sent->execute(array(':ca' => $insertId));
    }
    $sent = $gdb->prepare('INSERT INTO acuenta(codVenta,fecha,hora,efectivo,tarjeta,tipoTarjeta,saldo)value(:codVenta,:fecha,:hora,:efectivo,:tarjeta,:tipoTarjeta,:saldo)');
    $exito = $sent->execute(array(':codVenta' => $insertId, ':fecha' => $fv, ':hora' => $hv, ':efectivo' => $efectivo, ':tarjeta' => $tarjeta, ':tipoTarjeta' => $tipot, ':saldo' => $saldo));
    return $insertId;
}

function enviarOpto($nombre,$apellido,$telefono,$atendido_optometra,$atendido_vendedor,$tienda){
    $gdb = getConnection();
    $sent = $gdb->prepare('INSERT INTO envio_optometra(nombre,apellidos,telefono,atendido_optometra,atendido_vendedor,tienda)VALUES(:nombre,:apellidos,:telefono,:atendido_optometra,:atendido_vendedor,:tienda)');
    $exito = $sent->execute(array(':nombre' => $nombre, ':apellidos' => $apellido, ':telefono' => $telefono, ':atendido_optometra' => $atendido_optometra, ':atendido_vendedor' => $atendido_vendedor, ':tienda' => $tienda));
    return $exito;    
}

function updateacuenta($fv,$hv,$id,$saldo,$efectivo,$tarjeta,$tipot){
    $gdb = getConnection();
    $sent = $gdb->prepare('update venta set saldo = :saldo WHERE idventa=:id');
    $exito = $sent->execute(array(':saldo' => $saldo, ':id' => $id));

    //$sent = $gdb->prepare('update acuenta set fecha= :fv, hora= :hv, saldo= :saldo, efectivo= :efectivo, tarjeta= :tarjeta, tipoTarjeta= :tipot where codVenta= :codVenta');
    //$exito = $sent->execute(array(':codVenta' => $id, ':fv' => $fv, ':hv' => $hv, ':efectivo' => $efectivo, ':tarjeta' => $tarjeta, ':tipot' => $tipot, ':saldo' => $saldo));
    
    $sent = $gdb->prepare('INSERT INTO acuenta (codVenta, fecha, hora, efectivo, tarjeta, tipoTarjeta, saldo) VALUES (:codVenta,:fv,:hv,:efectivo,:tarjeta,:tipot,:saldo)');
    $exito = $sent->execute(array(':codVenta' => $id, ':fv' => $fv, ':hv' => $hv, ':efectivo' => $efectivo, ':tarjeta' => $tarjeta, ':tipot' => $tipot, ':saldo' => $saldo));
    return $exito;
}

function clienteopto(){
    $gdb = getConnection();
    $data = $gdb->query('select eo.id as id ,concat(eo.nombre," ", eo.apellidos) as cliente, eo.nombre, eo.apellidos, t.tienda from envio_optometra eo inner join tienda t on eo.tienda=t.idtienda where eo.atendido_optometra=0 order by eo.id ASC');
    $data = $data->fetchAll();
    return $data;
}

function atentido($valor,$id){
    $gdb = getConnection();
    $sent = $gdb->prepare('update venta set numDoc= 2 where idventa = :id');
    $exito = $sent->execute(array(':id' => $id));
    return $exito;
}
/*
function insertVentaC($nombre, $apellido, $direccion, $telefono, $fv, $hv, $fe, $he, $total, $estado, $documento, $numDoc, $refraccion, $observacion, $fc, $anulado, $descAnulado, $productos, $saldo, $efectivo, $tarjeta, $tipot, $tipocompro, $razonventa, $codvendedor) {
    $gdb = getConnection();
    $data = $gdb->prepare('INSERT INTO venta(nombre,apellido,direccion,telefono,fv,hv,fe,he,total,estado,documento,numDoc,refraccion,observacion,fc,anulado,descAnulado, idTienda,idUser,saldo,idrazonventa,codvendedor,costProd,costLunas,tecnico,laboratorio)VALUES (:nombre,:apellido,:direccion,:telefono,:fv,:hv,:fe,:he,:total,:estado,:documento,:numDoc,:refraccion,:observacion,:fc,:anulado,:descAnulado, :idTienda,:idUser,:saldo,:razonventa,:codvendedor,\'\',\'\',\'\',\'\')');
    $exito = $data->execute(array(':nombre' => $nombre, ':apellido' => $apellido, ':direccion' => $direccion, ':telefono' => $telefono, ':fv' => $fv, ':hv' => $hv, ':fe' => $fe, ':he' => $he, ':total' => $total, ':estado' => $estado, ':documento' => $documento, ':numDoc' => $numDoc, ':refraccion' => $refraccion, ':observacion' => $observacion, ':fc' => $fc, ':anulado' => $anulado, ':descAnulado' => $descAnulado, ':idTienda' => $_SESSION['tienda'], ':idUser' => $_SESSION['userID'], ':saldo' => $saldo, ':razonventa' => $razonventa, ':codvendedor' => strtoupper($codvendedor)));
    if ($exito) {
        $insertId = $gdb->lastInsertId();
    } else {
        $insertId = '';
    }
    for ($i = 0; $i < count($productos); $i++) {
        if ($productos[$i][0] == 'D') {
            $sent = $gdb->prepare('INSERT INTO dioptrias(ojo,tipo,material,variacion,ptratamiento,stratamiento,tipoVision,esf,cil,eje,addd,dip,venta,codVenta)VALUES(:ojo,:tipo,:material,:variacion,:ptratamiento,:stratamiento,:tipoVision,:esf,:cil,:eje,:addd,:dip,:venta,:codVenta)');
            $exito = $sent->execute(array(':ojo' => $productos[$i][5], ':tipo' => $productos[$i][6], ':material' => $productos[$i][7], ':variacion' => $productos[$i][8], ':ptratamiento' => $productos[$i][9], ':stratamiento' => $productos[$i][10], ':tipoVision' => $productos[$i][11], ':esf' => $productos[$i][12], ':cil' => $productos[$i][13], ':eje' => $productos[$i][14], ':addd' => $productos[$i][16], ':dip' => $productos[$i][15], ':venta' => $productos[$i][17], ':codVenta' => $insertId));
        } else if ($productos[$i][0] == 'M') {
            $sent = $gdb->prepare('update monturas set idVenta=:ca WHERE idmonturas=:id');
            $exito = $sent->execute(array(':ca' => $insertId, ':id' => $productos[$i][5]));
        } else if ($productos[$i][0] == 'P') {
            $data = $gdb->prepare('SELECT canttienda FROM stock where idproducto=:id and idTienda=:idt');
            $data->execute(array(':id' => $productos[$i][5], ':idt' => $_SESSION['tienda']));
            $cantidadP = $data->fetchAll();
            $cantidadP[0][0] = $cantidadP[0][0] - $productos[$i][1];
            $sent = $gdb->prepare('update stock set canttienda=:ca WHERE idproducto=:id and idTienda=:idt');
            $exito = $sent->execute(array(':ca' => $cantidadP[0][0], ':id' => $productos[$i][5], ':idt' => $_SESSION['tienda']));
        }
        $sent = $gdb->prepare('INSERT INTO detalleventa(idventa,tipo,cantidad,descripcion,precio,importe)VALUES(:idventa,:tipo,:cantidad,:descripcion,:precio,:importe)');
        $exito = $sent->execute(array(':idventa' => $insertId, ':tipo' => $productos[$i][0], ':cantidad' => $productos[$i][1], ':descripcion' => $productos[$i][2], ':precio' => $productos[$i][3], ':importe' => $productos[$i][4]));
        
        if ($productos[$i][0] == 'M') {
            $sent = $gdb->prepare('insert into historialmovimiento(idmonturas, fecha, hora, indicador, idtiendaubi)'
                    . 'values(:id, CURRENT_DATE, curTime(), :indicador, :idtiendaubi)');
            $exito = $sent->execute(array(':id' => $productos[$i][5], ':indicador' => 'VENDIDO', ':idtiendaubi' => $_SESSION['tienda']));
        }
    }
    $varAux = (double) $saldo;
    if (!$varAux > 0) {
        $sent = $gdb->prepare('update venta set estado=\'cancelado\' WHERE idVenta=:ca');
        $exito = $sent->execute(array(':ca' => $insertId));
    }
    $sent = $gdb->prepare('INSERT INTO acuenta(codVenta,fecha,hora,efectivo,tarjeta,tipoTarjeta,saldo)value(:codVenta,:fecha,:hora,:efectivo,:tarjeta,:tipoTarjeta,:saldo)');
    $exito = $sent->execute(array(':codVenta' => $insertId, ':fecha' => $fv, ':hora' => $hv, ':efectivo' => $efectivo, ':tarjeta' => $tarjeta, ':tipoTarjeta' => $tipot, ':saldo' => $saldo));
    return $insertId;
}
*/
function getByIdVenta($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT v.idventa, t.tienda FROM venta v INNER JOIN tienda t on v.idtienda = t.idtienda where idventa=:id');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

/*function getVenta($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT * FROM venta where idventa=:id');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}*/

function getVenta($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT v.*, t.tienda FROM venta v, tienda t where idventa=:id and v.idtienda=t.idtienda');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
/*
function getRazonSocialVenta() {
    $gdb = getConnection();
    $data = $gdb->query('select idrazon, razonsocial, ruc, direccion from razonsocialventa where estado=1;');
    $data = $data->fetchAll();
    return $data;
}
*/
function getVentaSN($id, $idt) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT * FROM venta where idventa=:id and estado <> \'anulado\' ');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function cobrar($id, $fv, $hv, $saldo, $efectivo, $tarjeta, $tipot) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update venta set estado = \'cancelado\', fc = :fc, saldo = :saldo WHERE idventa=:id');
    $exito = $sent->execute(array(':fc' => $fv, ':saldo' => $saldo, ':id' => $id));

    $sent = $gdb->prepare('INSERT INTO acuenta(codVenta,fecha,hora,efectivo,tarjeta,tipoTarjeta,saldo)value(:codVenta,:fecha,:hora,:efectivo,:tarjeta,:tipoTarjeta,:saldo)');
    $exito = $sent->execute(array(':codVenta' => $id, ':fecha' => $fv, ':hora' => $hv, ':efectivo' => $efectivo, ':tarjeta' => $tarjeta, ':tipoTarjeta' => $tipot, ':saldo' => $saldo));
    return $exito;
}
function tipoB($id,$tipo){
    $gdb = getConnection();
    $sent = $gdb->prepare('update venta set tipoComp = :tipo WHERE idventa=:id');
    $exito = $sent->execute(array(':tipo' => $tipo, ':id' => $id));
    return $exito;
}

function anularVenta($id) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update venta set estado = \'anulado\' where idventa=:id');
    $exito = $sent->execute(array(':id' => $id));

    $data = $gdb->prepare('select idmonturas from monturas where idventa=:id');
    $data->execute(array(':id' => $id));
    $prod = $data->fetchAll();
    for ($i = 0; $i < count($prod); ++$i) {
        $sent = $gdb->prepare('update monturas set idVenta=NULL WHERE idmonturas=:id');
        $exito = $sent->execute(array(':id' => $prod[$i][0]));
    }
    return $exito;
}
function saveG($id, $lab, $tec, $cl, $cp) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update venta set costProd=:costProd,costLunas=:costLunas,tecnico=:tecnico,laboratorio=:laboratorio WHERE idventa=:id');
    $exito = $sent->execute(array(':costProd' => $cp,':costLunas' => $cl,':tecnico' => $tec,':laboratorio' => $lab, ':id' => $id));
    return $exito;
}

function saveGOP($idventa, $lab, $tec, $cl, $cp, $idtienda) {
    $gdb = getConnection();
    $monto = $cl + $cp;
    $tipouserpago='';
    if($_SESSION['cargo']=='Administrador'){
        $tipouserpago='admin';
    }else{
        $tipouserpago='tienda';
    }
    $descripcion="GOP VENTA: ".$idventa;
    $comentario = 'Laboratorio: '.$lab.' / Costo lunas: '.$cl.' / Técnico: '.$tec.' / Costo producción: '.$cp;
    $sent = $gdb->prepare('insert into gasto(idcategoria, monto, descripcion, observacion, idtienda, idusuario, fecha, tipouserpago) 
        values(:idcategoria, :monto, :descripcion, :observacion, :idtienda, :idusuario, CURRENT_DATE, :tipouserpago);');
    $exito = $sent->execute(array(':idcategoria' => '1', ':monto' => $monto, ':descripcion' => $descripcion, ':observacion' => $comentario, ':idtienda' => $idtienda, ':idusuario' => $_SESSION['userID'], ':tipouserpago' => $tipouserpago));
    return $exito;
}
function UpdGOP($idventa, $lab, $tec, $cl, $cp, $idtienda, $idgasto) {
    $gdb = getConnection();
    $monto = $cl + $cp;
    $tipouserpago='';
    if($_SESSION['cargo']=='Administrador'){
        $tipouserpago='admin';
    }else{
        $tipouserpago='tienda';
    }
    $descripcion="GOP VENTA: ".$idventa;
    $comentario = 'Laboratorio: '.$lab.' / Costo lunas: '.$cl.' / Técnico: '.$tec.' / Costo producción: '.$cp;
    $sent = $gdb->prepare('update gasto set monto=:monto, observacion=:observacion, 
        idusuario=:idusuario where idgasto=:idgasto;');
    $exito = $sent->execute(array(':monto' => $monto, 
        ':observacion' => $comentario, ':idusuario' => $_SESSION['userID'], ':idgasto' => $idgasto));
    return $exito;
}
function getUltimoGasto() {
    $gdb = getConnection();
    $data = $gdb->query('select idgasto FROM gasto ORDER BY idgasto DESC LIMIT 1;');
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0][0];
    } else {
        return;
    }
}

function efectivotoday($fv,$efectivo,$id){
    $gdb = getConnection();
    $data = $gdb->prepare('select fecha,efectivo FROM acuenta WHERE codVenta=:id LIMIT 1;');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if($filas[0][0]==$fv){
        $skere = floatval($efectivo + $filas[0][1]);
        return number_format($skere,2,'.','');
    }
    else{
        return $efectivo;
    }
}

function getIdtiendaByIdVenta($idventa) {
    $gdb = getConnection();
    $data = $gdb->prepare('select idtienda FROM venta WHERE idventa=:idventa LIMIT 1;');
    $data->execute(array(':idventa' => $idventa));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0][0];
    } else {
        return;
    }
}

function saveIdGastoEnVenta($idgasto, $idventa) {
    $gdb = getConnection();
    
    $sent = $gdb->prepare('update venta set idgasto=:idgasto where idventa=:idventa;');
    $exito = $sent->execute(array(':idgasto' => $idgasto, ':idventa' => $idventa));
    return $exito;
}
//ss
function listIngresosByFecha($idtienda, $fec) {
    $gdb = getConnection();
    $data;
    
    if($idtienda==0){
        $data = $gdb->prepare('SELECT a.codVenta, a.fecha,a.hora,v.refraccion,concat(v.nombre,\' \',v.apellido) as paciente,a.efectivo,a.tarjeta,a.tipoTarjeta,v.estado 
            FROM acuenta a left join venta v on a.codVenta=v.idventa 
            WHERE a.fecha=:fecha;');
        $data->execute(array(':fecha' => $fec));
    }else{
        $data = $gdb->prepare('SELECT a.codVenta, a.fecha,a.hora,v.refraccion,concat(v.nombre,\' \',v.apellido) as paciente,a.efectivo,a.tarjeta,a.tipoTarjeta,v.estado 
            FROM acuenta a left join venta v on a.codVenta=v.idventa 
            WHERE v.idtienda=:idtienda and a.fecha=:fecha;');
        $data->execute(array(':idtienda' => $idtienda, ':fecha' => $fec));
    }
    
    $data = $data->fetchAll();
    return $data;
}

function TotalIngresosByFecha($idtienda, $fec) {
    $gdb = getConnection();
    $data;
    
    if($idtienda==0){
        $data = $gdb->prepare('SELECT SUM(a.efectivo) as totale, SUM(a.tarjeta) as totalt 
            FROM acuenta a left join venta v on a.codVenta=v.idventa 
            WHERE a.fecha=:fecha and v.estado!=:estado;');
        $data->execute(array(':fecha' => $fec, ':estado' => 'anulado'));
    }else{
        $data = $gdb->prepare('SELECT SUM(a.efectivo) as totale, SUM(a.tarjeta) as totalt 
            FROM acuenta a left join venta v on a.codVenta=v.idventa 
            WHERE v.idtienda=:idtienda and a.fecha=:fecha and v.estado!=:estado;');
        $data->execute(array(':idtienda' => $idtienda, ':fecha' => $fec, ':estado' => 'anulado'));
    }
    
    $data = $data->fetchAll();
    return $data;
}

function listIngresosByMes($idtienda, $anio, $mes) {
    $gdb = getConnection();
    $data;
    $fec = '%/'.$mes.'/'.$anio;
    if($idtienda==0){
        $data = $gdb->prepare('SELECT a.codVenta, a.fecha,a.hora,v.refraccion,concat(v.nombre,\' \',v.apellido) as paciente,a.efectivo,a.tarjeta,a.tipoTarjeta,v.estado 
            FROM acuenta a left join venta v on a.codVenta=v.idventa 
        WHERE a.fecha like :fecha and v.estado!=:estado;');
        $data->execute(array(':fecha' => $fec, ':estado' => 'anulado'));
    }else{
        $data = $gdb->prepare('SELECT a.codVenta, a.fecha,a.hora,v.refraccion,concat(v.nombre,\' \',v.apellido) as paciente,a.efectivo,a.tarjeta,a.tipoTarjeta,v.estado 
            FROM acuenta a left join venta v on a.codVenta=v.idventa 
            WHERE v.idtienda=:idtienda and a.fecha like :fecha and v.estado!=:estado;');
        $data->execute(array(':idtienda' => $idtienda, ':fecha' => $fec, ':estado' => 'anulado'));
    }
    
    $data = $data->fetchAll();
    return $data;
}

function TotalIngresosByMes($idtienda, $anio, $mes) {
    $gdb = getConnection();
    $data;
    $fec = '%/'.$mes.'/'.$anio;
    if($idtienda==0){
        $data = $gdb->prepare('SELECT SUM(a.efectivo) as totale, SUM(a.tarjeta) as totalt 
            FROM acuenta a left join venta v on a.codVenta=v.idventa 
        WHERE a.fecha like :fecha and v.estado!=:estado;');
        $data->execute(array(':fecha' => $fec, ':estado' => 'anulado'));
    }else{
        $data = $gdb->prepare('SELECT SUM(a.efectivo) as totale, SUM(a.tarjeta) as totalt 
            FROM acuenta a left join venta v on a.codVenta=v.idventa 
            WHERE v.idtienda=:idtienda and a.fecha like :fecha and v.estado!=:estado;');
        $data->execute(array(':idtienda' => $idtienda, ':fecha' => $fec, ':estado' => 'anulado'));
    }
    
    $data = $data->fetchAll();
    return $data;
}

function listIngresosByAnio($idtienda, $anio) {
    $gdb = getConnection();
    $data;
    $fec = '%/'.$anio;
    if($idtienda==0){
        $data = $gdb->prepare('SELECT a.codVenta, a.fecha,a.hora,v.refraccion,concat(v.nombre,\' \',v.apellido) as paciente,a.efectivo,a.tarjeta,a.tipoTarjeta,v.estado 
            FROM acuenta a left join venta v on a.codVenta=v.idventa 
        WHERE a.fecha like :fecha and v.estado!=:estado;');
        $data->execute(array(':fecha' => $fec, ':estado' => 'anulado'));
    }else{
        $data = $gdb->prepare('SELECT a.codVenta, a.fecha,a.hora,v.refraccion,concat(v.nombre,\' \',v.apellido) as paciente,a.efectivo,a.tarjeta,a.tipoTarjeta,v.estado 
            FROM acuenta a left join venta v on a.codVenta=v.idventa 
            WHERE v.idtienda=:idtienda and a.fecha like :fecha and v.estado!=:estado;');
        $data->execute(array(':idtienda' => $idtienda, ':fecha' => $fec, ':estado' => 'anulado'));
    }
    
    $data = $data->fetchAll();
    return $data;
}

function TotalIngresosByAnio($idtienda, $anio) {
    $gdb = getConnection();
    $data;
    $fec = '%/'.$anio;
    if($idtienda==0){
        $data = $gdb->prepare('SELECT SUM(a.efectivo) as totale, SUM(a.tarjeta) as totalt 
            FROM acuenta a left join venta v on a.codVenta=v.idventa 
        WHERE a.fecha like :fecha and v.estado!=:estado;');
        $data->execute(array(':fecha' => $fec, ':estado' => 'anulado'));
    }else{
        $data = $gdb->prepare('SELECT SUM(a.efectivo) as totale, SUM(a.tarjeta) as totalt 
            FROM acuenta a left join venta v on a.codVenta=v.idventa 
            WHERE v.idtienda=:idtienda and a.fecha like :fecha and v.estado!=:estado;');
        $data->execute(array(':idtienda' => $idtienda, ':fecha' => $fec, ':estado' => 'anulado'));
    }
    
    $data = $data->fetchAll();
    return $data;
}

function getVentaDia($fecha, $idtienda){
    $gdb = getConnection();
    $data = $gdb->prepare('select SUM(total) from venta where fv=:fecha and idtienda=:idtienda;');
    $data->execute(array(':fecha' => $fecha, ':idtienda' => $idtienda));
    $data = $data->fetchAll();
    if (count($data) > 0) {
        return $data[0][0];
    }else{
        return 0;
    }
}

function getgastosenventapendientes(){
    $gdb = getConnection();
    $data = $gdb->query('select d.idventa from detalleventa d 
            inner join venta v on d.idventa=v.idventa 
            where d.isgasto=0 and d.tipo="D" and str_to_date(v.fv,"%d/%m/%Y")=CURRENT_DATE and v.estado="pendiente" group by idventa;');
    $data = $data->fetchAll();
    return $data;
}

?>
