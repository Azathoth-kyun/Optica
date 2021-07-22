<?php

require '../dal/tiendasDAL.php';
require '../dal/idsuscriptorDAL.php';

$action = $_POST['action'];
$algo=$action;

switch ($action) {

    case 'listarTiendasSelect':
        $lista = listarTiendasSelect();
        print(json_encode($lista));
        break;
    case 'listarTiendasSelectNoLogin':
        $lista = listarTiendasSelectNoLogin();
        print(json_encode($lista));
        break;
    case 'list':
        $lista = listTiendas();
        print(json_encode($lista));
        break;
    case 'get':
        $id = $_POST['id'];
        $fila = getTiendas($id);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'getnametienda':
        $tienda=$_SESSION['nametienda'];
        $data = array('name' => $tienda);
        print(json_encode($data));
        break;
    case 'listarmarcasSelect':
        $lista = listarMarcas();
        print(json_encode($lista));
        break;
    case 'getTrabajadores':
        $lista = listarEmpleados();
        print(json_encode($lista));
        break;
    case 'QuerywithoutMonth':
        $marca = $_POST['marquita'];
        $anio = $_POST['anio'];
        $lista = listarlosIDS($marca,$anio);
        $lista2 = listarlasDESC($marca,$anio);
        $data = [];
        for ($i=0; $i< count($lista);$i++){
            $data[$i][0] = $lista[$i][0];
            $data[$i][1] = $lista2[$i][0];
            $data[$i][2] = $lista[$i][1];
        }
        print(json_encode($data));
        break;
    case 'QuerywithMonth':
        $marca = $_POST['marquita'];
        $anio = $_POST['anio'];
        $mes = $_POST['mes'];
        $lista = listarlosIDSM($marca,$anio,$mes);
        $lista2 = listarlasDESCM($marca,$anio,$mes);
        $data = [];
        for ($i=0; $i< count($lista);$i++){
            $data[$i][0] = $lista[$i][0];
            $data[$i][1] = $lista2[$i][0];
            $data[$i][2] = $lista[$i][1];
        }
        print(json_encode($data));
        break;
    case 'pagarComision':
        $cod_ventas = $_POST['cod_ventas'];
        $exito = pagarComision($cod_ventas);
        if($exito != null){
            print('OK');
        }else{
            print('TO BE CONTINUED');
        }
        break;
    case 'queryConsult':
        $mes = $_POST['mes'];
        $vendedor = $_POST['vendedor'];
        $dato1 = comisionganada($mes,$vendedor);
        $dato2 = checked($mes,$vendedor);
        $data = [];
        for ($i=0; $i< count($dato1);$i++){
            $data[$i][0] = $dato1[$i][0];
            $data[$i][1] = $dato1[$i][1];
            $data[$i][2] = $dato1[$i][2];
            $data[$i][3] = $dato2[$i][0];
        }
        print(json_encode($data));
        break;
    case 'queryConsultLunas':
            $mes = $_POST['mes'];
            $vendedor = $_POST['vendedor'];
            $dato1 = comisionganadaLunas($mes,$vendedor);
            $dato2 = checkedLunas($mes,$vendedor);
            $data = [];
            for ($i=0; $i< count($dato1);$i++){
                $data[$i][0] = $dato1[$i][0];
                $data[$i][1] = $dato1[$i][1];
                $data[$i][2] = $dato2[$i][0];
            }
            print(json_encode($data));
            break;
    case 'upd':
        $id = $_POST['id'];
        $nomb = $_POST['nomb'];
        $desc = $_POST['desc'];
        $exito = updateTiendas($id, $nomb, $desc);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'WorkersYear':
        $vendedor = $_POST['marquita'];
        $anio = $_POST['anio'];
        $lista = vendedoresanio($vendedor,$anio);
        print(json_encode($lista));
        break;
    case 'WorkersMonth':
        $vendedor = $_POST['marquita'];
        $anio = $_POST['anio'];
        $mes = $_POST['mes'];
        $lista = vendedoresmes($vendedor,$anio,$mes);
        print(json_encode($lista));
        break;
    case 'insert':
        $nomb = $_POST['nomb'];
        $desc = $_POST['desc'];
        $plan = $_POST['plan'];
        $idsuscriptor = getIdSuscriptor();
        
        $exito = insertTienda($nomb, $desc);
        if ($exito) {
            $idtienda = getIdTienda();
            updateIdSuscripcion($idsuscriptor.$idtienda, $idtienda);
            $exito = insertSuscripcionTienda($idsuscriptor.$idtienda, $idtienda, $idsuscriptor, $plan);
            if ($exito) {
                print('OK');
            }else{
                print('NO');
            }
        } else {
            print('NO');
        }
        break;
    case 'ins':
        $nomb = $_POST['nomb'];
        $desc = $_POST['desc'];
        $exito = insertTiendas($nomb, $desc);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'getTiendaByUsuario':
        $fila = getTiendasByUsuario();
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'enviarvoucher':
        $idsuscripcion = $_POST['idsuscripcion'];
        
        $ruta="../img/voucher";
        $rutadb="img/voucher";
        $imagen = "";
        
        $nom = 'voucher'.$idsuscripcion;
        $archivo=$_FILES['files']['tmp_name'];
        $nom_archivo=$_FILES['files']['name'];
        $ext=  pathinfo($nom_archivo);
        $nuevo = $ruta."/".$nom.".".$ext['extension'];
        $nuevodb = $rutadb."/".$nom.".".$ext['extension'];
        $subir = move_uploaded_file($archivo, $nuevo);
        
        $rutaimagen="";
        $respuesta="";
        if($subir){
            $rutaimagen = 'http://104.131.191.252/'.DB_NAME.'/'.$nuevodb;
            $exito = insertVoucherSuscripcion($rutaimagen, $idsuscripcion);
            if($exito){
                $respuesta = "inserto";
            }else{
                $respuesta = "error";
            }
        }else{
            $respuesta = 'nosubir';
        }
        
        $ret = array(
                'ret' => $respuesta,
            );
        echo json_encode($ret);
        break;
}
?>

