<?php

require '../dal/medicionDAL.php';

$action = $_POST['action'];
//Busca todas las variables que ya no van, [LISTO]
switch ($action) {
    case 'insert':
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $comentario = $_POST['comentario'];
        $fv = $_POST['fv'];
        $hv = $_POST['hv'];
        $tipo = $_POST['tipo'];
        $material = $_POST['material'];
        $subtipo = $_POST['subtipo'];
        $ptrat = $_POST['ptrat'];
        $strat = $_POST['strat'];
        $tipoVision = $_POST['tipoVision'];
        $esfi = $_POST['esfi'];
        $cili = $_POST['cili'];
        $ejei = $_POST['ejei'];
        $avi = $_POST['avi'];
        $pioi = $_POST['pioi'];
        $dip = $_POST['dip'];
        $esfd = $_POST['esfd'];
        $cild = $_POST['cild'];
        $ejed = $_POST['ejed'];
        $avd = $_POST['avd'];
        $piod = $_POST['piod'];
        $addd = $_POST['addd'];
        $id_at = $_POST['id_at'];
        cambiarAtencion($id_at);
        //Cambio solo aquí
        $telefono=getTelefono($id_at);
        $exito = insert($nombre, $apellido, $comentario, $fv, $hv, $tipo, $material, $subtipo, $ptrat, $strat, $tipoVision, $esfi, $cili, $ejei, $avi, $pioi, $dip, $esfd, $cild, $ejed, $avd, $piod, $addd, $id_at, $telefono[0]);
        //
        if ($exito) {
            echo json_encode($exito);
        } else {
            print('NO');
        }
        break;
    case 'chaupac':
        $id_at= $_POST['id'];
        cambiarAtencion($id_at);
        break;
    case 'upd':
        $id= $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $comentario = $_POST['comentario'];
        $fv = $_POST['fv'];
        $hv = $_POST['hv'];
        $tipo = $_POST['tipo'];
        $material = $_POST['material'];
        $subtipo = $_POST['subtipo'];
        $ptrat = $_POST['ptrat'];
        $strat = $_POST['strat'];
        $tipoVision = $_POST['tipoVision'];
        $esfi = $_POST['esfi'];
        $cili = $_POST['cili'];
        $ejei = $_POST['ejei'];
        $avi = $_POST['avi'];
        $pioi = $_POST['pioi'];
        $dip = $_POST['dip'];
        $esfd = $_POST['esfd'];
        $cild = $_POST['cild'];
        $ejed = $_POST['ejed'];
        $avd = $_POST['avd'];
        $piod = $_POST['piod'];
        $addd = $_POST['addd'];
        $exito = upd($id,$nombre, $apellido, $comentario, $fv, $hv, $tipo, $material, $subtipo, $ptrat, $strat, $tipoVision, $esfi, $cili, $ejei, $avi, $pioi, $dip, $esfd, $cild, $ejed, $avd, $piod, $addd);
        if ($exito) {
            echo json_encode($exito);
        } else {
            print('NO');
        }
        break;
    case 'list':
        $fila = lisMedicion();
        print(json_encode($fila));
        break;
    case 'listxVenta':
        $fec = $_POST['fec'];
        $fila = lisMedicionVenta($fec);
        print(json_encode($fila));
        break;
    case 'cerrarmedida':
        $id= $_POST['id'];
        $exito = cerrarmedida($id);
        if($exito){
            print('OK');
        }else{
            print('TMR');
        }
        break;
    case 'findxVenta':
        $path = $_POST['path'];
        $fila = findMedicionVenta($path);
        print(json_encode($fila));
        break;
    case 'find':
        $path = $_POST['path'];
        $fila = findMedicion($path);
        print(json_encode($fila));
        break;
    case 'listByFecha':
        $fecha = $_POST['fecha'];
        $fila = listByFecha($fecha);
        print(json_encode($fila));
        break;
    case 'detalle':
        $id = $_POST['id'];
        $fila = listDetalle($id);
        print(json_encode($fila));
        break;
    case 'getMedida':
        $id = $_POST['id'];
        $fila = getMedicion($id);
        print(json_encode($fila));
        break;
}
?>
