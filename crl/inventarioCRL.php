<?php

require '../dal/inventarioDAL.php';

$action = $_POST['action'];

switch ($action) {
    case 'registroHistInventario':
        $totalf = $_POST['totalf'];
        $totalv = $_POST['totalv'];
        $total = $_POST['total'];
        $idtienda = $_POST['idtienda'];
        $faltantes = json_decode($_POST['faltantes']);
        $exito = registroInventario($totalf, $totalv, $total, $idtienda);
        if ($exito) {
            $idhistorial = getUltimoIdHistorialInv();
            $exito = registroHistInventario($faltantes, $idhistorial);
            if ($exito) {
                print('OK');
            } else {
                print('NO');
            }
        } else {
            print('NO');
        }
        break;
    case 'listarHistorialInventario':
        $idtienda = $_POST['idtienda'];
        $lista = listarHistorialInventario($idtienda);
        print(json_encode($lista));
        break;
    case 'listarDetalleInventario':
        $idhistorial = $_POST['idhistorial'];
        $lista = listarDetalleInventario($idhistorial);
        print(json_encode($lista));
        break;
    case 'listarFaltantesByMarca':
        $idhistorial = $_POST['idhistorial'];
        $lista = listarFaltantesByMarca($idhistorial);
        print(json_encode($lista));
        break;
}