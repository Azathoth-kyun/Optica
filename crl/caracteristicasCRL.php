<?php

require '../dal/caracteristicasDAL.php';

$action = $_POST['action'];

switch ($action) {

    case 'get':
        $id = $_POST['id'];
        $fila = getCracteristica($id);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'find':
        $car = $_POST['car'];
        $fila = findCracteristica($car);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'listTipo':
        $tipo = $_POST['TipoCaracteristicas'];
        $lista = listCaracteristicasTipo($tipo);
        print(json_encode($lista));
        break;
    case 'list':
        $lista = listCaracteristicas();
        print(json_encode($lista));
        break;
    case 'insert':
        $car = $_POST['Caracteristicas'];
        $tipo = $_POST['TipoCaracteristicas'];
        $exito = insertCaracteristica($car, $tipo);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'update':
        $id = $_POST['id'];
        $car = $_POST['Caracteristicas'];
        $tipo = $_POST['TipoCaracteristicas'];
        $exito = updateCaracteristica($id, $car, $tipo);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'del':
        $id = $_POST['id'];
        $exito = deleteCaracteristica($id);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
}
?>
