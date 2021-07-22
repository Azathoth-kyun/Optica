<?php

require '../dal/concecionesDAL.php';

$action = $_POST['action'];

switch ($action) {
    case 'get':
        $id = $_POST['id'];
        $fila = getconceciones($id);
        print(json_encode($fila));
        break;
    case 'listDetalle':
        $id = $_POST['id'];
        $fila = listDetalle($id);
        print(json_encode($fila));
        break;
    
    case 'list':
        $lista = listconceciones();
        print(json_encode($lista));
        break;
    case 'insert':
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $res = $_POST['clie'];
        $rec = $_POST['acuenta'];
        $estado = 'pendiente';
        $productos = json_decode($_POST['productos']);
        $exito = insertconceciones($fecha, $hora, $res, $rec, $estado, $productos);
        print($exito);
        break;
    case 'del':
        $id = $_POST['id'];
        $exito = delconceciones($id);
        print($exito);
        break;
}
?>
