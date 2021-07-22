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
            <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
            <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">
            <style>
                .Alert-activa {
                    display: inline-block;
                    color: white !important;
                    position: relative;
                    margin-top: 4px;
                }

                .Number-Alert {
                    position: absolute;
                    top: 10px;
                    right: -3px;
                    background: red;
                    border-radius: 50%;
                    height: 20px;
                    width: 20px;
                    z-index: 0;
                    font-size: 0.8em;
                    -webkit-animation: bounceInNum 0.75s;
                }

                .nroalertas {
                    position: absolute;
                    top: -20px;
                    left: 7px;
                }
            </style>
        </head>

        <body>
            <header>
                <nav>
                    <ul class="nav">
                        <li class="cl-logoMain">
                            <div class="cl-logooptiventas"></div>
                        </li>

                        <li onclick="openModal('medicion');" class="cl-btnNavSup" style="background-color: #ED4F2E;">
                            <a href="#" class="borde-izquierdo-none icon-medicion"><span id='med'>Medición</span></a>
                        </li>
                        <li onclick="openModal('historial');" class="cl-btnNavSup" style="background-color: #BD3317;">
                            <a href="#" class="borde-izquierdo icon-dia"><span id="his">Historial</span></a>
                        </li>
                        <li onclick="openModal('clienteopto');close_Alertas();" class="cl-btnNavSup" style="background-color: #ED4F2E;">
                            <a href="#" class="borde-izquierdo">
                                <span id="alertSi" class="flaticon-notifications Alert-activa" style="display: inline-block;width: 38px;height:45px;">
                                    <div class="Number-Alert" id="rednumalerta" style="display: none;">
                                        <div id="nroAlertas" class="nroalertas">
                                        </div>
                                    </div>
                                </span></a>
                        </li>


                        <li id="desplegar">
                            <a href="#" class="icon-desplegar cl-userIz"><?= $_SESSION['minNom']; ?> <?= $_SESSION['minApe']; ?></a><a href="#" class="cl-userDer"><?= strtoupper($_SESSION['cargo']); ?></a>
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
                document.oncontextmenu = function() {
                    return false
                }
                var tiendaUser = "<?= $_SESSION['tienda'] ?>";
                var nombreUser = "<?= $_SESSION['minNom']; ?> <?= $_SESSION['minApe']; ?>";
            </script>
            <script src="js/jquery-2.1.1.min.js"></script>
            <script src="js/app.js"></script>
        </body>
        <script>
            function tienespacientes() {
                var tienes;
                $.ajax({
                    type: 'POST',
                    url: 'crl/ventaCRL.php',
                    data: {
                        action: 'clienteopto'
                    },
                    success: function(data) {
                        var lista = JSON.parse(data);
                        console.log(lista);
                        tienes = lista.length;
                        if (tienes != 0) {
                            document.getElementById('rednumalerta').style.display="block";
                            $('#nroAlertas').html(tienes);
                            if (window.Notification && Notification.permission !== "denied") {
                                Notification.requestPermission(function(status) { // status is "granted", if accepted by user
                                    var n = new Notification('Atención', {
                                        body: 'Tienes pacientes por atender!',
                                        icon: 'img/logo-cliente.png' // optional
                                    });
                                });
                            }
                        }
                    },
                    error: function() {
                        console.log('ERROR');
                    }
                })
                console.log(tienes);

            }

            function loadAlerts() {

            }

            function closeAlertas() {
                document.getElementById('rednumalerta').style.display="none";
            }
            setInterval(tienespacientes, 5000);
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