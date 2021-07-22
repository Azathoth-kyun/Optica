<?php
session_start();
if (isset($_SESSION['isLogin'])) {
    if ($_SESSION['isLogin'] === "si") {
        $cargo = $_SESSION['cargo'];
        $mensaje = $_SESSION['msg'];
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Optiventas: <?= $cargo; ?></title>
            <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
            <link rel="stylesheet" type="text/css" href="css/app.css?v=2">
            <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
            <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">
            <style>
                .modelo-venta{
                    width:690px !important;
                }
                ::-webkit-scrollbar{
                    width: 5px;
                }
                ::-webkit-scrollbar-button{
                    width:8px;
                    height: 5px;
                }
                ::-webkit-scrollbar-track{
                    background:gainsboro;
                    -webkit-border-radius: 10px;
                    border-radius: 10px;
                }
                ::-webkit-scrollbar-thumb{
                    background:gray;
                    border-radius: 10px;
                    -webkit-border-radius: 10px;
                }
                ::-webkit-scrollbar-thumb:hover{
                    background:rgba(0,0,0,.6);
                }
                ::-webkit-scrollbar-thumb:window-inactive {
                    background: rgba(0,0,0,.1);
                }
                .loadone{
                    display: none;
                    position: absolute;
                    bottom: 0px;
                    left: 3px;
                    background: white;
                    border: 5px solid white;
                }
                .header-chat{
                    cursor: pointer;
                }
                .sum2{
                    height: 32px;
                    width: 35px;
                    border-radius: 50%;
                    position: absolute;
                    top: 5px;
                    left: 80px;
                    background: #E82121;
                    line-height: 2.2;
                    text-align: center;
                    cursor: pointer;
                    color: white !important;
                    -webkit-animation: bounceIn 1s;
                    animation: bounceIn 1s;
                }
                .list-chat2{
                    background: white;
                    width: 298px;
                    list-style: none;
                    padding: 10px;
                    height: 200px;
                    overflow-y: scroll;
                    border-bottom: 1px solid rgba(0,0,0,.1);
                }
                .body-chat2{
                    border: 1px solid #B7B7B7;
                    position: relative;
                    border-top: none;
                    bottom: 0px;
                    display: block;
                }
            </style>
        </head>
        <body class="mainbody">
            <header>
                <?php require 'header.php'; ?>
            </header>
            <aside id="left">
                <?php require 'sidebar.php'; ?>
            </aside>
            <section id="right" style="">
                <img src="img/logo-cliente.png" class="marca">
            </section>

            <?php
            if ($cargo == 'Ventas') {
                ?>
                <div class="chat">
                    <div class="header-chat" onclick="alternar();">
                        <div class="sum"></div>
                        Pacientes Atendidos
                        <div class="icon"></div>
                    </div>
                    <div class="body-chat">
                        <ul class="list-chat">
                        </ul>
                        <div class="find-chat">
                            <div class="icon-buscar pibuscar"></div>
                            <input type="text" name="pbuscar" id="pbuscar" class="pinputbuscar" placeholder="Buscar">
                            <div class="loadone cl-loadChat"></div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            
            <?php require './modal.php'; ?>
            <script>
                document.oncontextmenu = function(){return false}
                var tiendaUser = "<?= $_SESSION['tienda'] ?>";
                var nombreUser = "<?= $_SESSION['minNom']; ?> <?= $_SESSION['minApe']; ?>";
            </script>
            <script src="js/jquery-2.1.1.min.js"></script>
            <script src="js/app.js"></script>
            <script language="javascript" src="js/fancywebsocket.js"></script>
            <script>
                function quitmodalmodelo(){
                    $('#Modal').removeClass("modelo-venta");
                }
                function modalmodelo(){
                    $('#Modal').addClass("modelo-venta");
                }
                limpiarList();
                loadall();
                alternar();
                $('#pbuscar').focus();
                function limpiarList() {
                    $('.list-chat').html('');
                }
                function loadall() {
                    $.ajax({
                        type: 'POST',
                        url: 'crl/medicionCRL.php',
                        data: {action: 'listxVenta', fec: fecha()},
                        success: function (data) {
                            var client = JSON.parse(data);
                            console.log(client);
                            //cambia solo lo de direccion
                            var string = '';
                            $('.sum').html(client.length);
                            for (var i = 0; i < client.length; i++) {
                                string += '<li class="item-chat"  onclick=\"getDiop(\'' + client[i][0] + '\');\">\n\
                                <div class="pac-item">' + client[i][1] + ' ' + client[i][2] + ' ' + client[i][13] + '</div>\n\
                                <div class="optometra-item">' + client[i][12] + ' - ' + client[i][3] + ' - ' + client[i][9] + '</div>\n\
                            </li>';
                        }
                        $('.list-chat').html(string);
                    },
                    error: function () {
                        msgError("Error del Sistema.", "red");
                    }
                });
}
function cerrarmedida(id){
    $.ajax({
        type: 'POST',
        url: 'crl/medicionCRL.php',
        data: {action: 'cerrarmedida', id: id},
        success: function (data) {
            if(data=='OK'){
                console.log('BIEN');
                loadall();
            }else{
                console.log('PUTAMARE');
            }
        },
        error: function(){
            console.log('MAL');
        }
    })
}
function getDiop(id) {
    var time = new Date().getTime();
    $('#modalTitulo').html('Punto de Venta');
    $('#modalIframe').attr('src', 'modulos/ventas.html?med=' + id + '&time=' + time);
    $('#Modal').css('height', '590px');
    $('#Modal').css('width', '1155px');
    $('#Mask').fadeToggle('slow');
    setTimeout(function () {
        $('#Modal').fadeToggle('slow');
    }, 200);
    cerrarmedida(id);
                            //alternar();
                        }
                        function find() {
                            $(".loadone").css('display', 'block');
                            var cod = $("#pbuscar").val();
                            $("#pbuscar").val($("#pbuscar").val().toUpperCase());
                            if (cod == "") {
                                loadall();
                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: 'crl/medicionCRL.php',
                                    data: {action: 'findxVenta', path: cod},
                                    success: function (data) {
                                        var client = JSON.parse(data);
                                        var string = '';
                                        for (var i = 0; i < client.length; i++) {
                                            string += '<li class="item-chat"  onclick=\"getDiop(\'' + client[i][0] + '\');\">\n\
                                            <div class="pac-item">' + client[i][1] + ' ' + client[i][2] + '</div>\n\
                                            <div class="optometra-item">' + client[i][11] + ' - ' + client[i][3] + ' - ' + client[i][9] + '</div>\n\
                                        </li>';
                                    }

                                    $('.list-chat').html(string);
                                },
                                error: function () {
                                    msgError("Error del Sistema.", "red");
                                }
                            });
}
$(".loadone").css('display', 'none');
$("#pbuscar").select();
}
function alternar() {
    $('.icon').css('background', 'url(img/maximize-01.svg)');
    $('.body-chat').animate({'height':'toggle'});
}
$("#pbuscar").keyup(function (e) {
    if (e.keyCode == 13) {
        find();
    } else {
        limpiarList();
    }
});


var openalter=0;


var openalterMensajes=0;
function abrirMensajes(){
    if(openalterMensajes==0){
        document.getElementById('divMensajes').style.display = "block";
        document.getElementById('divAlertas').style.display = "none";
        document.getElementById('divMetas').style.display = "none";
        openalterMensajes=1;
        openalter=0;
        openaltermeta=0;
    }else{
        document.getElementById('divMensajes').style.display = "none";
        openalterMensajes=0;
        if(conta>0){
            $.ajax({
                type: 'POST',
                url: 'crl/mensajeCRL.php',
                data: {action: 'updateMensajesLeido', tienda: tiendaaa},
                success: function (data) {
                    loadMensajesByTienda();
                },
                error: function () {
                    msgError("Error del Sistema", "#F77474");
                }
            });
        }
    }
}

var openaltermeta=0;
function abrirMetas(){
    if(openaltermeta==0){
        document.getElementById('divMetas').style.display = "block";
        document.getElementById('divAlertas').style.display = "none";
        document.getElementById('divMensajes').style.display = "none";
        openalterMensajes=0;
        openalter=0;
        openaltermeta=1;
        if(conta>0){
            $.ajax({
                type: 'POST',
                url: 'crl/mensajeCRL.php',
                data: {action: 'updateMensajesLeido', tienda: tiendaaa},
                success: function (data) {
                    loadMensajesByTienda();
                },
                error: function () {
                    msgError("Error del Sistema", "#F77474");
                }
            });
        }
    }else{
        document.getElementById('divMetas').style.display = "none";
        openaltermeta=0;
    }
}
<?php
    if ($cargo == 'Mensajeria') {
?>
        //desde aca mensajeria
        function closeAlertas(){
            document.getElementById('divAlertas').style.display = "none";
            openalter=0;
        }

        function abrirAlertas(){
            if(openalter==0){
                document.getElementById('divAlertas').style.display = "block";
                openalter=1;
            }else{
                document.getElementById('divAlertas').style.display = "none";
                openalter=0;
            }
        }

        loadAlerts();
        function loadAlerts() {
            //alert("load");
            var contAlerts=0;
            var stringalert = '';
            stringalert +='<div class="Msg-AlertTitle">Aviso</div>';
                    $.ajax({
                        type: 'POST',
                        url: 'crl/ventaCRL.php',
                        data: {action: "getgastosenventapendientes"},
                        success: function (data) {
                            var movimientos = JSON.parse(data);

                            if(movimientos.length>0){
                                stringalert +='<div class="Msg-Alert">';
                                stringalert +='<h4>Tienes pedidos por revisar</h4>';
                                stringalert +='<p></p>';
                                stringalert +='<span style="cursor: pointer" onclick="openModal(\'detallegastoventa2\');" target="ventana_iframe" class="btn btn-rojo-suave btn-animate">Ver pedidos pendientes</span>';
                                stringalert +='</div>';
                                contAlerts++;
                            }

                            $('#listAlertas').html(stringalert);

                            var stringale="";
                            if(contAlerts==0){
                                stringale +='<div class="Msg-AlertTitle">Aviso</div>';
                                stringale +='<div class="Msg-Alert">';
                                stringale +='<h4>No tiene notificaciones.</h4>';
                                stringale +='<p></p>';

                                stringale +='</div>';

                                $('#listAlertas').html(stringale);
                                document.getElementById('rednumalerta').style.display="none";
                            }else{
                                document.getElementById('rednumalerta').style.display="block";
                            }
                            $('#nroAlertas').html(movimientos.length);

                        },
                        error: function () {
                        }
                    });
        }
<?php
    }else if ($cargo == 'Ventas') {
?>
    var tiendaaa = "<?= $_SESSION['tienda'] ?>";
    function abrirAlertas(){
        if(openalter==0){
            document.getElementById('divAlertas').style.display = "block";
            document.getElementById('divMensajes').style.display = "none";
            document.getElementById('divMetas').style.display = "none";
            openalter=1;
            openalterMensajes=0;
            openaltermeta=0;
            if(conta>0){
                $.ajax({
                    type: 'POST',
                    url: 'crl/mensajeCRL.php',
                    data: {action: 'updateMensajesLeido', tienda: tiendaaa},
                    success: function (data) {
                        loadMensajesByTienda();
                    },
                    error: function () {
                        msgError("Error del Sistema", "#F77474");
                    }
                });
            }
        }else{
            document.getElementById('divAlertas').style.display = "none";
            openalter=0;
        }
    }

    function closeMensajes(){
        document.getElementById('divMensajes').style.display = "none";
        openalterMensajes=0;
    }

        loadMensajesByTienda();
        var conta;
        function loadMensajesByTienda() {
            //alert("loadalerts");
            var contAlerts=0;
            var stringalert = '';
            conta=0;
            $.ajax({
                type: 'POST',
                url: 'crl/mensajeCRL.php',
                data: {action: 'listMensajesByTienda', idtienda: tiendaaa},
                success: function (data) {
                    var lista = JSON.parse(data);

                    if(lista.length>0){
                        //stringalert += "<li style='height: initial;margin-bottom: 10px;' onclick='openModal(\"alta\");abrirAlertas()'>";
                        //stringalert += "<span>Tiene alta de monturas pendientes</span>";
                        //stringalert += "</li>";
                        var string ='<div class="Msg-AlertTitle">MENSAJES</div><div style="height: 400px;overflow-y: scroll;border-radius: 0px 0px 8px 8px;">';

                        for (var i = 0; i < lista.length; i++) {
                            var leido="";
                            if(lista[i].estado==0){
                                conta++;
                                leido='style="text-align: inherit; background: rgba(232, 33, 33, 0.14);"';
                            }else{
                                leido='style="text-align: inherit; background:#fff;"';
                            }

                            string +='<div class="Msg-Alert" '+leido+'>';
                            string +='<h4>'+lista[i].asunto+'</h4>';
                            string +='<p style="font-size: 0.9em;">'+lista[i].mensaje+'</p>';
                            string +='<p style="text-align: right;">'+toFecha(lista[i].fecha)+'-'+lista[i].hora+'</p>';
                            string +='</div>';
                        }
                        string += '</div>';
                        document.getElementById('rednummensaje').style.display="block";
                        $('#nroMensajes').html(conta);
                        $('#listMensajes').html(string);
                    }else{
                        string +='<div class="Msg-AlertTitle">Aviso</div>';
                        string +='<div class="Msg-Alert">';
                        string +='<h4>No tiene notificaciones.</h4>';
                        string +='<p></p>';
                        string +='</div>';

                        $('#listMensajes').html(string);
                        document.getElementById('rednummensaje').style.display="none";
                    }

                    if(conta==0){
                        document.getElementById('rednummensaje').style.display="none";
                    }
                },
                error: function () {
                }
            });
        }

        function cerrarBloqueoMensaje(){
            document.getElementById('bloqueomensaje').style.display = "none";
        }

        function closeAlertas(){
            document.getElementById('divAlertas').style.display = "none";
            openalter=0;
            document.getElementById('divMetas').style.display = "none";
            openalterMensajes=0;
            document.getElementById('divMensajes').style.display = "none";
            openaltermeta=0;
        }

        loadAlerts();
        function loadAlerts() {
            //alert("loadalerts");
            var contAlerts=0;
            var stringalert = '';
            stringalert +='<div class="Msg-AlertTitle">Aviso</div>';
            $.ajax({
                type: 'POST',
                url: 'crl/movimientoCRL.php',
                data: {action: "listp", tienda: tiendaaa},
                success: function (data) {
                    var movimientos = JSON.parse(data);

                    if(movimientos.length>0){
                        //stringalert += "<li style='height: initial;margin-bottom: 10px;' onclick='openModal(\"alta\");abrirAlertas()'>";
                        //stringalert += "<span>Tiene alta de monturas pendientes</span>";
                        //stringalert += "</li>";
                        contAlerts++;


                        stringalert +='<div class="Msg-Alert">';
                        stringalert +='<h4>Tienes monturas/armazones por verificar</h4>';
                        stringalert +='<p></p>';
                        stringalert +='<span style="cursor: pointer" onclick="openModal(\'alta\');" target="ventana_iframe" class="btn btn-rojo-suave btn-animate">Alta de Monturas</span>';
                        stringalert +='</div>';
                    }

                    $.ajax({
                        type: 'POST',
                        url: 'crl/movimientoCRL.php',
                        data: {action: "listpProd", tienda: tiendaaa},
                        success: function (data) {
                            var movimientos = JSON.parse(data);

                            if(movimientos.length>0){
                                stringalert +='<div class="Msg-Alert">';
                                stringalert +='<h4>Tienes productos por verificar</h4>';
                                stringalert +='<p></p>';
                                stringalert +='<span style="cursor: pointer" onclick="openModal(\'altaP\');" target="ventana_iframe" class="btn btn-rojo-suave btn-animate">Alta de Productos</span>';
                                stringalert +='</div>';
                                contAlerts++;
                            }

                            $('#listAlertas').html(stringalert);

                            var stringale="";
                            if(contAlerts==0){
                                stringale +='<div class="Msg-AlertTitle">Aviso</div>';
                                stringale +='<div class="Msg-Alert">';
                                stringale +='<h4>No tiene notificaciones.</h4>';
                                stringale +='<p></p>';

                                stringale +='</div>';

                                $('#listAlertas').html(stringale);
                                document.getElementById('rednumalerta').style.display="none";
                            }else{
                                document.getElementById('rednumalerta').style.display="block";
                            }
                            $('#nroAlertas').html(contAlerts);

                        },
                        error: function () {
                        }
                    });
                },
                error: function () {
                }
            });
        }

        //Avance de metas

        var f = new Date();
        var aniosel = f.getFullYear();
        var messel = f.getMonth() + 1;
        var diasel = f.getDate();
        var messel2=f.getMonth() + 1;
        if(diasel<10){
            diasel = '0'+diasel;
        }
        if(messel2<10){
            messel2 = '0'+messel2;
        }
        var fechahoy = diasel+'/'+messel2+'/'+aniosel;

        //alert(tiendaaa + ' ' +fechahoy);
        var totaldia=0;
        $('#divDateMeta').html("REPORTE DE METAS: " + getMesName(parseInt(messel)) + " - " + aniosel);
        loadProgress();
        function loadProgress(){
            document.getElementById('cargandometa').style.display = "block";
            $.ajax({
                type: 'POST',
                url: 'crl/ventaCRL.php',
                async : false,
                data: {action: 'getVentaDia', idtienda: tiendaaa, fecha: fechahoy},
                success: function (tot) {
                    totaldia=tot;
                }
            });

            $.ajax({
                type: 'POST',
                url: 'crl/metaCRL.php',
                data: {action: 'getMetaByMesByAnioByTienda', idtienda: tiendaaa, anio: aniosel, mes: messel},
                success: function (meta) {
                    var mesb = "";
                    if(messel<10){
                        mesb="0"+messel;
                    }else{
                        mesb=messel;
                    }
                    //alert("mesb: "+mesb);
                    $.ajax({
                        type: 'POST',
                        url: 'crl/metaCRL.php',
                        data: {action: 'TotalIngresosByFecha', tienda: tiendaaa, anio: aniosel, mes: mesb},
                        success: function (data) {
                            var lista = JSON.parse(data);

                            //for (var i = 0; i < lista.length; i++) {
                                //totalingresos = totalingresos + parseFloat(lista[i].efectivo) + parseFloat(lista[i].tarjeta);
                            //}
                            totali=lista[0].acuenta;

                            //$('#totalUtilidades').val((totali-totalg).toFixed(2));

                            var totalpercent=0;

                            if(meta>0){
                                //alert(totali + " " + meta);
                                totalpercent = totali*100/meta;
                            }

                            var mesprev=messel-1;
                            var anioprev=aniosel;
                            if((mesprev)<1){
                                mesprev=12;
                                anioprev=aniosel-1;
                            }
                            document.getElementById("divProgress0").innerHTML=''
                                +'<span onclick="previousMeta('+anioprev+', '+mesprev+');" id="btnAtras" class="icon-atras" style="position: absolute;top: 37px;left: 3px;cursor: pointer;"></span>'
                                +'<div id="progresspie0" class="progress-pie-chart" data-percent="'+totalpercent+'" style="display: inline-block;float: left;">'
                                    +'<div class="ppc-progress">'
                                      +'<div class="ppc-progress-fill" id="progressppc0"></div>'
                                    +'</div>'
                                    +'<div class="ppc-percents">'
                                      +'<div class="pcc-percents-wrapper">'
                                        +'<span id="porcentajeav0">%</span>'
                                       +'</div>'
                                    +'</div>'
                                +'</div>'
                                +'<div style="float: right;width: 160px;height: 210px;display: inline-block;text-align: left;">'
                                +'<div style="font-size: 19px;">'
                                +'<span>Ventas</span><br/><br/>'
                                +'<span style="color: rgb(15, 104, 211);">Total: '+lista[0].total+'</span><br/><br/>'
                                +'<span style="color: rgb(30, 165, 46);">A cuenta: '+totali+'</span><br/><br/>'
                                +'<span style="color: rgb(229, 74, 74);">Saldo: '+lista[0].saldo+'</span>'
                                +'</div>'
                                +'</div>'
                                +'<div style="display: inline-block;margin-top: 10px;">'
                                +'<span style="font-size: 19px;">Meta: '+meta+'</span>'
                                +'</div>';
                                //+'<div style="display: inline-block;margin-top: 10px;">'
                                //+'<span style="font-size: 19px;">Venta del día: '+totaldia+'</span>'
                                //+'</div>'

                            var $ppc = $('#progresspie0'),
                            percent = parseInt($ppc.data('percent'));

                            if(percent>100){
                                percent=100;
                            }

                            var deg = 360*percent*2/100;

                            if (percent*2 > 100) {
                              $ppc.addClass('gt-50');
                            }
                            $('#progressppc0').css('transform','rotate('+ deg +'deg)');
                            $('#porcentajeav0').html(''+(parseFloat(totalpercent)).toFixed(2)+'%');

                            document.getElementById('cargandometa').style.display = "none";

                            $.ajax({
                                type: 'POST',
                                url: 'crl/metaCRL.php',
                                data: {action: 'getMetaByMesByAnioByTienda', idtienda: tiendaaa, anio: aniosel, mes: (messel-1)},
                                success: function (meta) {
                                    //alert(meta);
                                    var mesnext=messel;
                                    var anionex=aniosel;

                                    var mesb = "";
                                    messel=messel-1;
                                    if((messel)<1){
                                        messel=12;
                                        aniosel=aniosel-1;
                                    }

                                    if((messel)<10){
                                        mesb="0"+(messel);
                                    }else{
                                        mesb=messel;
                                    }
                                    //alert("tienda: "+tiendaaa);
                                    //alert("mesb: "+mesb);
                                    //alert("anio: "+aniosel);
                                    $.ajax({
                                        type: 'POST',
                                        url: 'crl/metaCRL.php',
                                        data: {action: 'TotalIngresosByFecha', tienda: tiendaaa, anio: aniosel, mes: mesb},
                                        success: function (data) {
                                            var lista = JSON.parse(data);
                                            //alert(data);
                                            //for (var i = 0; i < lista.length; i++) {
                                                //totalingresos = totalingresos + parseFloat(lista[i].efectivo) + parseFloat(lista[i].tarjeta);
                                            //}
                                            totali=lista[0].acuenta;

                                            //$('#totalUtilidades').val((totali-totalg).toFixed(2));

                                            var totalpercent=0;

                                            if(meta>0){
                                                //alert(totali + " " + meta);
                                                totalpercent = totali*100/meta;
                                            }
                                            document.getElementById("divProgress1").innerHTML=''
                                                +'<span onclick="nextMeta('+anionex+', '+mesnext+');" id="btnSig" class="icon-atras" style="position: absolute;top: 37px;right: 3px; cursor: pointer;transform: rotate(180deg);"></span>'
                                                +'<div id="progresspie1" class="progress-pie-chart" data-percent="'+totalpercent+'" style="display: inline-block;float: left;">'
                                                    +'<div class="ppc-progress">'
                                                      +'<div class="ppc-progress-fill" id="progressppc1"></div>'
                                                    +'</div>'
                                                    +'<div class="ppc-percents">'
                                                      +'<div class="pcc-percents-wrapper">'
                                                        +'<span id="porcentajeav1">%</span>'
                                                       +'</div>'
                                                    +'</div>'
                                                +'</div>'
                                                +'<div style="float: right;width: 160px;height: 210px;display: inline-block;text-align: left;">'
                                                +'<div style="font-size: 19px;">'
                                                +'<span>Ventas</span><br/><br/>'
                                                +'<span style="color: rgb(15, 104, 211);">Total: '+lista[0].total+'</span><br/><br/>'
                                                +'<span style="color: rgb(30, 165, 46);">A cuenta: '+totali+'</span><br/><br/>'
                                                +'<span style="color: rgb(229, 74, 74);">Saldo: '+lista[0].saldo+'</span>'
                                                +'</div>'
                                                +'</div>'
                                                +'<div style="display: inline-block;margin-top: 10px;">'
                                                +'<span style="font-size: 19px;">Meta: '+meta+'</span>'
                                                +'</div>';
                                                //+'<div style="display: inline-block;margin-top: 10px;">'
                                                //+'<span style="font-size: 19px;">Venta del día: '+totaldia+'</span>'
                                                //+'</div>'

                                            var $ppc = $('#progresspie1'),
                                            percent = parseInt($ppc.data('percent'));

                                            if(percent>100){
                                                percent=100;
                                            }

                                            var deg = 360*percent*2/100;

                                            if (percent*2 > 100) {
                                              $ppc.addClass('gt-50');
                                            }
                                            $('#progressppc1').css('transform','rotate('+ deg +'deg)');
                                            $('#porcentajeav1').html(''+(parseFloat(totalpercent)).toFixed(2)+'%');

                                            document.getElementById('cargandometa').style.display = "none";
                                        },
                                        error: function () {
                                            document.getElementById('cargandometa').style.display = "none";
                                        }
                                    });
                                }
                            });
                        },
                        error: function () {
                            document.getElementById('cargandometa').style.display = "none";
                        }
                    });
                }
            });
        }

        function previousMeta(anioenv, mesenv){
            $('#divDateMeta').html("REPORTE DE METAS: " + getMesName(parseInt(mesenv)) + " - " + anioenv);
            document.getElementById("divProgress1").style.display = 'block';
            document.getElementById("divProgress0").style.display = 'none';
        }

        function nextMeta(anioenv, mesenv){
            $('#divDateMeta').html("REPORTE DE METAS: " + getMesName(parseInt(mesenv)) + " - " + anioenv);
            document.getElementById("divProgress0").style.display = 'block';
            document.getElementById("divProgress1").style.display = 'none';
        }

        function getMesName(mes){
            switch(mes){
                case 1: return "Enero"; break;
                case 2: return "Febrero"; break;
                case 3: return "Marzo"; break;
                case 4: return "Abril"; break;
                case 5: return "Mayo"; break;
                case 6: return "Junio"; break;
                case 7: return "Julio"; break;
                case 8: return "Agosto"; break;
                case 9: return "Setiembre"; break;
                case 10: return "Octubre"; break;
                case 11: return "Noviembre"; break;
                case 12: return "Diciembre"; break;
            }
        }
<?php
    }else{
?>
    function closeAlertas(){
    }

    function loadAlerts() {


    }
    function loadMensajesByTienda() {

    }
<?php
    }
?>

</script>
</body>
</html>
<?php
    } else {
        header("Location: login.php");
    }
} else {
    header("Location: login.php");
}
?>


<?php

//SOCKETS PRUEBA

// prevent the server from timing out
set_time_limit(0);

// include the web sockets server script (the server is started at the far bottom of this file)
require 'clases/class.PHPWebSocket.php';

// when a client sends data to the server
function wsOnMessage($clientID, $message, $messageLength, $binary)
{
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	// check if message length is 0
	if ($messageLength == 0) {
		$Server->wsClose($clientID);
		return;
	}

	//The speaker is the only person in the room. Don't let them feel lonely.
	if ( sizeof($Server->wsClients) == 1 )
		$Server->wsSend($clientID, "");
	else
		//Send the message to everyone but the person who said it
		foreach ( $Server->wsClients as $id => $client )
			//if ( $id != $clientID )
				//$Server->wsSend($id, "Visitor $clientID ($ip) said \"$message\"");
				//aqui recibimos la accion con los demas parametros e identificadores
				$Server->wsSend($id,$message);
}

// when a client connects
function wsOnOpen($clientID)
{
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	$Server->log( "" );

	//Send a join notice to everyone but the person who joined
	foreach ( $Server->wsClients as $id => $client )
		if ( $id != $clientID )
			$Server->wsSend($id, "");
}

// when a client closes or lost connection
function wsOnClose($clientID, $status) {
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	$Server->log( "" );

	foreach ( $Server->wsClients as $id => $client )
		$Server->wsSend($id, "");
}

$Server = new PHPWebSocket();
$Server->bind('message', 'wsOnMessage');
$Server->bind('open', 'wsOnOpen');
$Server->bind('close', 'wsOnClose');

$Server->wsStartServer('209.217.245.186',80);
// $Server->wsStartServer('50.87.202.215',80);
//$Server->wsStartServer('192.168.0.22',80);

?>
