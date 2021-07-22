<?php

require '../dal/movimientoDAL.php';

$action = $_POST['action'];

switch ($action) {
    case 'getmov':
        $id = $_POST['id'];
        $fila = getmovimiento($id);
        print(json_encode($fila));
        break;
    case 'getmovp':
        $id = $_POST['id'];
        $fila = getmovimientop($id);
        print(json_encode($fila));
        break;
    case 'updR':
        session_start();
        $id = $_POST['id'];
        $rec = $_SESSION['userID'];
        $productos = json_decode($_POST['productos']);
        $fila = updrmovimiento($id, $productos, $rec);
        print($fila);
        break;
    case 'updRP':
        session_start();
        $id = $_POST['id'];
        $rec = $_SESSION['userID'];
        $productos = json_decode($_POST['productos']);
        $fila = updrmovimientop($id, $productos, $rec);
        print($fila);
        break;
    case 'listDetalle':
        $id = $_POST['id'];
        $fila = listDetalle($id);
        print(json_encode($fila));
        break;
    case 'listDetallep':
        $id = $_POST['id'];
        $fila = listDetalleProd($id);
        print(json_encode($fila));
        break;
    case 'list':
        $lista = listmovimiento();
        print(json_encode($lista));
        break;
    case 'listmovsinfactura':
        $lista = listmovsinfactura();
        print(json_encode($lista));
        break;
    case 'listp':
        $tienda = $_POST['tienda'];
        $lista = listmovimientoP($tienda);
        print(json_encode($lista));
        break;
    case 'listProd':
        $lista = listmovimientoProd();
        print(json_encode($lista));
        break;
    case 'listpProd':
        $tienda = $_POST['tienda'];
        $lista = listmovimientoPProd($tienda);
        print(json_encode($lista));
        break;
    case 'insert':
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $res = $_POST['tienda'];
        $rec = "";
        $estado = 'pendiente';
        $productos = json_decode($_POST['productos']);
        
        $ruc = $_POST['ruc'];
        $razonsocial = $_POST['razonsocial'];
        $documento = $_POST['documento'];
        $nrodocumento = $_POST['nrodocumento'];
        $fechafacturacion = $_POST['fechafacturacion'];
        
        $exito = insertmovimiento($fecha, $hora, $res, $rec, $estado, $productos, $ruc, $razonsocial, $documento, $nrodocumento, $fechafacturacion);
        print($exito);
        break;
    case 'updatedatosfacturacion':
        $ruc = $_POST['ruc'];
        $razonsocial = $_POST['razonsocial'];
        $documento = $_POST['documento'];
        $nrodocumento = $_POST['nrodocumento'];
        $fechafacturacion = $_POST['fechafacturacion'];
        $movimiento=$_POST['movimiento'];
        
        $exito = updatedatosfacturacion($ruc, $razonsocial, $documento, $nrodocumento, $fechafacturacion, $movimiento);
        print($exito);
        break;
    case 'insertp':
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $res = $_POST['res'];
        $rec = "";
        $estado = 'pendiente';
        $productos = json_decode($_POST['productos']);
        $exito = insertmovimientop($fecha, $hora, $res, $rec, $estado, $productos);
        print($exito);
        break;
    case 'del':
        $id = $_POST['id'];
        $exito = delmovimiento($id);
        print($exito);
        break;
    case 'delp':
        $id = $_POST['id'];
        $exito = delmovimientop($id);
        print($exito);
        break;
}
?>
