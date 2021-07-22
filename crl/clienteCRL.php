<?php

require '../dal/clienteDAL.php';

$action = $_POST['action'];

switch ($action) {
    case 'get':
        $id = $_POST['id'];
        $fila = getCliente($id);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'find':
        $doc = $_POST['doc'];
        $fila = findCliente($doc);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'list':
        $lista = listCliente();
        print(json_encode($lista));
        break;
    case 'insert':
        $doc = $_POST['doc'];
        $nom = $_POST['clie'];
        $exito = insertCliente($doc, $nom);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'update':
        $id = $_POST['id'];
        $doc = $_POST['doc'];
        $nom = $_POST['clie'];
        $exito = updateCliente($id, $doc, $nom);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'del':
        $id = $_POST['id'];
        $exito = deleteCliente($id);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
}
?>
