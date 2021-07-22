<?php

require '../dal/productosDAL.php';
session_start();
$action = $_POST['action'];

switch ($action) {
    case 'getByIdProducto1':
        $id = $_POST['id'];
        $data = getByIdProducto1($id);
        print(json_encode($data));
        break;
    case 'find':
        $string = $_POST['parametros'];
        $parametros = explode(" ", $string);
        $fila = findProducto($parametros);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'postearComision':
        $id= $_POST['id'];
        $comision= $_POST['comision'];
        $exito= postearComision($id,$comision);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'getProductoCod':
        $cod = $_POST['cod'];
        $fila = getProductoCodigo($cod);
        print (json_encode($fila));
        break;
    case 'getProductoCodV':
        $cod = $_POST['cod'];
        $fila = getProductoCodigoV($cod, $_SESSION['tienda']);
        print (json_encode($fila));
        break;
    case 'getxCodTiend':
        $cod = $_POST['cod'];
        $tiend = $_POST['tiend'];
        $fila = getxCodTiend($cod,$tiend);
        print (json_encode($fila));
        break;
    case 'getusuario':
        $idUsuario = $_POST['id'];
        $fila = getUsuario($idUsuario);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'getproductoxp':
        $prod = $_POST['prod'];
        $fila = getProductoXP($prod);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
    case 'get':
        $id = $_POST['id'];
        $fila = getProducto($id);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'list':
        $lista = listProductos();
        print(json_encode($lista));
        break;
    case 'listProductosConStockByTienda':
        $lista = listProductosConStockByTienda();
        print(json_encode($lista));
        break;
    case 'listSM':
        $tipo = $_POST['tipo'];
        $lista = listSM($tipo);
        print(json_encode($lista));
        break;
    case 'listXcategoria':
        $cat = $_POST['cat'];
        $tipo = $_POST['tipo'];
        $lista = listProductosXtipo($cat, $tipo);
        print(json_encode($lista));
        break;
    case 'listXtienda':
        $tienda = $_POST['tienda'];
        $lista = listProductosXtienda($tienda);
        print(json_encode($lista));
        break;
    case 'listXAlmacen':
        $lista = listProductosXAlmacen();
        print(json_encode($lista));
        break;
    case 'insert':
        $cod = $_POST['cod'];
        $desc = $_POST['desc'];
        $costo = $_POST['costo'];
        $venta = $_POST['venta'];
        $tope = $_POST['tope'];
        $inicio = $_POST['inicio'];
        $exito = insertProductos($cod, $desc, $costo, $venta, $tope, '0', '0', $inicio);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'update':
        $id = $_POST['idp'];
        $cod = $_POST['cod'];
        $desc = $_POST['desc'];
        $costo = $_POST['costo'];
        $venta = $_POST['venta'];
        $tope = $_POST['tope'];
        $exito = updateProductos($id, $cod, $desc, $costo, $venta, $tope);
        //$exito = insertProductos($producto, $codigoBarra, $tipo, $clas, $marca, $modelo, $detallemodelo, $color, $diseño, $genero, $costo, $pvm, $pxp, $pvp, $tope, '0', $calmacen, '1');
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'updateSM':
        $id = $_POST['id'];
        $tx = $_POST['tx'];
        $tiend = $_POST['tiend'];
        $exito = updateSM($id, $tx, $tiend);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
}
?>
