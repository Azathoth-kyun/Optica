<?php

require '../dal/reportedeboletasDAL.php';

$action = $_POST['action'];

switch ($action) {
    case 'getReporteBoleta':
        $tienda = $_POST['tienda'];
        $fechainicio = $_POST['fechainicio'];
        $fechafin = $_POST['fechafin'];
        $razon = $_POST['razon'];
        
        $lista = getReporteBoleta($tienda, $fechainicio, $fechafin, $razon);
        print(json_encode($lista));
        break;
    case 'getReporteBoletaByCodVenta':
        $codventa = $_POST['codventa'];
        
        $lista = getReporteBoletaByCodVenta($codventa);
        print(json_encode($lista));
        break;
    case 'getDetalleGasto':
        $idventa = $_POST['idventa'];
        
        $lista = getDetalleGasto($idventa);
        print(json_encode($lista));
        break;
    case 'getDetalleGastoReporte':
        $idventa = $_POST['idventa'];
        
        $lista = getDetalleGastoReporte($idventa);
        print(json_encode($lista));
        break;
}
?>