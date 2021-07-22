<?php

require 'conexion.php';

function getReporteBoleta($tienda, $fechainicio, $fechafin, $razon) {
    $gdb = getConnection();
    if ($tienda == "0") {
        $consulta = 'SELECT v.idventa, v.fv, t.tienda, v.nombre, v.apellido, v.total, v.estado, v.tipoComp, v.observacion, v.fe, v.he, v.estadopedido, v.estadollamada 
                        FROM venta v 
                        inner join tienda t on t.idtienda=v.idtienda 
                        where v.estado<>"anulado" and
                        str_to_date(v.fv,"%d/%m/%Y")>="' . $fechainicio . '" and str_to_date(v.fv,"%d/%m/%Y")<="' . $fechafin . '"';
        if ($razon == "procesados") {
            $consulta .=' and v.estadopedido=1';
        } else if ($razon == "noprocesados") {
            $consulta .=' and v.estadopedido=0';
        }else if ($razon == "sincheck") {
            $consulta .=' and v.estadollamada=0';
        }
        $consulta .= ' ORDER BY str_to_date(v.fe,"%d/%m/%Y"), v.he, v.idventa;';
    } else {
        $consulta = 'SELECT v.idventa, v.fv, t.tienda, v.nombre, v.apellido, v.total, v.estado, v.tipoComp, v.observacion, v.fe, v.he, v.estadopedido, v.estadollamada 
                        FROM venta v 
                        inner join tienda t on t.idtienda=v.idtienda 
                        where v.idTienda=' . $tienda . ' and v.estado<>"anulado" and
                        str_to_date(v.fv,"%d/%m/%Y")>="' . $fechainicio . '" and str_to_date(v.fv,"%d/%m/%Y")<="' . $fechafin . '"';
        if ($razon == "procesados") {
            $consulta .=' and v.estadopedido=1';
        } else if ($razon == "noprocesados") {
            $consulta .=' and v.estadopedido=0';
        } else if ($razon == "sincheck") {
            $consulta .=' and v.estadollamada=0';
        }
        $consulta .= ' ORDER BY str_to_date(v.fe,"%d/%m/%Y"), v.he, v.idventa;';
    }
    $data = $gdb->query($consulta);
    $data = $data->fetchAll();
    return $data;
}

function getReporteBoletaByCodVenta($codventa) {
    $gdb = getConnection();

    $consulta = 'SELECT v.idventa, v.fv, t.tienda, v.nombre, v.apellido, v.total, v.estado, v.tipoComp, v.observacion, v.fe, v.he, v.estadopedido, v.estadollamada 
                    FROM venta v 
                    inner join tienda t on t.idtienda=v.idtienda 
                    where v.estado<>"anulado" and 
                    v.idventa="' . $codventa . '" 
                    ORDER BY str_to_date(v.fe,"%d/%m/%Y"), v.he, v.idventa;';
//v.estadopedido=0 and 
    $data = $gdb->query($consulta);
    $data = $data->fetchAll();
    return $data;
}

function getDetalleGasto($idventa) {
    $gdb = getConnection();
    $consulta = 'SELECT g.idgasto, g.fecharegistro, g.fecha, g.serie, g.correlativo, g.monto, p.razonsocial, g.descripcion, d.descripcion as descventa, d.cantidad, d.precio, d.importe, d.isgasto, d.iddetalle, g.idgasto, d.tipo
                FROM gasto g inner join proveedor p on g.idproveedor=p.idproveedor 
                right join detalleventa d on g.iddetalle=d.iddetalle
                WHERE d.idventa=' . $idventa . ' and d.tipo<>"C";';
    $data = $gdb->query($consulta);
    $data = $data->fetchAll();
    return $data;
}

function getDetalleGastoReporte($idventa) {
    $gdb = getConnection();
    $consulta = 'SELECT g.idgasto, g.fecharegistro, g.fecha, g.serie, g.correlativo, g.monto, p.razonsocial, g.descripcion, d.descripcion as descventa, d.cantidad, d.precio, d.importe, d.isgasto, d.iddetalle, g.idgasto, d.tipo, v.idtienda 
                FROM gasto g left join proveedor p on g.idproveedor=p.idproveedor 
                right join detalleventa d on g.iddetalle=d.iddetalle
                left join venta v on d.idventa=v.idventa
                WHERE d.idventa=' . $idventa . ' and (d.tipo="D" or d.tipo="C");';
    $data = $gdb->query($consulta);
    $data = $data->fetchAll();
    return $data;
}
