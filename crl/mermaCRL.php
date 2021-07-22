<?php

require '../dal/mermaDAL.php';

$action = $_POST['action'];

switch ($action) {

    case 'get':
        $id = $_POST['idMerma'];
        $fila = getMerma($id);
        print(json_encode($fila));
        break;
    case 'list':
        $lista = listMerma();
        print(json_encode($lista));
        break;
    case 'insert':
        $id = $_POST['idP'];
        $can = $_POST['cant'];
        $exito = insertMerma($id, $can);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'update':
        $id = $_POST['id'];
        $idp = $_POST['idP'];
        $can = $_POST['can'];
        $exito = updateMerma($id, $idp, $can);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
}
?>