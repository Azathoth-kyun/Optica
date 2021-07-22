<?php

require 'conexion.php';

function listPlanes() {
    $gdb = getConnectionAdmin();
    $data = $gdb->query('SELECT idplan, plan, periodo, precio, preciomes FROM planes');
    $data = $data->fetchAll();
    return $data;
}