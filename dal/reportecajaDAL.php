<?php

require 'conexion.php';

function rptTY($año, $idt) {
    $gdb = getConnection();
    $data = $gdb->query("SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 2), '/', -1)  AS mes,SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 3), '/', -1) AS ano, CAST(SUM(a.efectivo+a.tarjeta) AS DECIMAL(10,2)) AS acuenta,CAST(SUM(a.tarjeta) AS DECIMAL(10,2)) AS saldo,CAST(SUM(a.efectivo) AS DECIMAL(10,2)) AS total FROM acuenta a inner join venta v on a.codventa=v.idventa WHERE v.estado<>'anulado' AND SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 3), '/', -1)='" . $año . "' AND v.idTienda='" . $idt . "' GROUP BY mes,ano");
    $data = $data->fetchAll();
    return $data;
}

function rptAY($año) {
    $gdb = getConnection();
    $data = $gdb->query("SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 3), '/', -1) AS ano, t.tienda, CAST(SUM(a.efectivo+a.tarjeta) AS DECIMAL(10,2)) AS acuenta, CAST(SUM(a.tarjeta) AS DECIMAL(10,2)) AS saldo, CAST(SUM(a.efectivo) AS DECIMAL(10,2)) AS total FROM acuenta a inner join venta v on a.codventa=v.idventa left join tienda t on v.idTienda=t.idtienda WHERE v.estado<>'anulado' AND SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 3), '/', -1)='" . $año . "' GROUP BY v.idTienda");
    $data = $data->fetchAll();
    return $data;
}
/*
function rptCA($dia) {
    $gdb = getConnection();
    $data = $gdb->query('SELECT vn.fv, t.tienda, CASE WHEN (SELECT CAST(SUM(v.total) AS DECIMAL(10,2)) AS total FROM venta v left join tienda t on v.idTienda=t.idtienda where v.tipoComp=\'recibo\' and v.idTienda=vn.idTienda and v.fv=\''.$dia.'\')is null THEN \'0.00\' ELSE (SELECT CAST(SUM(v.total) AS DECIMAL(10,2)) AS total FROM venta v left join tienda t on v.idTienda=t.idtienda where v.tipoComp=\'recibo\' and v.idTienda=vn.idTienda and v.fv=\''.$dia.'\') END as recibo, CASE WHEN (SELECT CAST(SUM(v.total) AS DECIMAL(10,2)) AS total  FROM venta v left join tienda t on v.idTienda=t.idtienda where v.tipoComp=\'boleta\'and v.idTienda=vn.idTienda and v.fv=\''.$dia.'\')is null THEN \'0.00\' ELSE (SELECT CAST(SUM(v.total) AS DECIMAL(10,2)) AS total  FROM venta v left join tienda t on v.idTienda=t.idtienda where v.tipoComp=\'boleta\'and v.idTienda=vn.idTienda and v.fv=\''.$dia.'\') END as boleta FROM venta vn left join tienda t on vn.idTienda=t.idtienda where vn.fv=\''.$dia.'\' group by t.tienda;');
    $data = $data->fetchAll();
    return $data;
}
function rptETA($dia) {
    $gdb = getConnection();
    $data = $gdb->query('select v.fv,t.tienda, CAST(SUM(a.efectivo) AS DECIMAL(10,2))as efectivo,CAST(SUM(a.tarjeta) AS DECIMAL(10,2)) as tarjeta from acuenta a left join venta v on a.codVenta=v.idventa left join tienda t on v.idTienda=t.idtienda where v.fv=\''.$dia.'\' and  v.tipoComp=\'boleta\' group by t.tienda;');
    $data = $data->fetchAll();
    return $data;
}
*/
function rptAM($mes,$año) {
    $gdb = getConnection();
    $data = $gdb->query("SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 2), '/', -1) AS mes,SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 3), '/', -1) AS ano,t.tienda,CAST(SUM(a.efectivo+a.tarjeta) AS DECIMAL(10,2)) AS acuenta,CAST(SUM(a.tarjeta) AS DECIMAL(10,2)) AS saldo,CAST(SUM(a.efectivo) AS DECIMAL(10,2)) AS total FROM acuenta a inner join venta v on a.codventa=v.idventa left join tienda t on v.idTienda=t.idtienda WHERE v.estado<>'anulado' AND SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 3), '/', -1)='" . $año . "' and SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 2), '/', -1)='" . $mes . "' GROUP BY v.idTienda");
    $data = $data->fetchAll();
    return $data;
}
function rptTM($mes,$año, $idt) {
    $gdb = getConnection();
    $data = $gdb->query("SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 1), '/', -1)  AS dia,SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 2), '/', -1)  AS mes,SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 3), '/', -1) AS ano,CAST(SUM(a.efectivo+a.tarjeta) AS DECIMAL(10,2)) AS acuenta,CAST(SUM(a.tarjeta) AS DECIMAL(10,2)) AS totaltarjeta,CAST(SUM(a.efectivo) AS DECIMAL(10,2)) AS totalefectivo FROM acuenta a inner join venta v on a.codventa=v.idventa WHERE v.estado<>'anulado' AND SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 3), '/', -1)='" . $año . "' AND SUBSTRING_INDEX(SUBSTRING_INDEX(a.fecha, '/', 2), '/', -1)='" . $mes . "' and v.idTienda='" . $idt . "' group by dia;");
    $data = $data->fetchAll();
    return $data;
}
function listTiendas() {
    $gdb = getConnection();
    $data = $gdb->query('SELECT tienda FROM tienda where idTienda<>1 order by tienda');
    $data = $data->fetchAll();
    return $data;
}
?>