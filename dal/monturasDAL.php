<?php

require 'conexion.php';


function getMontura($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT m.*,i.documento,i.numerodocu FROM monturas m left join  ingreso i on i.idingreso=m.idIngreso where m.idmonturas=:id ');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function getMonturasById($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT m.*,i.documento,i.numerodocu, i.fecha, i.hora, m.idventa, concat(v.nombre, " ", v.apellido) as paciente, v.fv, v.hv, t.tienda FROM monturas m left join  ingreso i on i.idingreso=m.idIngreso left join venta v on m.idventa = v.idventa left join tienda t on v.idtienda=t.idtienda where m.idmonturas=:id ');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function getByIdMontura($id) {
    $gdb = getConnection();
    $data = $gdb->prepare("SELECT m.idmonturas FROM monturas m where m.idmonturas=:id");
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function getByIdMontura2($id) {
    $gdb = getConnection();
    $data = $gdb->prepare("SELECT m.costo, m.venta, concat(m.marca,' ',m.modelo,' ',m.tipo,' ',m.color)as montura FROM monturas m where m.idmonturas=:id");
    $data->execute(array(':id' => $id));
    $data = $data->fetchAll();
    return $data;
}

function getMonturaV($id, $tienda) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT m.*,i.documento,i.numerodocu FROM monturas m left join  ingreso i on i.idingreso=m.idIngreso where m.idmonturas=:id and m.idTienda=:idt and m.idTienda<>1');
    $data->execute(array(':id' => $id, ':idt' => $tienda));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function getMonturaVDat($id, $tienda) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT m.idmonturas, m.marca, m.modelo, m.tipo, m.color, m.tope, m.venta, m.enmovimiento, m.idventa,i.documento,i.numerodocu FROM monturas m left join  ingreso i on i.idingreso=m.idIngreso where m.idmonturas=:id and m.idTienda=:idt and m.idTienda<>1');
    $data->execute(array(':id' => $id, ':idt' => $tienda));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function update($idmonturas, $costo, $tope, $marca, $venta, $talla, $puente, $codImpreso, $procedencia, $color, $modelo, $tipo, $estuche, $comentario,$tienda) {
    $gdb = getConnection();
    $sent = $gdb->prepare('UPDATE monturas SET marca=:marca,modelo=:modelo,tipo=:tipo,talla=:talla,puente=:puente,codImpreso=:codImpreso,procedencia=:procedencia,color=:color,estuche=:estuche,comentario=:comentario,costo=:costo,venta=:venta,tope=:tope,idTienda=:tiend WHERE idmonturas=:idmonturas');
    $exito = $sent->execute(array(':marca' => $marca, ':modelo' => $modelo, ':tipo' => $tipo, ':talla' => $talla, ':puente' => $puente, ':codImpreso' => $codImpreso, ':procedencia' => $procedencia, ':color' => $color, ':estuche' => $estuche, ':comentario' => $comentario, ':costo' => $costo, ':venta' => $venta, ':tope' => $tope, ':idmonturas' => $idmonturas, ':tiend' => $tienda));
    return $exito;
}

function getMonNV($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select * FROM monturas where idmonturas=:id and idVenta is null and idTienda=1 and enmovimiento is null');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function getMonPM($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select * FROM monturas where idmonturas=:id and idVenta is null');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function getMonPMbyTienda($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select m.*, t.idtienda, t.tienda FROM monturas m inner join tienda t on m.idtienda=t.idtienda where m.idmonturas=:id;');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function getmonturadiftiend($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select m.* FROM monturas m inner join tienda t on m.idtienda=t.idtienda where m.idmonturas=:id and m.idVenta is null and t.idtienda<>1 and t.estado=1;');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function getMonPMbyTiendaLogin($id) {
    $gdb = getConnection();
    $idtienda = $_SESSION['tienda'];
    $data = $gdb->prepare('select * FROM monturas where idtienda=:idtienda and idmonturas=:id and idVenta is null');
    $data->execute(array(':id' => $id, ':idtienda' => $idtienda));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function getTiendaByID($id) {
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
function ModPrec($precio, $productos){
    $gdb = getConnection();
    for ($i = 0; $i < count($productos); ++$i) {
        $sent = $gdb->prepare('update monturas set tope=:ca WHERE idmonturas=:id');
        $exito = $sent->execute(array(':ca' => $precio, ':id' => $productos[$i][0]));
    }
    return $exito;
}
function getMonInv($id, $tienda) {
    $gdb = getConnection();
    $data = $gdb->prepare('select * FROM monturas where idmonturas=:id and idVenta is null and idTienda=:tienda and enmovimiento is null and estado=1');
    $data->execute(array(':id' => $id, ':tienda' => $tienda));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function listMonturasxTienda($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT idmonturas,concat(marca,\' \',modelo,\' \',tipo,\' \',color)as montura,marca,modelo,tipo,color,\'0\' as verificada FROM monturas where idVenta is null and estado=1 and enmovimiento is null and idTienda=:id order by marca');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    return $filas;
}

function getListDias($idtienda){
    $gdb = getConnection();
    $data =$gdb->prepare('select m.idmonturas, concat(m.marca," ",m.modelo," ",m.tipo), DATEDIFF(NOW(),STR_TO_DATE(concat(substr(i.fecha,1,2),",",substr(i.fecha,4,2),",",substr(i.fecha,7,4)),"%d,%m,%Y")) as dias from monturas m left join ingreso i on i.idingreso = m.idIngreso where m.idVenta is null and m.estado=1 and m.enmovimiento is null and m.idTienda = :id');
    $data->execute(array(':id' => $idtienda));
    $filas = $data->fetchAll();
    return $filas;
}

function listMultiTienda($modelo) {
    $gdb = getConnection();
    $data = $gdb->query('SELECT m.idmonturas,m.marca,m.modelo,m.tipo,m.color,m.estuche,m.comentario,m.venta,m.tope,t.tienda,t.direccion FROM monturas m left join tienda t on m.idTienda=t.idtienda where m.idVenta is null and m.enmovimiento is null and modelo like \''.$modelo.'%\' order by t.tienda desc');
    $data = $data->fetchAll();
    return $data;
}
