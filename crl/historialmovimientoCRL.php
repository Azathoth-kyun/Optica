<?php

require '../dal/historialmovimientoDAL.php';
session_start();
$action = $_POST['action'];

switch ($action) {
    case 'registroMovimientoMontura':
        $idtorigen = $_POST['idtorigen'];
        $idtdestino = $_POST['idtdestino'];
        $comentario = $_POST['comentario'];
        $productos = json_decode($_POST['productos']);
        $exito = registroMovimientoMontura($productos, $idtorigen, $idtdestino, $comentario);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'listHistorialByIdMontura':
        $idmonnturas=$_POST['idmonturas'];
        $lista = listHistorialByIdMontura($idmonnturas);
        print(json_encode($lista));
        break;
    case 'registroMovimientoMonturaTienda':
        $idtdestino = $_POST['idtdestino'];
        $comentario = $_POST['comentario'];
        $productos = json_decode($_POST['productos']);
        $exito = registroMovimientoMonturaTienda($productos, $idtdestino, $comentario);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
}