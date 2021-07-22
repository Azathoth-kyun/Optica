<?php

require 'conexion.php';

function getProducto($id) {
    $gdb = getConnection();
    $data = $gdb->prepare('select * FROM productos where idproducto=:id');
    $data->execute(array(':id' => $id));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function getByIdProducto1($id){
    $gdb = getConnection();
    $data = $gdb->prepare("SELECT codigobarras,producto,costo,venta FROM productos WHERE codigobarras=:id");
    $data->execute(array(':id' => $id));
    $data = $data->fetchAll();
    return $data;
}

function getProductoXP($p) {
    $gdb = getConnection();
    $data = $gdb->prepare('select * FROM productos where producto=:p');
    $data->execute(array(':p' => $p));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function findProducto($parametros) {
    if (count($parametros) > 0) {
        if ($parametros[0] != "") {
            $statement = 'SELECT producto FROM productos where producto like \'%' . $parametros[0] . '%\' ';
            for ($i = 1; $i < count($parametros); $i++) {
                $param = $parametros[$i];
                if ($param != '' && $param != ' ') {
                    $statement = $statement . ' and producto like \'%' . $param . '%\' ';
                }
            }
            $statement = $statement . ';';
            $gdb = getConnection();
            $data = $gdb->query($statement);
            $data = $data->fetchAll();
            return $data;
        } else {
            return;
        }
    } else {
        return;
    }
}

function getProductoCodigo($cod) {
    $gdb = getConnection();
    $data = $gdb->prepare('select * FROM productos where codigobarras = :id');
    $data->execute(array(':id' => $cod));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}
function getProductoCodigoV($cod,$Tiend) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT p.*,s.canttienda,s.smt FROM productos p left join stock s on p.idproducto=s.idproducto where p.codigobarras=:id and s.idTienda=:tiend');
    $data->execute(array(':id' => $cod,':tiend'=>$Tiend));
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function getxCodTiend($cod, $tiend) {
    $gdb = getConnection();
    if ($tiend != '1') {
        $data = $gdb->prepare('SELECT * from productos p left join stock s on p.idproducto=s.idproducto where p.codigobarras = :id and s.idTienda= :idt');
        $data->execute(array(':id' => $cod,':idt' => $tiend));
    } else {
        $data = $gdb->prepare('select * FROM productos where codigobarras = :id');
        $data->execute(array(':id' => $cod));
    }
   
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0];
    } else {
        return;
    }
}

function listProductos() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT * FROM productos order by producto');
    $data = $data->fetchAll();
    return $data;
}

function listProductosConStockByTienda() {
    $gdb = getConnection();
    $idtienda = $_SESSION['tienda'];
    $data = $gdb->prepare('SELECT DISTINCT p.idproducto, p.producto, p.codigobarras, p.costo, p.venta, p.tope, p.cantalmacen, p.sm '
            . ' FROM productos p INNER JOIN stock s ON p.idproducto=s.idproducto WHERE s.idtienda=:idtienda and s.canttienda>0 order by producto;');
    $data->execute(array(':idtienda' => $idtienda));
    $data = $data->fetchAll();
    return $data;
}

function listSM($tipo) {
    if ($tipo == 'td') {
        $tipo = 'anttienda<smt';
    } else {
        $tipo = 'cantalmacen<sm';
    }
    $gdb = getConnection();
    $data = $gdb->query('SELECT * FROM productos where estado=1 and ' . $tipo . ' order by producto');
    $data = $data->fetchAll();
    return $data;
}

function listProductosXtipo($cat, $tipo) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT * FROM productos where estado=1 and ' . $cat . '=:tipo');
    $data->execute(array(':tipo' => $tipo));
    $data = $data->fetchAll();
    return $data;
}

function listProductosXtienda($tienda) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT * from productos p left join stock s on p.idproducto=s.idproducto where s.idTienda=:tienda');
    $data->execute(array(':tienda' => $tienda));
    $data = $data->fetchAll();
    return $data;
}

function listProductosXAlmacen() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT * from productos');
    $data = $data->fetchAll();
    return $data;
}

function insertProductos($cod, $desc, $costo, $venta, $tope, $cant, $sm, $inicio) {
    $gdb = getConnection();
    $sent = $gdb->prepare('INSERT into productos(producto,codigobarras,costo,venta,tope,cantalmacen,sm) 
                           values(:prod, :cod, :costo,:venta, :tope, :ca, :sm )');
    $exito = $sent->execute(array(':prod' => $desc, ':cod' => $cod, ':costo' => $costo, ':venta' => $venta, ':tope' => $tope, ':ca' => $cant, ':sm' => $sm));

    $sent = $gdb->prepare('update parametros set descripcion=:inicio WHERE idparametro=9');
    $exito = $sent->execute(array(':inicio' => $inicio));
    return $exito;
}

function updateProductos($id, $cod, $desc, $costo, $venta, $tope) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update productos set producto=:prod,codigobarras=:cod,costo=:costo ,venta=:venta,tope=:tope WHERE idproducto=:id');
    $exito = $sent->execute(array(':prod' => $desc, ':cod' => $cod, ':costo' => $costo, ':venta' => $venta, ':tope' => $tope, ':id' => $id));
    return $exito;
}

function postearComision($id,$comision){
    $gdb = getConnection();
    $date = date('Y-m-d');
    $sent = $gdb->prepare('INSERT into productocomision(idarticulo,comision,fecha,estado) 
                           values(:id, :comision, :fecha, 1) ON DUPLICATE KEY UPDATE comision= :comision');
    $exito = $sent->execute(array(':id' => $id, ':comision' => $comision, ':fecha' => $date));
    return $exito;
}

function updateSM($id, $tx, $tiend) {
    $gdb = getConnection();
    if ($tiend != '1') {
        $sent = $gdb->prepare('UPDATE stock SET smt=:smt WHERE idproducto=:id and idTienda=:tiend');
        $exito = $sent->execute(array(':smt' => $tx, ':id' => $id, ':tiend' => $tiend));
    } else {
        $sent = $gdb->prepare('update productos set sm=:sm WHERE idproducto=:id');
        $exito = $sent->execute(array(':sm' => $tx, ':id' => $id));
    }
    return $exito;
}

function removeUsuario($id) {
    $gdb = getConnection();
    $sent = $gdb->prepare('update productos set estado = 0 where  idproducto= :id');
    $exito = $sent->execute(array(':id' => $id));
    return $exito;
}

?>
