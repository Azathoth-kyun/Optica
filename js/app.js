//document.oncontextmenu = function () {
//    return false
//}

$('.sidebar .item a').click(function () {
    $('.sidebar .item a').removeClass("sombra");
    $(this).addClass("sombra");
    $(this).parent().children('.subitem').slideToggle('slow');
    if ($(this).children('span').hasClass('icon-cerrado')) {
        $(this).parent().parent().find('.icon-abierto').parent().parent().children('.subitem').slideToggle('slow');
        $(this).parent().parent().find('.icon-abierto').addClass('icon-cerrado');
        $(this).parent().parent().find('.icon-abierto').removeClass('icon-abierto');
        $(this).children('span').removeClass('icon-cerrado');
        $(this).children('span').addClass('icon-abierto');
    } else {
        $('.sidebar .item a').removeClass("sombra");
        $(this).children('span').removeClass('icon-abierto');
        $(this).children('span').addClass('icon-cerrado');
    }
});
$('.loading').html('<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>');
$('.loadone').html('<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>');
$('.optometra').html('<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>');
function $_GET(param) {
    url = document.URL;
    url = String(url.match(/\?+.+/));
    url = url.replace("?", "");
    url = url.split("&");
    x = 0;
    while (x < url.length)
    {
        p = url[x].split("=");
        if (p[0] == param)
        {
            return decodeURIComponent(p[1]);
        }
        x++;
    }
}
function getUN() {
    var rnom = nombreUser;
    return rnom;
}
function hora() {
    var fecha = new Date();
    var hora = fecha.getHours();
    var minuto = fecha.getMinutes();
    var meridiano = " am";
    if (hora > 12) {
        hora -= 12;
        meridiano = " pm";
    }
    if (hora < 10) {
        hora = "0" + hora;
    }
    if (minuto < 10) {
        minuto = "0" + minuto;
    }
    return (hora + ':' + minuto + meridiano);
}
function horaG() {
    var fecha = new Date();
    var hora = fecha.getHours();
    var minuto = fecha.getMinutes();
    if (hora < 10) {
        hora = "0" + hora;
    }
    if (minuto < 10) {
        minuto = "0" + minuto;
    }
    return (hora + ':' + minuto);
}
function descFec(fec) {
    var afec = fec.split("-");
    var f = new Date(afec[0], (afec[1] - 1), afec[2]);
    //alert(f+"k"+fec);
    var options = {weekday: "long", month: "long", day: "numeric"};
    return(f.toLocaleDateString("es-ES", options));
}
function fecha() {
    var f = new Date();
    var dia = f.getDate();
    var mes = f.getMonth() + 1;
    var anio = f.getFullYear();
    if (dia < 10) {
        dia = "0" + dia;
    }
    if (mes < 10) {
        mes = "0" + mes;
    }
    return (dia + '/' + mes + '/' + anio);
}
function toFecha(fec) {
    var afec = fec.split("-");
    var f = new Date(afec[0], (afec[1] - 1), afec[2]);
    var dia = f.getDate();
    var mes = f.getMonth() + 1;
    var anio = f.getFullYear();
    if (dia < 10) {
        dia = "0" + dia;
    }
    if (mes < 10) {
        mes = "0" + mes;
    }
    return (dia + '/' + mes + '/' + anio);
}
function fechaG() {
    var f = new Date();
    var dia = f.getDate();
    var mes = f.getMonth() + 1;
    var anio = f.getFullYear();
    if (dia < 10) {
        dia = "0" + dia;
    }
    if (mes < 10) {
        mes = "0" + mes;
    }
    return (anio + '-' + mes + '-' + dia);
}
function toFechaG(fec) {
    var afec = fec.split("/");
    var f = new Date(afec[2], (afec[1] - 1), afec[0]);
    var dia = f.getDate();
    var mes = f.getMonth() + 1;
    var anio = f.getFullYear();
    if (dia < 10) {
        dia = "0" + dia;
    }
    if (mes < 10) {
        mes = "0" + mes;
    }
    return (anio + '-' + mes + '-' + dia);
}
function estoyEnUnIframe() {
    var insideIframe = window.top !== window.self;
    if (!insideIframe) {
        location.href = '../main.php';
    }
}
function logout() {
    $.ajax({
        type: 'POST',
        url: 'crl/usuarioCRL.php',
        data: {
            action: 'logout'
        },
        success: function () {
            location.href = "login.php";
        },
        error: function () {
            NewNotify('red', 'Error en el sistema', 'Por favor vuelva a intentarlo', 3000, 'white');

        }
    });
}
function resizeModal(w, h) {
    $('#Modal').css('height', h + 'px');
    $('#Modal').css('width', w + 'px');
}
function openModal(ventana) {
    closeAlertas();
    loadAlerts();
    var time = new Date().getTime();

    if ($('#Modal').is(":visible")){
        closeModal();
        setTimeout(function () {
            $('#Modal').css("display","block");
        },500);
    } else {
        $('#Modal').css("display","block");
    }

    $('#modalIframe').attr('src', '');

    switch (ventana) {
        case 'users':
            $('#modalTitulo').html('Registro de Usuarios');
            $('#modalIframe').attr('src', 'modulos/users.html?time=' + time);
            $('#Modal').css('height', '465px');
            $('#Modal').css('width', '700px');
            break;
        case 'proveedores':
            $('#modalTitulo').html('Registro de Proveedores');
            $('#modalIframe').attr('src', 'modulos/proveedor.html?time=' + time);
            $('#Modal').css('height', '580px');
            $('#Modal').css('width', '1000px');
            break;
        case 'monturas':
            $('#modalTitulo').html('Módulo de Monturas / Armazones');
            $('#modalIframe').attr('src', 'modulos/monturas.html?time=' + time);
            $('#Modal').css('height', '359px');
            $('#Modal').css('width', '800px');
            break;
        case 'productos':
            $('#modalTitulo').html('Módulo de Productos');
            $('#modalIframe').attr('src', 'modulos/productos.html?time=' + time);
            $('#Modal').css('height', '430px');
            $('#Modal').css('width', '900px');
            break;
        case 'ingreso':
            $('#modalTitulo').html('Ingreso de Monturas / Armazones');
            $('#modalIframe').attr('src', 'modulos/detalleingreso.html?time=' + time);
            $('#Modal').css('height', '580px');
            $('#Modal').css('width', '1042px');
            break;
        case 'detallegastoventa2':
            $('#modalTitulo').html('Lista de Pedidos');
            $('#modalIframe').attr('src', 'modulos/detallegastoventa.html?time=' + time);
            $('#Modal').css('height', '700px');
            $('#Modal').css('width', '1400px');
            break;
        case 'ingresoProd':
            $('#modalTitulo').html('Ingreso de Productos');
            $('#modalIframe').attr('src', 'modulos/detalleingresoProd.html?time=' + time);
            $('#Modal').css('height', '580px');
            $('#Modal').css('width', '1000px');
            break;
        case 'tiendas':
            $('#modalTitulo').html('Registro de Tiendas en Suscripción');
            $('#modalIframe').attr('src', 'modulos/tiendas.html?time=' + time);
            $('#Modal').css('height', '515px');
            $('#Modal').css('width', '1082px');
            break;
        case 'inventario':
            $('#modalTitulo').html('Módulo de Inventarios');
            $('#modalIframe').attr('src', 'modulos/inventario.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '660px');
            $('#Modal').css('width', '1180px');
            break;
        case 'inventarioT':
            $('#modalTitulo').html('Inventario de Tienda');
            $('#modalIframe').attr('src', 'modulos/inventario.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '660px');
            $('#Modal').css('width', '1180px');
            break;
        case 'inventarioP':
            $('#modalTitulo').html('Inventario de Productos');
            $('#modalIframe').attr('src', 'modulos/inventarioProd.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '580px');
            $('#Modal').css('width', '1000px');
            break;
        case 'inventarioPT':
            $('#modalTitulo').html('Inventario de Productos');
            $('#modalIframe').attr('src', 'modulos/inventarioProd.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '580px');
            $('#Modal').css('width', '1000px');
            break;
        case 'movimientoProd':
            $('#modalTitulo').html('Envio de Productos');
            $('#modalIframe').attr('src', 'modulos/movimientoP.html?time=' + time);
            $('#Modal').css('height', '635px');
            $('#Modal').css('width', '800px');
            break;
        case 'movimiento':
            $('#modalTitulo').html('Envios de Monturas/Armazones a Ópticas');
            $('#modalIframe').attr('src', 'modulos/movimiento.html?time=' + time);
            $('#Modal').css('height', '635px');
            $('#Modal').css('width', '800px');
            break;
        case 'movimientosinfacturacion':
            $('#modalTitulo').html('Movimiento de Monturas/Armazones Sin Facturación');
            $('#modalIframe').attr('src', 'modulos/movimientosinfacturacion.html?time=' + time);
            $('#Modal').css('height', '635px');
            $('#Modal').css('width', '860px');
            break;
        case 'Ringreso':
            $('#modalTitulo').html('Reporte de ingresos a almacen');
            $('#modalIframe').attr('src', 'modulos/ingreso.html?time=' + time);
            $('#Modal').css('height', '608px');
            $('#Modal').css('width', '1300px');
            break;
        case 'alta':
            $('#modalTitulo').html('Alta de Monturas');
            $('#modalIframe').attr('src', 'modulos/movimiento.html?alta=true&ti=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '640px');
            $('#Modal').css('width', '1000px');
            break;
        case 'altaP':
            $('#modalTitulo').html('Alta de Productos');
            $('#modalIframe').attr('src', 'modulos/movimientoP.html?alta=true&ti=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '640px');
            $('#Modal').css('width', '1000px');
            break;
        case 'inter':
            $('#modalTitulo').html('Busqueda de Monturas por Modelo');
            $('#modalIframe').attr('src', 'modulos/intertienda.html?time=' + time);
            $('#Modal').css('height', '495px');
            $('#Modal').css('width', '1020px');
            break;
        case 'anular':
            $('#modalTitulo').html('Anular Venta');
            $('#modalIframe').attr('src', 'modulos/anular.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '310px');
            $('#Modal').css('width', '520px');
            break;
        case 'masivo':
            $('#modalTitulo').html('Cambio de Precio Mínimo de Monturas/Armazones');
            $('#modalIframe').attr('src', 'modulos/masivo.html?time=' + time);
            $('#Modal').css('height', '310px');
            $('#Modal').css('width', '520px');
            break;
        case 'dia':
            $('#modalTitulo').html('Reporte Diario de Caja');
            $('#modalIframe').attr('src', 'modulos/dia.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '645px');
            $('#Modal').css('width', '1262px');
            break;
        case 'ventac':
            $('#modalTitulo').html('Punto de Venta');
            $('#modalIframe').attr('src', 'modulos/ventas.html?time=' + time);
            $('#Modal').css('height', '615px;');
            $('#Modal').css('width', '1150px');
            break;
        case 'medicion':
            $('#modalTitulo').html('Módulo Medición');
            $('#modalIframe').attr('src', 'modulos/medicion.html?time=' + time);
            $('#Modal').css('height', '682px');
            $('#Modal').css('width', '800px');
            break;
        case 'historial':
            $('#modalTitulo').html('Historial de Medición');
            $('#modalIframe').attr('src', 'modulos/historial.html?time=' + time);
            $('#Modal').css('height', '595px');
            $('#Modal').css('width', '800px');
            break;
        case 'buscarVenta':
            $('#modalTitulo').html('Buscar por Código');
            $('#modalIframe').attr('src', 'modulos/buscarVenta.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '150px');
            $('#Modal').css('width', '280px');
            break;
        case 'buscarMontura':
            $('#modalTitulo').html('Buscar Montura por Código');
            $('#modalIframe').attr('src', 'modulos/historialmovimientom.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '520px');
            $('#Modal').css('width', '800px');
            break;
        case 'ri':
            $('#modalTitulo').html('Reporte de Ventas');
            $('#modalIframe').attr('src', 'modulos/reporteIngresos.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '650px');
            $('#Modal').css('width', 'calc(90% - 38px)');
            break;
        case 'reporteflujocaja':
            $('#modalTitulo').html('Reporte de Flujo de Caja');
            $('#modalIframe').attr('src', 'modulos/reporteFlujoCaja.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '650px');
            $('#Modal').css('width', 'calc(90% - 38px)');
            break;
        case 'rc':
            $('#modalTitulo').html('Reporte por Comprobante');
            $('#modalIframe').attr('src', 'modulos/reporteComprobantes.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '650px');
            $('#Modal').css('width', 'calc(90% - 38px)');
            break;
        case 'rbet':
            $('#modalTitulo').html('Reporte de Ingresos Por Boleta');
            $('#modalIframe').attr('src', 'modulos/reporteXBoleta.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '650px');
            $('#Modal').css('width', 'calc(90% - 38px)');
            break;
        case 'gastosOpByTienda':
            $('#modalTitulo').html('Modulo de Gastos Operativos');
            $('#modalIframe').attr('src', 'modulos/gastosOperativos.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '600px');
            $('#Modal').css('width', '855px');
            break;
        case 'sendMensajes':
            $('#modalTitulo').html('Mensajes a Tienda');
            $('#modalIframe').attr('src', 'modulos/sendMensajes.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '600px');
            $('#Modal').css('width', '675px');
            break;
        case 'registroMetas':
            $('#modalTitulo').html('Registro de Metas');
            $('#modalIframe').attr('src', 'modulos/registrometas.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '440px');
            $('#Modal').css('width', '900px');
            break;
        case 'informeMetas':
            $('#modalTitulo').html('Informe de Metas');
            $('#modalIframe').attr('src', 'modulos/informeMetas.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '490px');
            $('#Modal').css('width', '900px');
            break;
        case 'gastosOpByAdmin':
            $('#modalTitulo').html('Modulo de Gastos Operativos');
            $('#modalIframe').attr('src', 'modulos/gastosOperativosAdmin.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '600px');
            $('#Modal').css('width', '855px');
            break;
        case 'mantenedorTiposGasto':
            $('#modalTitulo').html('Tipos de Gasto');
            $('#modalIframe').attr('src', 'modulos/mantenedortiposgasto.html?time=' + time);
            $('#Modal').css('height', '465px');
            $('#Modal').css('width', '693px');
            break;
        case 'mantenedorlaboratorio':
            $('#modalTitulo').html('Laboratorios');
            $('#modalIframe').attr('src', 'modulos/mantenedorlaboratorio.html?time=' + time);
            $('#Modal').css('height', '545px');
            $('#Modal').css('width', '555px');
            break;
        case 'reporteDeGastos':
            $('#modalTitulo').html('Reporte de Gastos');
            $('#modalIframe').attr('src', 'modulos/reportedegastos.html?time=' + time);
            $('#Modal').css('height', '550px');
            $('#Modal').css('width', '1225px');
            break;
        case 'reporteDeGastosTienda':
            $('#modalTitulo').html('Reporte de Gastos');
            $('#modalIframe').attr('src', 'modulos/reportedegastostienda.html?time=' + time);
            $('#Modal').css('height', '550px');
            $('#Modal').css('width', '1225px');
            break;
        case 'movimientoMonturas':
            $('#modalTitulo').html('Módulo de Traslado de Monturas');
            $('#modalIframe').attr('src', 'modulos/movimientomonturas.html?time=' + time);
            $('#Modal').css('height', '310px');
            $('#Modal').css('width', '520px');
            break;
        case 'movimientoMonturasTienda':
            $('#modalTitulo').html('Movimiento de Monturas');
            $('#modalIframe').attr('src', 'modulos/movimientomonturastienda.html?time=' + time);
            $('#Modal').css('height', '310px');
            $('#Modal').css('width', '520px');
            break;
        case 'rvmm':
            $('#modalTitulo').html('Reporte de Venta de Monturas');
            $('#modalIframe').attr('src', 'modulos/ventasMonturas.html?time=' + time);
            $('#Modal').css('height', '660px');
            $('#Modal').css('width', '690px');
            break;
        case 'asicom':
            $('#modalTitulo').html('Asignación de comisión');
            $('#modalIframe').attr('src', 'modulos/asignarcomision.html?time=' + time);
            $('#Modal').css('height', '200px');
            $('#Modal').css('width', '1000px');
            break;
        case 'informecomision':
            $('#modalTitulo').html('Informe de comisión de empleados');
            $('#modalIframe').attr('src', 'modulos/comisioninforme.html?time=' + time);
            $('#Modal').css('height', '500px');
            $('#Modal').css('width', '660px');
            break;
        case 'monturaxmes':
            $('#modalTitulo').html('Informe de monturas desde ingreso');
            $('#modalIframe').attr('src', 'modulos/rmonturaingreso.html?time=' + time);
            $('#Modal').css('height', '450px');
            $('#Modal').css('width', '660px');
            break;
        case 'clienteopto':
            $('#modalTitulo').html('Clientes a Atender');
            $('#modalIframe').attr('src', 'modulos/clienteopto.html?time=' + time);
            $('#Modal').css('height', '330px');
            $('#Modal').css('width', '600px');
            break;
        case 'informecomision2':
            $('#modalTitulo').html('Informe de comisión de empleados por lunas');
            $('#modalIframe').attr('src', 'modulos/comisionlunasinforme.html?time=' + time);
            $('#Modal').css('height', '500px');
            $('#Modal').css('width', '660px');
            break;
        case 'sendopto':
            $('#modalTitulo').html('Enviar cliente al optometra');
            $('#modalIframe').attr('src', 'modulos/sendopto.html?t=' + tiendaUser + '&time=' + time);
            $('#Modal').css('height', '300px');
            $('#Modal').css('width', '600px');
            break;
        case 'salesxvend':
            $('#modalTitulo').html('Reporte de ventas por vendedor');
            $('#modalIframe').attr('src', 'modulos/reporteventasxvendedor.html?time=' + time);
            $('#Modal').css('height', '660px');
            $('#Modal').css('width', '690px');
            break;
        case 'ManageVendedores':
            $('#modalTitulo').html('Configuración de vendedores');
            $('#modalIframe').attr('src', 'modulos/manageVendedores.html?time=' + time);
            $('#Modal').css('height', '505px');
            $('#Modal').css('width', '600px');
            break;
    }
    /*
    $('#Mask').fadeToggle('slow');
    setTimeout(function () {
        $('#Modal').toggle();
    });*/
    document.getElementById('titleh2').style.display="block";
    $('#modalIframe').css('height', 'calc(100% - 15px)');
    $('#modalIframe').css('padding-top', '36px');
    $('#modalIframe').css('border-radius', '9px');
}

function ChangeModalTittle(codigo, tienda){
    $('#modalTitulo').html('Buscar por codigo: '+ codigo +' / Tienda: '+ tienda);
}

function ChangeModalTittleTexto(texto){
    $('#modalTitulo').html(texto);
}

function cargarpanelconfig(){
    $('#modalIframe').css('height', 'height: calc(100% + 7px)');
    $('#modalIframe').css('padding-top', '0px');
    $('#modalIframe').css('border-radius', '9px');
}

function formatoTabla(width) {
    $('.datatable tr td').css('width', width);
    $('.idCol').css('width', ('30px'));
    $('.ColXX').css('width', ('250px'));
    $('.ColMM').css('width', ('50px'));
    $('.ColMMM').css('width', ('65px'));
    $('.ColMS').css('width', ('30px'));
    $('.ColXXX').css('width', ('350px'));
    $('.ColXXXX').css('width', ('430px'));
    $('.ColXXXXM').css('width', ('482px'));
    $('.ColXXXMM').css('width', ('460px'));
    $('.ColXXXXX').css('width', ('630px'));
    $('.ColWC').css('width', ('65px'));
    $('.ColWP').css('width', ('75px'));
    $('.ColWI').css('width', ('75px'));
    $('.ColWA').css('width', ('30px'));
    $('.ColM').css('width', ('160px'));
    $('.ColSM').css('width', ('87px'));
    $('.ColXS').css('width', ('20px'));
    $('.ColFS').css('width', ('90px'));
    $('.ColOH').css('width', ('100px'));
    $('.ColOH2').css('width', ('110px'));
    $('.ColMA').css('width', ('200px'));
    //$('.ColXXXXMM').css('width', ('567'));
}
function closeModal() {
    $('#Modal').css("display","none");
    $('#modalIframe').attr('src', '');
}
function hiddenWindowTittle() {
    document.getElementById('titleh2').style.display="none";
    $('#modalIframe').css("height", 'calc(100% + 7px)');
}
function msgError(mensaje, color) {
    $('.msg').html(mensaje);
    $('.msg').css("background", color);
    //$('.msg').css("display", "block");
    $('.msg').fadeIn(100);
    setTimeout(function () {
        //$('.msg').css("display", "none");
        $('.msg').fadeOut(400);
    }, 2000);
}
function msgError3(mensaje, color) {
    $('.msg3').html(mensaje);
    $('.msg3').css("background", color);
    //$('.msg3').css("display", "block");
    $('.msg3').fadeIn(100);
}
function toDouble(num) {
    var out = (parseFloat(num)).toFixed(2);
    return out;
}
function toInt(num) {
    var patron = /^\d*$/;
    if (patron.test(num)) {
        return parseInt(num);
    } else {
        return '0';
    }
}
function cargando() {
    $(".preload").css("display", "none");
    $(".preload-img").css("display", "none");
}
String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
};
function changeTitle(text) {
    $('#modalTitulo').html(text);
}