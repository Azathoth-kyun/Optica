<?php

require '../dal/ingresoDAL.php';

$action = $_POST['action'];

switch ($action) {
    case 'getingresop':
        $id = $_POST['id'];
        $fila = getingresop($id);
        print(json_encode($fila));
        break;
    case 'listDetallep':
        $id = $_POST['id'];
        $fila = listDetallep($id);
        print(json_encode($fila));
        break;
    case 'list':
        $lista = listingreso();
        print(json_encode($lista));
        break;
    case 'insert':
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $id = $_POST['id'];
        $doc = $_POST['doc'];
        $numDoc = $_POST['numDoc'];
        $inicio= $_POST['inicio'];
        $productos = json_decode($_POST['productos']);
        $exito = insertingreso($fecha, $hora, $id, $doc, $numDoc,$productos,$inicio);
        print($exito);
        break;
    case 'insertp':
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $id = $_POST['id'];
        $doc = $_POST['doc'];
        $numDoc = $_POST['numDoc'];
        $productos = json_decode($_POST['productos']);
        $exito = insertingresop($fecha, $hora, $id, $doc, $numDoc,$productos);
        print($exito);
        break;
}
?>
