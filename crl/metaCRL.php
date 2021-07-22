<?php
require '../dal/metaDAL.php';
$action = $_POST['action'];
switch ($action) {
    case 'listMetasByTiendaByAnio':
        $idtienda = $_POST['idtienda'];
        $anio = $_POST['anio'];
        $lista = listMetasByTiendaByAnio($idtienda, $anio);
        print(json_encode($lista));
        break;
    case 'insertMetaTiendaAnio':
        $anio = $_POST['anio'];
        $idtienda = $_POST['idtienda'];
        $metas = json_decode($_POST['metas']);
        $meta = $_POST['meta'];
        
        $resultado = listMetasByTiendaByAnio($idtienda, $anio);
        $exito;
        if(count($resultado)>0){
            $exito = updateMetaTiendaAnio($idtienda, $anio, $metas, $meta);
        }else{
            $exito = insertMetaTiendaAnio($idtienda, $anio, $metas, $meta);
        }
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'getMetaByMesByAnioByTienda':
        $idtienda = $_POST['idtienda'];
        $anio = $_POST['anio'];
        $mes = $_POST['mes'];
        $lista = getMetaByMesByAnioByTienda($idtienda, $anio, $mes);
        print $lista;
        break;
    case 'TotalIngresosByFecha':
        $idtienda = $_POST['tienda'];
        $anio = $_POST['anio'];
        $mes = $_POST['mes'];
        $lista = TotalIngresosByFecha($idtienda, $anio, $mes);
        print(json_encode($lista));
        break;
}
?>