<?php

require '../dal/proveedorDAL.php';

$action = $_POST['action'];

switch ($action) {
    case 'list':
        $lista = listProveedor();
        print(json_encode($lista));
        break;
    case 'get':
        $id = $_POST['id'];
        $fila = getProveedor($id);
        if ($fila != "") {
            print(json_encode($fila));
        } else {

            print "no";
        }
        break;
    case 'insert':
        $ruc = $_POST['ruc'];
        $razonsocial = $_POST['Rsocial'];
        $proveedor = $_POST['proveedor'];
        $telefono = $_POST['telefono'];
        $celular = $_POST['celular'];
        $direccion = $_POST['direccion'];
        $comentario=$_POST['comentario'];
        $estado='1';
        $exito = insertProveedor($proveedor, $razonsocial, $ruc, $direccion, $telefono, $celular,$comentario,$estado);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'update':
        $id = $_POST['id'];
        $ruc = $_POST['ruc'];
        $razonsocial = $_POST['Rsocial'];
        $proveedor = $_POST['proveedor'];
        $telefono = $_POST['telefono'];
        $celular = $_POST['celular'];
        $direccion = $_POST['direccion'];
        $comentario=$_POST['comentario'];
        $estado='1';
        $exito = updateProveedor($id, $proveedor, $razonsocial, $ruc, $direccion, $telefono, $celular,$comentario);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'del':
        $id = $_POST['id'];
        $exito = deleteProveedor($id);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
}
?>
