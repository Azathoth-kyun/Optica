<style>
    .cl-mensajeout:after{
        font-size: 13px;
        color: rgba(107, 116, 121, 0.52);
        background-color: rgba(199, 204, 206, 0.4);
        content: "?";
        position: absolute;
        right: 4px;
        top: 5px;
        border-radius: 50%;
        z-index: 1;
        border: 1px solid rgba(147, 163, 171, 0.24);
        padding: 0px 4px;
        font-family: "helvetica";
        text-align: center;
    }
    .cl-mensaje{
        display: none;
        background-color: rgb(28, 206, 213);
        color: white;
        font-size: 14px;
        position: absolute;
        right: -43px;
        top: 68px;
        border-radius: 6px;
        z-index: 10;
        width: 250px;
        
    }
    .cl-mensaje:before{
        content: "";
        width: 0px;
        height: 0px;
        border-top: 0px solid transparent;
        border-right: 10px solid transparent;
        border-left: 10px solid transparent;
        border-bottom: 14px solid rgb(87, 109, 255);
        position: absolute;
        top: -8px;
        right: 44%;
        z-index: -1;
    }
    
    .titleAlerta{
        text-align: center;
        background-color: #576DFF;
        border-radius: 6px 6px 0px 0px;
        padding: 6px 12px;
    }
    .contenidoAlerta{
        border-radius: 6px 6px 0px 0px;
        padding: 6px 12px;
    }
    
.Alert-activa{
    display: inline-block;
    color: white !important;
    position: relative;
    margin-top: 4px;
}

.MsgAlertas{
    width: 303px;
    background-color: #fff;
    position: absolute;
    top: 70px;
    right: -125px;
    z-index: 10;
    border-radius: 10px;
    box-shadow: 0px 6px 17px -3px rgba(0,0,0, 0.25);
    -webkit-animation: bounceInDownAviso 0.75s;
}
-webkit-@keyframes bounceInDownAviso {
    from, 60%, 75%, 90%, to {
      -webkit-animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
      animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
    }
  ​
    0% {
      opacity: 0;
      -webkit-transform: translate3d(0, -3000px, 0);
      transform: translate3d(0, -3000px, 0);
    }
  ​
    60% {
      opacity: 1;
      -webkit-transform: translate3d(0, 25px, 0);
      transform: translate3d(0, 25px, 0);
    }
  ​
    75% {
      -webkit-transform: translate3d(0, -10px, 0);
      transform: translate3d(0, -10px, 0);
    }
  ​
    90% {
      -webkit-transform: translate3d(0, 5px, 0);
      transform: translate3d(0, 5px, 0);
    }
  ​
    to {
      -webkit-transform: none;
      transform: none;
    }
}
.inner-MsgAlertas{
    position: relative;
}
.inner-MsgAlertas::before{
    display: inline-block;
    content: "";
    border-bottom: 10px solid #FF6A6A;
    border-left: 15px solid transparent;
    border-right: 15px solid transparent;
    position: absolute;
    top: -9px;
    left: 50%;
    transform: translate(-50%,0%);
}
.S-cut-Pendientes:hover::before{
    content: "Jugadas Pendientes";
}
.S-cut-Recarga:hover::before{
    left: -40px;
    top: 30px;
    content: "Recarga de Saldo";
}
.S-cut-Recarga:hover::before, .S-cut-Alert:hover::before, .S-cut-Pendientes:hover::before{
    top: -34px;
}
#urlNotiIcon {
    padding: 0px 7px;
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
@-webkit-keyframes bounceInNum {
  from, 20%, 40%, 60%, 80%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
    animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
  }

  0% {
    opacity: 0;
    -webkit-transform: scale3d(.3, .3, .3);
    transform: scale3d(.3, .3, .3);
  }

  20% {
    -webkit-transform: scale3d(1.1, 1.1, 1.1);
    transform: scale3d(1.1, 1.1, 1.1);
  }

  40% {
    -webkit-transform: scale3d(.9, .9, .9);
    transform: scale3d(.9, .9, .9);
  }

  60% {
    opacity: 1;
    -webkit-transform: scale3d(1.03, 1.03, 1.03);
    transform: scale3d(1.03, 1.03, 1.03);
  }

  80% {
    -webkit-transform: scale3d(.97, .97, .97);
    transform: scale3d(.97, .97, .97);
  }

  to {
    opacity: 1;
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1);
  }
}
.Msg-AlertTitle{
    background: #FF6A6A;
    padding: 8px 0px;
    color: #fff;
    width: 100%;
    border-radius: 8px 8px 0px 0px;
}

.Msg-Alert,
.Msg-Alert02{
    width: 100%;
    border-top: 1px solid #eee;
    border-bottom: 1px solid rgba(238, 238, 238, 0);
    padding: 10px 10px;
    box-sizing: border-box;
}
.Msg-Alert02{
    background: #f9f9f9;
}
.Msg-Alert02 h4,
.Msg-Alert h4{
    width: 100%;
    margin: 0px;
    font-size: 1em;
    font-weight: 400;
    color: #555;
}
.Msg-Alert02 p,
.Msg-Alert p{
    font-size: 0.8em;
    color: #9E9E9E;
    margin: 6px 0px;
}
.Msg-Alert02 a,
.Msg-Alert a{
    width: 180px;
}
.btn-Borrar-Alerts{
    width: 100%;
    border-radius: 0px 0px 8px 8px;
    padding: 8px 0px;
    background:#ADADAD;
    color: #fff;
    cursor: pointer;
    display: block;
}
.btn {
  display: inline-block;
  text-decoration: none;
  padding: 7px 0;
  text-align: center;
  color: #fff;
  font-size: 0.9em;
  border-radius: 5px;
}

.btn-rojo-suave:hover {
    background: #13B117;
}
.btn-animate {
  -webkit-transition: all 0.5s;
  transition: all 0.5s;
}

.btn-rojo-suave {
    background: #13A217;
    width: 100% !important;
    box-sizing: border-box;
    padding: 11px 0px !important;
    height: initial !important;
    line-height: initial !important;
    border-radius: 30px;
}
.Msg-Alert, .Msg-Alert02 {
    width: 100%;
    padding: 10px 30px;
    box-sizing: border-box;
    text-align: center;
}
.Msg-AlertTitle {
    background: #FF3131;
    text-align: center;
    text-transform: uppercase;
    padding: 8px 0px 6px 0px;
    color: #fff;
    width: 100%;
    border-radius: 8px 8px 0px 0px;
}
.inner-MsgAlertas::before {
    display: inline-block;
    content: "";
    border-bottom: 10px solid #FF3131;
    border-left: 15px solid transparent;
    border-right: 15px solid transparent;
    position: absolute;
    top: -9px;
    left: 50%;
    transform: translate(-50%,0%);
}
.nroalertas{
    position: absolute;
    top: -20px;
    left: 7px;
}
.divopenal{
    background-color: transparent;
    width: 49px;
    height: 60px;
    position: absolute;
    z-index: 1;
    cursor: pointer;
}
.lialerta{
    float: right !important;
    margin-right: 10px;
}
.lialerta{
    float: right !important; 
    margin-right: 20px;
}
.lialerta:hover{
    background-color: transparent !important;
}

</style>
<style>
    .RepoDate {
        width: 90%;
    }
    .progress-pie-chart {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background-color: #E5E5E5;
        position: relative;
      }
      .progress-pie-chart.gt-50 {
        background-color: #1abc9c;
      }
      .ppc-progress {
        content: "";
        position: absolute;
        border-radius: 50%;
        left: calc(50% - 100px);
        top: calc(50% - 100px);
        width: 200px;
        height: 200px;
        clip: rect(0, 200px, 200px, 100px);
      }
      .ppc-progress .ppc-progress-fill {
        content: "";
        position: absolute;
        border-radius: 50%;
        left: calc(50% - 100px);
        top: calc(50% - 100px);
        width: 200px;
        height: 200px;
        clip: rect(0, 100px, 200px, 0);
        background: #1abc9c;
        transform: rotate(60deg);
      }
      .gt-50 .ppc-progress {
        clip: rect(0, 100px, 200px, 0);
      }
      .gt-50 .ppc-progress .ppc-progress-fill {
        clip: rect(0, 200px, 200px, 100px);
        background: #E5E5E5;
      }

      .ppc-percents {
        content: "";
        position: absolute;
        border-radius: 50%;
        left: calc(50% - 148.91304px/2);
        top: calc(50% - 148.91304px/2);
        width: 148.91304px;
        height: 148.91304px;
        background: #fff;
        text-align: center;
        display: table;
      }
      .ppc-percents span {
        display: block;
        font-size: 2.6em;
        font-weight: bold;
        color: #1abc9c;
      }

      .pcc-percents-wrapper {
        display: table-cell;
        vertical-align: middle;
      }

      body {
        font-family: Arial;
        background: #f7f7f7;
      }

      .progress-pie-chart {
        margin: 0px auto 0;
      }
</style>
<nav>

    <ul class="nav">

        <li class="cl-logoMain">
            <div class="cl-logooptiventas"></div>
        </li>

        <?php
        if ($cargo == 'Ventas') {
            ?>
            <li onclick="openModal('ventac');">
                <a href="#" class="borde-izquierdo-none icon-venta">Ventas</a>
            </li>
            <?php
        }
        ?>
            
        <?php
        
            ?>
            <li  onclick="openModal('dia');">
                <a href="#" class="borde-izquierdo icon-dia2">Día</a>
            </li>
            <?php
        
        ?>
        
        <?php
        if ($cargo == 'Ventas') {
            ?>
            <li onclick="openModal('sendopto');">
                <a href="#" class="borde-izquierdo-none icon-usuario">Enviar</a>
            </li>
            <?php
        }
        ?>

        <?php
        if ($cargo == 'Administrador') {
            ?>
            <li onclick="openModal('sendMensajes');">
                <a href="#" class="borde-izquierdo-none icon-mensajehead">Mensaje</a>
            </li>
            <li onclick="openModal('registroMetas');">
                <a href="#" class="borde-izquierdo-none icon-metas">Metas</a>
            </li>
            <li onclick="openModal('informeMetas');">
                <a href="#" class="borde-izquierdo-none icon-infometas">Informe de Metas</a>
            </li>
            <?php
        }
        ?>
        
        <li id="desplegar">
            <a href="#" class="icon-desplegar cl-userIz"><?= $_SESSION['minNom']; ?> <?= $_SESSION['minApe']; ?></a><a href="#" class="cl-userDer"><?= strtoupper($_SESSION['cargo']); ?></a>
            <ul class="subnav">
                <li onclick="logout();"><a href="#">Salir</a></li>
            </ul>
        </li>
        
        <?php
        if ($cargo == 'Ventas') {
        ?>
            
            
            <li class="lialerta">
                <div id="openalertdiv" class="divopenal" onclick="abrirAlertas();"></div>
                <a href="#" target="ventana_iframe" id="urlNotiIcon" class="S-cut-Alert" onclick="return false;">
                    <span id="alertSi" class="flaticon-notifications Alert-activa" style="display: inline-block;width: 38px;">
                        <div class="Number-Alert" id="rednumalerta" style="display: none;">
                            <div id="nroAlertas" class="nroalertas">
                                
                            </div>
                        </div>
                    </span>
                </a>
                <div class="MsgAlertas" id="divAlertas" style="display: none;">
                    <div class="inner-MsgAlertas" id="listAlertas">
                        <div class="Msg-AlertTitle">Importante</div>
                        <div class="Msg-Alert">
                            <h4>No tiene notificaciones.</h4>
                            <p></p>
                        </div>
                    </div>
                </div>
            </li>
            
            <li class="lialerta" style="margin-right: 0px;">
                <div id="openmensajediv" class="divopenal" onclick="abrirMensajes();"></div>
                <a href="#" target="ventana_iframe" id="urlMensajeIcon" class="S-cut-Alert" onclick="return false;" style="padding: 0px 7px;">
                    <span id="MensajeSi" class="icon-mensajeheadventa Alert-activa" style="display: inline-block;width: 38px;">
                        <div class="Number-Alert" id="rednummensaje" style="display: none;">
                            <div id="nroMensajes" class="nroalertas">
                                
                            </div>
                        </div>
                    </span>
                </a>
                <div class="MsgAlertas" id="divMensajes" style="display: none;">
                    <div class="inner-MsgAlertas" id="listMensajes">
                        <div class="Msg-AlertTitle">MENSAJES</div>
                        <div class="Msg-Alert">
                            <h4>No tiene mensajes.</h4>
                            <p></p>
                        </div>
                    </div>
                </div>
            </li>
            
            <li class="lialerta" style="margin-right: 0px;">
                <div id="openmetasdiv" class="divopenal" onclick="abrirMetas();"></div>
                <a href="#" target="ventana_iframe" id="urlMetasIcon" class="S-cut-Alert" onclick="return false;" style="padding: 0px 7px;">
                    <span id="MetaSi" class="icon-metasventa Alert-activa" style="display: inline-block;width: 38px;">
                        <div class="Number-Alert" id="rednummeta" style="display: none;">
                            <div id="nroMetas" class="nroalertas">
                                
                            </div>
                        </div>
                    </span>
                </a>
                <div class="MsgAlertas" id="divMetas" style="display: none; width: 430px; right: -190px;">
                    <div class="inner-MsgAlertas" id="listMetas">
                        <div class="Msg-AlertTitle" id="divDateMeta">META MES - AÑO</div>
                        <div class="Msg-Alert" id="divProgress">
                            <div id="divProgress1" style="display: none;"></div>
                            <div id="divProgress0"></div>
                            <div id="cargandometa" class="loadone" style="display: block; position: relative; margin-left: 43%;"></div>
                        </div>
                    </div>
                </div>
            </li>
        <?php
        }
        ?>
            
        <?php
            if ($cargo == 'Mensajeria') {
        ?>
                        
            <li class="lialerta">
                <div id="openalertdiv" class="divopenal" onclick="abrirAlertas();"></div>
                <a href="#" target="ventana_iframe" id="urlNotiIcon" class="S-cut-Alert" onclick="return false;">
                    <span id="alertSi" class="flaticon-notifications Alert-activa" style="display: inline-block;width: 38px;">
                        <div class="Number-Alert" id="rednumalerta" style="display: none;">
                            <div id="nroAlertas" class="nroalertas">
                                
                            </div>
                        </div>
                    </span>
                </a>
                <div class="MsgAlertas" id="divAlertas" style="display: none;">
                    <div class="inner-MsgAlertas" id="listAlertas">
                        <div class="Msg-AlertTitle">Importante</div>
                        <div class="Msg-Alert">
                            <h4>No tiene notificaciones.</h4>
                            <p></p>
                        </div>
                    </div>
                </div>
            </li>
            
        <?php
        }
        ?>
    </ul>
</nav>
