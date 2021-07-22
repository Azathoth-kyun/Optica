<?php

require '../dal/parametrosDAL.php';

$action = $_POST['action'];

switch ($action) {

    case 'list':
        $lista = listParametros();
        print(json_encode($lista));
        break;
    case 'get':
        $id = $_POST['id'];
        $fila = getParametros($id);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'upd':
        $id = $_POST['id'];
        $nomb = $_POST['nomb'];
        $desc = $_POST['desc'];
        $exito = updateParametros($id, $nomb, $desc);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
}
?>

