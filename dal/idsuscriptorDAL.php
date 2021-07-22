<?php

function getIdSuscriptor() {
    $gdb = getConnection();
    $data = $gdb->query('select idsuscriptor FROM idsuscriptor;');
    $filas = $data->fetchAll();
    if (count($filas) > 0) {
        return $filas[0][0];
    } else {
        return;
    }
}