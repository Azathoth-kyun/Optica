<?php
require 'conexion.php';
session_start();

function insertMetaTiendaAnio($idtienda, $anio, $metas, $meta) {
    $gdb = getConnection();
    $exito;
    
    for ($i = 0; $i < count($metas); $i++) {
        if($metas[$i][1]==1){
            $sent = $gdb->prepare('INSERT INTO meta(idtienda, anio, mes, meta)'
                . 'VALUES(:idtienda,:anio,:mes,:meta)');
            $exito = $sent->execute(array(':idtienda' => $idtienda, ':anio' => $anio, 
                    ':mes' => $metas[$i][0], ':meta' => $meta));
        }else{
            $sent = $gdb->prepare('INSERT INTO meta(idtienda, anio, mes, meta)'
                    . 'VALUES(:idtienda,:anio,:mes,:meta)');
            $exito = $sent->execute(array(':idtienda' => $idtienda, ':anio' => $anio, 
                    ':mes' => $metas[$i][0], ':meta' => 0));
        }
    }
    
    return $exito;
}

function listMetasByTiendaByAnio($idtienda, $anio) {
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT idmeta, idtienda, mes, meta, avance 
    FROM meta 
    WHERE idtienda=:idtienda and anio=:anio  ORDER BY mes;');
    $data->execute(array(':idtienda' => $idtienda, ':anio' => $anio));
    $data = $data->fetchAll();
    return $data;
}

function TotalIngresosByFecha($idtienda, $anio, $mes) {
    $gdb = getConnection();
    $data = $gdb->query('SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(v.fv, \'/\', 2), \'/\', -1) AS mes,SUBSTRING_INDEX(SUBSTRING_INDEX(v.fv, \'/\', 3), \'/\', -1) AS ano,t.tienda,CAST(SUM(v.total) AS DECIMAL(10,2)) AS total,CAST(SUM(v.saldo) AS DECIMAL(10,2)) AS saldo,CAST(SUM(v.total-v.saldo) AS DECIMAL(10,2)) AS acuenta FROM venta v left join tienda t on v.idTienda=t.idtienda WHERE v.estado<>\'anulado\' AND SUBSTRING_INDEX(SUBSTRING_INDEX(v.fv, \'/\', 3), \'/\', -1)=\'' . $anio . '\' and SUBSTRING_INDEX(SUBSTRING_INDEX(v.fv, \'/\', 2), \'/\', -1)=\'' . $mes . '\' and v.idtienda='.$idtienda.' GROUP BY v.idTienda');
    $data = $data->fetchAll();
    return $data;
}

function updateMetaTiendaAnio($idtienda, $anio, $metas, $meta) {
    $gdb = getConnection();
    $exito;
    
    for ($i = 0; $i < count($metas); $i++) {
        if($metas[$i][1]==1){
            $sent = $gdb->prepare('update meta set meta=:meta where idtienda=:idtienda and anio=:anio and mes=:mes;');
            $exito = $sent->execute(array(':meta' => $meta, ':idtienda' => $idtienda, ':anio' => $anio, ':mes' => $metas[$i][0]));
        }
    }
    
    return $exito;
}

function getMetaByMesByAnioByTienda($idtienda, $anio, $mes){
    $gdb = getConnection();
    $data = $gdb->prepare('SELECT meta 
    FROM meta 
    WHERE idtienda=:idtienda and anio=:anio and mes=:mes ORDER BY mes;');
    $data->execute(array(':idtienda' => $idtienda, ':anio' => $anio, ':mes' => $mes));
    $data = $data->fetchAll();
    if (count($data) > 0) {
        return $data[0][0];
    }else{
        return 0;
    }
}
