<?php

require '../dal/monturasDAL.php';
session_start();
$action = $_POST['action'];

switch ($action) {
    case 'get':
        $cod = $_POST['codigo'];
        $fila = getMontura($cod);
        print (json_encode($fila));
        break;
    case 'getMonturasById':
        $cod = $_POST['codigo'];
        $fila = getMonturasById($cod);
        print (json_encode($fila));
        break;
    case 'getByIdMontura':
        $id = $_POST['id'];
        $fila = getByIdMontura($id);
        print(json_encode($fila));
        break;
    case 'getByIdMontura2':
        $id = $_POST['id'];
        $fila = getByIdMontura2($id);
        print(json_encode($fila));
        break;
    case 'getmonturadiftiend':
        $id = $_POST['codigo'];
        $fila = getmonturadiftiend($id);
        print(json_encode($fila));
        break;
    
    case 'getV':
        $cod = $_POST['codigo'];
        $fila = getMonturaV($cod, $_SESSION['tienda']);
        print (json_encode($fila));
        break;
    case 'getVDat':
        $cod = $_POST['codigo'];
        $fila = getMonturaVDat($cod, $_SESSION['tienda']);
        print (json_encode($fila));
        break;
    case 'getMonNV':
        $cod = $_POST['codigo'];
        $fila = getMonNV($cod);
        print (json_encode($fila));
        break;
    case 'getMonPM':
        $cod = $_POST['codigo'];
        $fila = getMonPM($cod);
        print (json_encode($fila));
        break;
    case 'getMonPMbyTienda':
        $cod = $_POST['codigo'];
        $idtienda = $_POST['idtienda'];
        $fila = getMonPMbyTienda($cod);
        print (json_encode($fila));
        break;
    case 'getMonPMbyTiendaLogin':
        $cod = $_POST['codigo'];
        $fila = getMonPMbyTiendaLogin($cod);
        print (json_encode($fila));
        break;
    case 'getMonInv':
        $cod = $_POST['codigo'];
        $tienda = $_POST['tienda'];
        $fila = getMonInv($cod, $tienda);
        print (json_encode($fila));
        break;
    case 'listxdias':
        $idtienda = $_POST['tienda'];
        $data = getListDias($idtienda);
        print (json_encode($data));
        break;
    case 'listxtienda':
        $cod = $_POST['tienda'];
        $lista = listMonturasxTienda($cod);
        print(json_encode($lista));
        break;
    case 'listMulti':
        $modelo = $_POST['modelo'];
        $lista = listMultiTienda($modelo);
        print(json_encode($lista));
        break;
    case 'insert':
        $producto = $_POST['producto'];
        $codigoBarra = $_POST['codigo'];
        $tipo = $_POST['tipo'];
        $clas = $_POST['clasificacion'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $detallemodelo = $_POST['detmodelo'];
        $color = $_POST['color'];
        $diseño = $_POST['diseno'];
        $genero = $_POST['genero'];
        $costo = $_POST['costo'];
        $pvm = $_POST['pxm'];
        $pxp = $_POST['pxp'];
        $pvp = $_POST['pvp'];
        $tope = $_POST['tope'];
        $calmacen = $_POST['cantAlmacen'];
        $exito = insertProductos($producto, $codigoBarra, $tipo, $clas, $marca, $modelo, $detallemodelo, $color, $diseño, $genero, $costo, $pvm, $pxp, $pvp, $tope, '0', $calmacen, '1', '2');
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'ModPrec':
        $precio = $_POST['precio'];
        $productos = json_decode($_POST['productos']);
        $exito = ModPrec($precio, $productos);
        print($exito);
        break;
    case 'upd':
        $id = $_POST['id'];
        $costo = $_POST['costo'];
        $tope = $_POST['tope'];
        $marca = $_POST['marca'];
        $precio = $_POST['precio'];
        $talla = $_POST['talla'];
        $puente = $_POST['puente'];
        $codigo = $_POST['codigo'];
        $procedencia = $_POST['procedencia'];
        $color = $_POST['color'];
        $modelo = $_POST['modelo'];
        $tipo = $_POST['tipo'];
        $estuche = $_POST['estuche'];
        $comentario = $_POST['comentario'];
        $tienda = $_POST['tienda'];
        
        $exito = update($id, $costo, $tope, $marca, $precio, $talla, $puente, $codigo, $procedencia, $color, $modelo, $tipo, $estuche, $comentario,$tienda);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
}
?>
