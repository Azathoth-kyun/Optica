<?php
session_start();
if (isset($_SESSION['isLogin'])) {
    if ($_SESSION['isLogin'] === "si") {
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>sistema optica</title>

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/login.css?v=2">
    <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">
</head>
<body class="colorBack">
    <header>
        <div class="figLogoOptiventas">
            <img src="img/logo-optica.svg" alt="Optiventas" class="logoOpVe">
        </div>
    </header>
    <section class="content-login">
        <div class="row">
            <figure class="content-logo">
                <img src="img/ico-optica.svg" alt="Opticenter" width="300px">
            </figure>
            <div class="contenedor">
                <form id="frmLogin" method="post">
                    <input type="hidden" name="action" value="login">
                    <div class="cl-input"><div class="cl-user"></div>
                    <input id="user" type="text" name="user" placeholder="User" required>
                    </div>
                    <div class="cl-input"><div class="cl-clave"></div>
                    <input id="pass" type="password" name="pass" placeholder="Password" required>
                    </div>
                    <div id="msg" class="msgAlertLogin"></div>
                    <button id="btningresar" type="submit">Ingresar</button>
                </form>
            </div>
        </div>
    </section>
    <footer>

    </footer>
    
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/app.js"></script>
    
    <script type="text/javascript">
        $('#user').focus();
        $(function() {
            $('#frmLogin').submit(function(event) {
                event.preventDefault();
                $("#btningresar").html("<img src='img/cargando.gif?r=222'class=\"preload\" >");
                $.ajax({
                    type: 'POST',
                    url: 'crl/usuarioCRL.php',
                    data: $('#frmLogin').serialize(),
                    success: function(data) {
                        if (data === "si") {
                            location.href = "index.php";
                        } else if (data === "no") {
                            $('#btningresar').css('margin-top','36px');
                            $("#msg").text("Contraseña o Usuario incorrecto");
                            $("#msg").css("display","block");
                            $("#btningresar").html("Ingresar");
                            $('#user').focus();
                            $('#msg').removeClass("msgBye");
                        } else if (data === "errorsusc") {
                            $('#btningresar').css('margin-top','36px');
                            $("#msg").text("La suscripción de la tienda a caducado.");
                            $("#msg").css("display","block");
                            $("#btningresar").html("Ingresar");
                            $('#user').focus();
                            $('#msg').removeClass("msgBye");
                        }
                        
                        setTimeout(function () {
                            $('#msg').addClass("msgBye");
                            setTimeout(function () {
                                $('#msg').css("display","none");
                                $('#btningresar').css('margin-top','9px');
                            }, 700);

                        }, 4000);
                    }
                });
                
            });
        });
    </script>
</body>
</html>
