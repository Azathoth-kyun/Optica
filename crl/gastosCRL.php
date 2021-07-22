<?php
require '../dal/gastosDAL.php';
$action = $_POST['action'];
switch ($action) {
    case 'listaGastos':
        $fila = listaGastosVariables();
        print (json_encode($fila));
        break;
    case 'listTipoGasto':
        $lista = listTipoGasto();
        print(json_encode($lista));
        break;
    case 'listCategoriaGasto':
        $lista = listCategoriaGasto();
        print(json_encode($lista));
        break;
    case 'listCategoriaGastoActiva':
        $lista = listCategoriaGastoActiva();
        print(json_encode($lista));
        break;
    case 'listCategoriaGastoActivaSoloadmin':
        $lista = listCategoriaGastoActivaSoloadmin();
        print(json_encode($lista));
        break;
    case 'getcategoriagasto':
        $id = $_POST['id'];
        $fila = getcategoriagasto($id);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'insertCategoriaGasto':
        $categoria = $_POST['categoria'];
        $idtipo = $_POST['tipo'];
        $estado = $_POST['estado'];
        
        $soloadmin = isset($_POST['cbtest']) ? $_POST['cbtest'] : '';
        if($soloadmin=='on'){
            $soloadmin=1;
        }else{
            $soloadmin=0;
        }
        
        $exito = insertCategoriaGasto($categoria, $idtipo, $estado, $soloadmin);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'updateCategoriaGasto':
        $idcategoria = $_POST['id'];
        $categoria = $_POST['categoria'];
        $idtipo = $_POST['tipo'];
        $estado = $_POST['estado'];
        
        $soloadmin = isset($_POST['cbtest']) ? $_POST['cbtest'] : '';
        if($soloadmin=='on'){
            $soloadmin=1;
        }else{
            $soloadmin=0;
        }
        
        $exito = updateCategoriaGasto($idcategoria, $categoria, $idtipo, $estado, $soloadmin);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'listDetalleGastos':
        $idtienda = $_SESSION['tienda'];
        $lista = listDetalleGastos($idtienda);
        print(json_encode($lista));
        break;
    case 'listDetalleGastosByTiendaAdmin':
        $idtienda = $_POST['idtienda'];
        $lista = listDetalleGastosByTiendaAdmin($idtienda);
        print(json_encode($lista));
        break;
    case 'getDetalleGasto':
        $id = $_POST['id'];
        $fila = getDetalleGasto($id);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'insertDetalleGasto':
        $idcategoria = $_POST['categoria'];
        $monto = $_POST['monto'];
        $descripcion = $_POST['descripcion'];
        $observacion = $_POST['observacion'];
        $idtienda = $_POST['idtienda'];
        $tipouserpago = $_POST['tipouserpago'];
        
        $exito = insertDetalleGasto($idcategoria, $monto, $descripcion, $observacion, $idtienda, $tipouserpago);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'updateDetalleGasto':
        $idgasto = $_POST['id'];
        $idcategoria = $_POST['categoria'];
        $monto = $_POST['monto'];
        $descripcion = $_POST['descripcion'];
        $observacion = $_POST['observacion'];
        
        $exito = updateDetalleGasto($idgasto, $idcategoria, $monto, $descripcion, $observacion);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'listDetalleGastosByParametros':
        $tienda = $_POST['tienda'];
        $periodo = $_POST['periodo'];
        
        $lista;
        
        if($periodo=="DD"){
            $fec = $_POST['fec'];
            $lista = listDetalleGastosByFecha($tienda, $fec);
        }else if($periodo=="MM"){
            $anio = $_POST['anio'];
            $mes = $_POST['mes'];
            $lista = listDetalleGastosByMes($tienda, $anio, $mes);
        }else if($periodo=="YY"){
            $anio = $_POST['anio'];
            $lista = listDetalleGastosByAnio($tienda, $anio);
        }
        
        print(json_encode($lista));
        break;
}
?>