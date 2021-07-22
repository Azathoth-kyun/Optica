<?php

require '../dal/planesDAL.php';

$action = $_POST['action'];

switch ($action) {
    case 'list':
        $lista = listPlanes();
        print(json_encode($lista));
        break;
}
