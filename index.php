<?php

require './dal/usuarioDAL.php';

session_start();
$pindex = "main.php";

if (isset($_SESSION['isLogin'])) {

    if ($_SESSION['isLogin'] === "si") {
	    $fila2 = getUsuario($_SESSION['userID']);
	    $nombres = str_split(" ", $fila2[3]);
        $apellidos = str_split(" ", $fila2[2]);
	    $_SESSION['minNom'] = $nombres[0];
	    $_SESSION['minApe'] = $apellidos[0];
	    $_SESSION['cargo'] = $fila2[5];
        $_SESSION['tienda'] = $fila2[7];
        $msg = getMsg();
        $_SESSION['msg']=$msg[0][0];
        if($fila2[5] == 'Optometra'){
            $pindex = "omain.php";
        } else if($fila2[5] == 'Mensajeria') {
            $pindex = "mmain.php";
        }
    	header("Location: " . $pindex);
    } else {
	    header("Location: login.php");
    }

} else {
    header("Location: login.php");
}
?>