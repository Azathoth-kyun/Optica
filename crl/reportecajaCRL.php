<?php

require '../dal/reportecajaDAL.php';

$action = $_POST['action'];

switch ($action) {

    case 'rptTY':
        $año = $_POST['año'];
        $idt = $_POST['idt'];
        $valores = [['01', $año, '0.00', '0.00', '0.00'],
            ['02', $año, '0.00', '0.00', '0.00'],
            ['03', $año, '0.00', '0.00', '0.00'],
            ['04', $año, '0.00', '0.00', '0.00'],
            ['05', $año, '0.00', '0.00', '0.00'],
            ['06', $año, '0.00', '0.00', '0.00'],
            ['07', $año, '0.00', '0.00', '0.00'],
            ['08', $año, '0.00', '0.00', '0.00'],
            ['09', $año, '0.00', '0.00', '0.00'],
            ['10', $año, '0.00', '0.00', '0.00'],
            ['11', $año, '0.00', '0.00', '0.00'],
            ['12', $año, '0.00', '0.00', '0.00']];
        $lista = rptTY($año, $idt);
        for ($i = 0; $i < count($lista); $i++) {
            for ($j = 0; $j < count($valores); $j++) {
                if ($lista[$i][0] == $valores[$j][0]) {
                    $valores[$j][2] = $lista[$i][2];
                    $valores[$j][3] = $lista[$i][3];
                    $valores[$j][4] = $lista[$i][4];
                }
            }
        }
        print(json_encode($valores));
        break;
    case 'rptAY':
        $año = $_POST['año'];
        $tiendas = listTiendas();
        $valores = [];
        for ($j = 0; $j < count($tiendas); $j++) {
            array_push($valores, array($año, $tiendas[$j][0], '0.00', '0.00', '0.00'));
        }
        $lista = rptAY($año);
        for ($i = 0; $i < count($lista); $i++) {
            for ($j = 0; $j < count($valores); $j++) {
                if ($lista[$i][1] == $valores[$j][1]) {
                    $valores[$j][2] = $lista[$i][2];
                    $valores[$j][3] = $lista[$i][3];
                    $valores[$j][4] = $lista[$i][4];
                }
            }
        }
        print(json_encode($valores));
        break;
    case 'rptAM':
        $año = $_POST['año'];
        $mes = $_POST['mes'];
        $tiendas = listTiendas();
        $valores = [];
        for ($j = 0; $j < count($tiendas); $j++) {
            array_push($valores, array($mes, $año, $tiendas[$j][0], '0.00', '0.00', '0.00'));
        }
        $lista = rptAM($mes, $año);
        for ($i = 0; $i < count($lista); $i++) {
            for ($j = 0; $j < count($valores); $j++) {
                if ($lista[$i][2] == $valores[$j][2]) {
                    $valores[$j][3] = $lista[$i][3];
                    $valores[$j][4] = $lista[$i][4];
                    $valores[$j][5] = $lista[$i][5];
                }
            }
        }
        print(json_encode($valores));
        break;
    case 'rptTM':
        $año = $_POST['año'];
        $mes = $_POST['mes'];
        $idt = $_POST['idt'];
        $tiendas = date("d", mktime(0, 0, 0, $mes + 1, 0, $año));
        $valores = [];
        for ($j = 0; $j < $tiendas; $j++) {
            $Aux = $j + 1;
            if ($Aux < 10) {
                $Aux = '0' . $Aux;
            }
            array_push($valores, array($Aux, $mes, $año, '0.00', '0.00', '0.00'));
        }
        $lista = rptTM($mes, $año, $idt);
        for ($i = 0; $i < count($lista); $i++) {
            for ($j = 0; $j < count($valores); $j++) {
                if ($lista[$i][0] == $valores[$j][0]) {
                    $valores[$j][3] = $lista[$i][3];
                    $valores[$j][4] = $lista[$i][4];
                    $valores[$j][5] = $lista[$i][5];
                }
            }
        }
        print(json_encode($valores));
        break;
    case 'rptCA':
        $dia = $_POST['dia'];
        $tiendas = listTiendas();
        $valores = [];
        for ($j = 0; $j < count($tiendas); $j++) {
            array_push($valores, array($dia, $tiendas[$j][0], '0.00', '0.00'));
        }
        $lista = rptCA($dia);
        for ($i = 0; $i < count($lista); $i++) {
            for ($j = 0; $j < count($valores); $j++) {
                if ($lista[$i][1] == $valores[$j][1]) {
                    $valores[$j][2] = $lista[$i][2];
                    $valores[$j][3] = $lista[$i][3];
                }
            }
        }
        print(json_encode($valores));
        break;
    case 'rptETA':
        $dia = $_POST['dia'];
        $tiendas = listTiendas();
        $valores = [];
        for ($j = 0; $j < count($tiendas); $j++) {
            array_push($valores, array($dia, $tiendas[$j][0], '0.00', '0.00'));
        }
        $lista = rptETA($dia);
        for ($i = 0; $i < count($lista); $i++) {
            for ($j = 0; $j < count($valores); $j++) {
                if ($lista[$i][1] == $valores[$j][1]) {
                    $valores[$j][2] = $lista[$i][2];
                    $valores[$j][3] = $lista[$i][3];
                }
            }
        }
        print(json_encode($valores));
        break;
}
?>
