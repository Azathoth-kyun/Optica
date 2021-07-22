<?php

require '../dal/usuarioDAL.php';

$action = $_POST['action'];

switch ($action) {
    case 'valUser':
        session_start();
        $id = $_SESSION['userID'];
        $ps = $_POST['pass'];
        $fila = getUsuario($id);
        if (md5($ps) == $fila[4]) {
            $estado = "si";
        } else {
            $estado = "no";
        }
        print $estado;
        break;
    case 'getuser':
        $us = $_POST['user'];
        $fila = GetUser($us);
        $id = $fila[0];
        print $id;
        break;
    case 'getuserDistLog':
        $us = $_POST['user'];
        $id = $_POST['id'];
        $fila = getuserDistLog($us, $id);
        $id = $fila[0];
        print $id;
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
    case 'logout':
        session_start();
        $id = $_SESSION['userID'];
        $_SESSION['isLogin'] = "no";
        unset($_SESSION['isLogin']);
        unset($_SESSION['userID']);
        unset($_SESSION['minNom']);
        unset($_SESSION['minApe']);
        unset($_SESSION['cargo']);
        unset($_SESSION['tienda']);
        break;
    case 'login':
        session_start();
        $estado = "no";
        $us = $_POST['user'];
        $ps = $_POST['pass'];
        $fila = GetUser($us);
        if ($us == $fila[1]) {
            if (md5($ps) == $fila[4]) {
                $estadotienda = GetTiendaByIdUsuario($fila[7]);
                if($estadotienda[2]==1){
                    $estado = "si";
                    $_SESSION['isLogin'] = "si";
                    $_SESSION['userID'] = $fila[0];
                    $_SESSION['nametienda'] = $estadotienda[1];
                }else{
                    $estado = "errorsusc";
                }
            } else {
                $estado = "no";
                $_SESSION['isLogin'] = "no";
            }
        } else {
            $estado = "no";
            $_SESSION['isLogin'] = "no";
        }
        print $estado;
        break;
    case 'listUsuarios':
        $lista = listUsuarios();
        print(json_encode($lista));
        break;
    case 'insertUsuario':
        $contrasena = $_POST['pass'];
        $confirmacion = $_POST['rpass'];
        if ($contrasena == $confirmacion) {
            $unom = $_POST['usuario'];
            $ape = $_POST['apellido'];
            $nom = $_POST['nombre'];
            $tipo = $_POST['tipo'];
            $codt = $_POST['tiend'];
            $exito = insertUsuario($unom, $ape, $nom, $contrasena, $tipo, $codt);
            if ($exito) {
                print('OK');
            } else {
                print('NO');
            }
        } else {
            print('DISTINTAS');
        }
        break;
    case 'updateUsuario':
        $idUsuario = $_POST['id'];
        $unom = $_POST['usuario'];
        $ape = $_POST['apellido'];
        $nom = $_POST['nombre'];
        $tipo = $_POST['tipo'];
        $codt = $_POST['tiend'];
        $usuario = getUsuario($idUsuario);
        $exito = updateUsuario($idUsuario, $unom, $ape, $nom, $usuario['password'], $tipo, $usuario['estado'], $codt);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'updateContrasena':
        $idUsuario = $_POST['id'];
        $contrasena = $_POST['pass'];
        $confirmacion = $_POST['rpass'];
        if ($contrasena !== $confirmacion) {
            print('DISTINTAS');
        } else {
            $unom = $_POST['usuario'];
            $ape = $_POST['apellido'];
            $nom = $_POST['nombre'];
            $tipo = $_POST['tipo'];
            $codt = $_POST['tiend'];
            $contrasena = md5($contrasena);
            $usuario = getUsuario($idUsuario);
            $exito = updateUsuario($idUsuario, $unom, $ape, $nom, $contrasena, $tipo, $usuario['estado'], $codt);
            if ($exito) {
                print('OK');
            } else {
                print('NO');
            }
        }
        break;
    case 'updateSech':
        $id= $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $tipo = $_POST['tipo'];
        $numDoc = $_POST['numDoc'];
        $data = updateSech($id,$nombre,$apellido,$tipo,$numDoc);
        if($data){
            print('OK');
        }else {
            print('NO');
        }
        break;
    case 'saveSech':
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $tipo = $_POST['tipo'];
        $numDoc = $_POST['numDoc'];
        $data = saveSech($nombre,$apellido,$tipo,$numDoc);
        if($data){
            print('OK');
        }else {
            print('NO');
        }
        break;
    case 'getVendedor':
        $idVendedor = intval($_POST['id']);
        $fila = getVendedor($idVendedor);
        if ($fila != "") {
            print(json_encode($fila));
        } else {
            print "no";
        }
        break;
    case 'loadVendedores':
        $data = loadVendedores();
        print(json_encode($data));
        break;
    case 'removeUsuario':
        $idUsuario = intval($_POST['idUsuario']);
        $exito = removeUsuario($idUsuario);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'removeVendedor':
        $idVendedor = $_POST['id'];
        $exito = removeVendedor($idVendedor);
        if ($exito) {
            print('OK');
        } else {
            print('NO');
        }
        break;
    case 'getTipous':
        session_start();
        print($_SESSION['cargo']);
        break;
}
?>
