<?php
session_start();
if (isset($_SESSION['isLogin'])) {
    if ($_SESSION['isLogin'] === "si") {
        $cargo = $_SESSION['cargo'];
        $mensaje = $_SESSION['msg'];
        ?>
        <!DOCTYPE html>
        <html class="metro">
        <head>
            <meta charset="UTF-8">
            <title>Optiventas: <?= $cargo; ?></title>
            <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
            <link rel="stylesheet" type="text/css" href="css/app.css?v=2">
            <link rel="stylesheet" type="text/css" href="css/main-res.css?v=122">
            <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
            <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">
            </head>
            <style>
            .pedido{
                height:600px !important;
                }
            </style>
            <body>
                <header>
                    <nav>
                        <ul class="nav">
                            <li class="cl-logoMain">
                                <div class="cl-logooptiventas"></div>
                            </li>
                            <li onclick="openModal('detallegastoventa2'); modalpedido();" class="cl-btnNavSup" style="background-color: #099df3; width: 50px !important;">
                                <a href="#" class="borde-izquierdo-none" style="position: absolute; left: 0px; right: 0px; bottom: 0px; padding: 0px !important;">P</a>
                            </li>
                            <li onclick="openModal('dia');" class="cl-btnNavSup" style="background-color: #0d8fda; width: 50px !important;">
                                <a href="#" class="borde-izquierdo-none" style="position: absolute; left: 0px; right: 0px; bottom: 0px; padding: 0px !important;">D</a>
                            </li>
                            <li onclick="openModal('inter');" class="cl-btnNavSup" style="background-color: #0d8fda; width: 50px !important;">
                                <a href="#" class="borde-izquierdo-none" style="position: absolute; left: 0px; right: 0px; bottom: 0px; padding: 0px !important;">M</a>
                            </li>

                            <li id="desplegar" style="width: 128px !important;">
                                <a href="#" class="icon-desplegar cl-userIz" style="width: 122px; padding: 0px !important; display: block; height: 60px; border-radius: initial; overflow: hidden !important;"><?= $_SESSION['minNom']; ?> <?= $_SESSION['minApe']; ?></a><a href="#" class="cl-userDer"><?= strtoupper($_SESSION['cargo']); ?></a>
                                <ul class="subnav">
                                    <li onclick="logout();"><a href="#">Salir</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </header>
                <section id="right" style="">
                    <img src="img/logo-cliente.png" class="marca">
                </section>
                
                <footer>
                    <div class="msgSys icon-mensaje"><?= $mensaje ?></div>

                </footer>
                <?php require './modal.php'; ?>
                <script>
                    document.oncontextmenu = function(){return false}
                    var tiendaUser = "<?= $_SESSION['tienda'] ?>";
                    var nombreUser = "<?= $_SESSION['minNom']; ?> <?= $_SESSION['minApe']; ?>";
                </script>
                <script src="js/jquery-2.1.1.min.js"></script>
                <script src="js/app.js"></script>
            </body>
            <script>
                function loadAlerts() {
                    
                }
                function closeAlertas(){
                }
                function quitmodalpedido(){
                    $('#Modal').removeClass("pedido");
                }
                function modalpedido(){
                    $('#Modal').addClass("pedido");
                }
            </script>
            
            </html>
            <?php
        } else {
            header("Location: login.php");
        }
    } else {
        header("Location: login.php");
    }
    ?>