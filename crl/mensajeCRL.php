<?php
require '../dal/mensajeDAL.php';
$action = $_POST['action'];
switch ($action) {
    case 'listMensajesByTienda':
        $idtienda = $_POST['idtienda'];
        $lista = listMensajesByTienda($idtienda);
        print(json_encode($lista));
        break;
    case 'insertMensajeTienda':
        $asunto = $_POST['asunto'];
        $mensaje = $_POST['mensaje'];
        $idtienda = $_POST['idtienda'];
        
        $exito = insertMensajeTienda($idtienda, $asunto, $mensaje);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'updateMensajesLeido':
        $idtienda = $_POST['tienda'];
        
        $exito = updateMensajesLeido($idtienda);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
}
?>