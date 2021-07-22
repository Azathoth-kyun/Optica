<?php

require 'conexion.php';

function rptTY($año, $idt) {
    $gdb = getConnection();
    $data = $gdb->query('SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(fv, \'/\', 2), \'/\', -1)  AS mes,SUBSTRING_INDEX(SUBSTRING_INDEX(fv, \'/\', 3), \'/\', -1) AS ano,CAST(SUM(total) AS DECIMAL(10,2)) AS total,CAST(SUM(saldo) AS DECIMAL(10,2)) AS saldo, CAST(SUM(total-saldo) AS DECIMAL(10,2)) AS acuenta FROM venta WHERE estado<>\'anulado\' AND SUBSTRING_INDEX(SUBSTRING_INDEX(fv, \'/\', 3), \'/\', -1)=\'' . $año . '\' AND idTienda=\'' . $idt . '\' GROUP BY mes,ano');
    $data = $data->fetchAll();
    return $data;
}

function rptAY($año) {
    $gdb = getConnection();
    $data = $gdb->query('SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(v.fv, \'/\', 3), \'/\', -1) AS ano, t.tienda, CAST(SUM(v.total) AS DECIMAL(10,2)) AS total, CAST(SUM(v.saldo) AS DECIMAL(10,2)) AS saldo, CAST(SUM(v.total-v.saldo) AS DECIMAL(10,2)) AS acuenta FROM venta v left join tienda t on v.idTienda=t.idtienda WHERE v.estado<>\'anulado\' AND SUBSTRING_INDEX(SUBSTRING_INDEX(v.fv, \'/\', 3), \'/\', -1)=\'' . $año . '\' GROUP BY v.idTienda');
    $data = $data->fetchAll();
    return $data;
}
function rptCAr($mes, $anio) {
    $gdb = getConnection();
    $data = $gdb->query("SELECT vn.fv, t.tienda, CAST(SUM(vn.total) AS DECIMAL(10,2)) AS total 
FROM venta vn left join tienda t on vn.idTienda=t.idtienda 
where vn.estado<>'anulado' and vn.tipoComp='recibo' and SUBSTRING_INDEX(SUBSTRING_INDEX(vn.fv, '/', 3), '/', -1)='".$anio."' and SUBSTRING_INDEX(SUBSTRING_INDEX(vn.fv, '/', 2), '/', -1)='".$mes."'  group by t.tienda;");
    $data = $data->fetchAll();
    return $data;
}
function rptCAb($mes, $anio) {
    $gdb = getConnection();
    $data = $gdb->query("SELECT vn.fv, t.tienda, CAST(SUM(vn.total) AS DECIMAL(10,2)) AS total 
FROM venta vn left join tienda t on vn.idTienda=t.idtienda 
where vn.estado<>'anulado' and vn.tipoComp='boleta' and SUBSTRING_INDEX(SUBSTRING_INDEX(vn.fv, '/', 3), '/', -1)='".$anio."' and SUBSTRING_INDEX(SUBSTRING_INDEX(vn.fv, '/', 2), '/', -1)='".$mes."'  group by t.tienda;");
    $data = $data->fetchAll();
    return $data;
}
function rptETA($dia) {
    $gdb = getConnection();
    $data = $gdb->query('select v.fv,t.tienda, CAST(SUM(a.efectivo) AS DECIMAL(10,2))as efectivo,CAST(SUM(a.tarjeta) AS DECIMAL(10,2)) as tarjeta from acuenta a left join venta v on a.codVenta=v.idventa left join tienda t on v.idTienda=t.idtienda where v.fv=\''.$dia.'\' and  v.tipoComp=\'boleta\' group by t.tienda;');
    $data = $data->fetchAll();
    return $data;
}
function rptAM($mes,$año) {
    $gdb = getConnection();
    $data = $gdb->query('SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(v.fv, \'/\', 2), \'/\', -1) AS mes,SUBSTRING_INDEX(SUBSTRING_INDEX(v.fv, \'/\', 3), \'/\', -1) AS ano,t.tienda,CAST(SUM(v.total) AS DECIMAL(10,2)) AS total,CAST(SUM(v.saldo) AS DECIMAL(10,2)) AS saldo,CAST(SUM(v.total-v.saldo) AS DECIMAL(10,2)) AS acuenta FROM venta v left join tienda t on v.idTienda=t.idtienda WHERE v.estado<>\'anulado\' AND SUBSTRING_INDEX(SUBSTRING_INDEX(v.fv, \'/\', 3), \'/\', -1)=\'' . $año . '\' and SUBSTRING_INDEX(SUBSTRING_INDEX(v.fv, \'/\', 2), \'/\', -1)=\'' . $mes . '\' GROUP BY v.idTienda');
    $data = $data->fetchAll();
    return $data;
}
function rptTM($mes,$año, $idt) {
    $gdb = getConnection();
    $data = $gdb->query('SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(fv, \'/\', 1), \'/\', -1)  AS dia,SUBSTRING_INDEX(SUBSTRING_INDEX(fv, \'/\', 2), \'/\', -1)  AS mes,SUBSTRING_INDEX(SUBSTRING_INDEX(fv, \'/\', 3), \'/\', -1) AS ano,CAST(SUM(total) AS DECIMAL(10,2)) AS total,CAST(SUM(saldo) AS DECIMAL(10,2)) AS saldo,CAST(SUM(total-saldo) AS DECIMAL(10,2)) AS acuenta FROM venta WHERE estado<>\'anulado\' AND SUBSTRING_INDEX(SUBSTRING_INDEX(fv, \'/\', 3), \'/\', -1)=\'' . $año . '\' AND SUBSTRING_INDEX(SUBSTRING_INDEX(fv, \'/\', 2), \'/\', -1)=\'' . $mes . '\' and idTienda=\'' . $idt . '\' group by dia;');
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