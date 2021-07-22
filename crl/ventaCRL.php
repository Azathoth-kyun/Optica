<?php

require '../dal/ventaDAL.php';

$action = $_POST['action'];

switch ($action) {
    case 'get':
        $id = $_POST['id'];
        $fila = getVenta($id);
        print(json_encode($fila));
        break;
    case 'getByIdVenta':
        $id = $_POST['id'];
        $fila = getByIdVenta($id);
        print(json_encode($fila));
        break;
    case 'tipoB':
        $tipo = $_POST['tipoB'];
        $id = $_POST['id'];
        $fila = tipoB($id,$tipo);
        print($fila);
        break;
    case 'getSN':
        $id = $_POST['id'];
        $idt = $_POST['idt'];
        $fila = getVentaSN($id,$idt);
        print(json_encode($fila));
        break;
    case 'listDetalle':
        $id = $_POST['id'];
        $fila = listDetalle($id);
        print(json_encode($fila));
        break;
    case 'enviarclienteopto':
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $atendido_optometra = $_POST['atendido_optometra'];
        $atendido_vendedor = $_POST['atendido_vendedor'];
        $tienda = $_POST['prod'];
        $datoa = enviarOpto($nombre,$apellido,$telefono,$atendido_optometra,$atendido_vendedor,$tienda);
        if ($datoa) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'list':
        $lista = listVenta();
        print(json_encode($lista));
        break;
    case 'listDia':
        $fec = $_POST['fec'];
        $tienda = $_POST['tienda'];
        $tipo = $_POST['tipo'];
        $criterio = $_POST['criterio'];
        if($tipo=='todos'){
            $lista = getDia($fec,$tienda);
        }  elseif ($tipo=='pendientes') {
            $lista = getDiaPen($fec,$tienda);
        }  elseif ($tipo=='paciente') {
            $lista = getDiaPac($fec,$tienda,$criterio);
        }
        
        print(json_encode($lista));
        break;
    case 'listcaja':
        $lista = listVentaCaja();
        print(json_encode($lista));
        break;
    case 'listC':
        $lista = listCliente();
        print(json_encode($lista));
        break;
        
    case 'anular':
        $id = $_POST['id'];
        $exito = anularVenta($id);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'cobrar':
        $id = $_POST['id'];
        $tipot = $_POST['tipot'];
        $tar = $_POST['tar'];
        $efec = $_POST['efec'];
        $exito = cobrar($id, $tipot, $tar, $efec);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'SaveGastos':
        $id = $_POST['id'];
        $lab = $_POST['lab'];
        $tec = $_POST['tec'];
        $cl = $_POST['cl'];
        $cp = $_POST['cp'];
        $exito = saveG($id, $lab, $tec, $cl, $cp);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'SaveGastosGOP':
        $idventa = $_POST['id'];
        $codventa = $_POST['codventa'];
        $lab = $_POST['lab'];
        $tec = $_POST['tec'];
        $cl = $_POST['cl'];
        $cp = $_POST['cp'];
        $idtienda = $_POST['idtienda'];
        
        if($idtienda==0){
            $idtienda=getIdtiendaByIdVenta($idventa);
        }
        
        $exito = saveG($idventa, $lab, $tec, $cl, $cp);
        $exito = saveGOP($codventa, $lab, $tec, $cl, $cp, $idtienda);
        if ($exito) {
            $idgasto=getUltimoGasto();
            $exito = saveIdGastoEnVenta($idgasto, $idventa);
            if ($exito) {
                print('OK');
            } else {
                print('NO');
            }
        } else {
            print('NO');
        }
        break;
    case 'UpdGastosGOP':
        $idgasto = $_POST['idgasto'];
        $idventa = $_POST['id'];
        $lab = $_POST['lab'];
        $tec = $_POST['tec'];
        $cl = $_POST['cl'];
        $cp = $_POST['cp'];
        $idtienda = $_POST['idtienda'];
        
        if($idtienda==0){
            $idtienda=getIdtiendaByIdVenta($idventa);
        }
        
        $exito = saveG($idventa, $lab, $tec, $cl, $cp);
        $exito = updGOP($idventa, $lab, $tec, $cl, $cp, $idtienda, $idgasto);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'inserta':
        $id = $_POST['id'];
        $fv = $_POST['fv'];
        $hv = $_POST['hv'];
        $saldo = $_POST['saldo'];
        $efectivo = $_POST['efectivo'];
        $tarjeta = $_POST['tarjeta'];
        $tipot = $_POST['tipot'];
        $exito = cobrar($id, $fv, $hv, $saldo, $efectivo, $tarjeta, $tipot);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'isPagoConTarjeta':
        $idventa = $_POST['idventa'];
        $exito = isPagoConTarjeta($idventa);
        if ($exito>0) {
            print('des');
        } else {
            print('NO');
        }
        break;
    case 'updateacuenta':
        $fv = $_POST['fv'];
        $hv = $_POST['hv'];
        $id = $_POST['id'];
        $saldo = $_POST['saldo'];
        $efectivo = $_POST['efectivo'];
        $tarjeta = $_POST['tarjeta'];
        $tipot = $_POST['tipot'];
        $efectivo = efectivotoday($fv,$efectivo,$id);
        $exito = updateacuenta($fv,$hv,$id,$saldo,$efectivo,$tarjeta,$tipot);
        if ($exito){
            print('deko');
        }else{
            print('NO');
        }
        break;
    case 'clienteopto':
        $data = clienteopto();
        print(json_encode($data));
        break;
    case 'atendidos':
        $valor = $_POST['valor'];
        $id = $_POST['id'];
        $exito = atentido($valor,$id);
        if($exito){
            print('MORI DESU');
        }
        else{
            print('NO');
        }
        break;
    case 'insert':
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $fv = $_POST['fv'];
        $hv = $_POST['hv'];
        $fe = $_POST['fe'];
        $he = $_POST['he'];
        $total = $_POST['total'];
        $estado = $_POST['estado'];
        $documento = $_POST['documento'];
        $numDoc = $_POST['numDoc'];
        $refraccion = $_POST['refraccion'];
        $observacion = $_POST['observacion'];
        $fc = $_POST['fc'];
        $anulado = $_POST['anulado'];
        $descAnulado = $_POST['descAnulado'];
        $saldo = $_POST['saldo'];
        $efectivo = $_POST['efectivo'];
        $tarjeta = $_POST['tarjeta'];
        $tipot = $_POST['tipot'];
        $productos = json_decode($_POST['productos']);
        $tipocompro = $_POST['tipocompro'];
        $razonventa = $_POST['razonventa'];
        $codvendedor = $_POST['codvendedor'];
        
        $exito = insertVentaC($nombre, $apellido, $direccion, $telefono, $fv, $hv, $fe, $he, $total, $estado, $documento, $numDoc, $refraccion, $observacion, $fc, $anulado, $descAnulado, $productos, $saldo, $efectivo, $tarjeta, $tipot, $tipocompro, $razonventa, $codvendedor);
        
        print($exito);
        break;
    case 'TotalIngresosByFecha':
        //ss
        $tienda = $_POST['tienda'];
        $periodo = $_POST['periodo'];
        
        $lista;
        
        if($periodo=="DD"){
            $fec = $_POST['fecv'];
            $lista = TotalIngresosByFecha($tienda, $fec);
            //$lista = listIngresosByFecha($tienda, $fec);
        }else if($periodo=="MM"){
            $anio = $_POST['anio'];
            $mes = $_POST['mes'];
            $lista = TotalIngresosByMes($tienda, $anio, $mes);
            //$lista = listIngresosByMes($tienda, $anio, $mes);
        }else if($periodo=="YY"){
            $anio = $_POST['anio'];
            $lista = TotalIngresosByAnio($tienda, $anio);
            //$lista = listIngresosByAnio($tienda, $anio);
        }
        
        print(json_encode($lista));
        break;
    case 'listVentasByParametros':
        
        $tienda = $_POST['tienda'];
        $periodo = $_POST['periodo'];
        
        $lista;
        
        if($periodo=="DD"){
            $fec = $_POST['fecv'];
            $lista = listIngresosByFecha($tienda, $fec);
        }else if($periodo=="MM"){
            $anio = $_POST['anio'];
            $mes = $_POST['mes'];
            $lista = listIngresosByMes($tienda, $anio, $mes);
        }else if($periodo=="YY"){
            $anio = $_POST['anio'];
            $lista = listIngresosByAnio($tienda, $anio);
        }
        
        print(json_encode($lista));
        break;
    case 'getRazonSocialVenta':
        $filas = getRazonSocialVenta();
        print(json_encode($filas));
        break;
    case 'getVentaDia':
        $fecha = $_POST['fecha'];
        $idtienda = $_POST['idtienda'];
        $lista = getVentaDia($fecha, $idtienda);
        print $lista;
        break;
    case 'getgastosenventapendientes':
        $lista = getgastosenventapendientes();
        print(json_encode($lista));
        break;
}
?>
