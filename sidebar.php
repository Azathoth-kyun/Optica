<ul class="sidebar">
    <?php if ($cargo == 'Mensajeria') {
        ?>
            <li class="item">
                <a href="#">Monturas<span class="icon-cerrado"></span></a> 
                <ul class="subitem">
                    <li class="item2n" onclick="openModal('buscarMontura');">
                        <a href="#">Buscar por Código</a>
                    </li>
                </ul>
            </li>
            <li class="item">
                <a href="#">Ventas<span class="icon-cerrado"></span></a> 
                <ul class="subitem">
                    <li class="item2n" onclick="openModal('buscarVenta');">
                        <a href="#">Buscar por Código</a>
                    </li>
                </ul>
            </li>
            <li class="item">
                <a href="#">Pedidos<span class="icon-cerrado"></span></a> 
                <ul class="subitem">
                    <li class="item2n" onclick="openModal('detallegastoventa2');">
                        <a href="#">Pedidos</a>
                    </li>
                </ul>
            </li>
        <?php
        }
    ?>
    <?php
    if ($cargo == 'Administrador') {
        ?>
        <li class="item">
            <a href="#" class="menuTitu">Configuración<span class="icon-cerrado"></span></a>
            <ul class="subitem">
                <li class="item2n" onclick="openModal('tiendas');">
                    <a href="#">Tiendas</a>
                </li >
                <li class="item2n" onclick="openModal('users');">
                    <a href="#">Usuarios</a>
                </li>
                <li class="item2n" onclick="openModal('proveedores');">
                    <a href="#">Proveedores</a>
                </li>
                <li class="item2n" onclick="openModal('mantenedorlaboratorio');">
                    <a href="#">Laboratorios</a>
                </li>
                <li class="item2n" onclick="openModal('ManageVendedores');">
                    <a href="#">Vendedores</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a href="#" class="menuTitu">Monturas/Armazones<span class="icon-cerrado"></span></a> 
            <ul class="subitem">
                <li class="item2n" onclick="openModal('ingreso');">
                    <a href="#">Ingreso de Monturas</a>
                </li>
                <li class="item2n" onclick="openModal('movimiento');">
                    <a href="#">Envios a Óptica</a>
                </li>
                <li class="item2n" onclick="openModal('movimientosinfacturacion');">
                    <a href="#">Movimientos sin facturación</a>
                </li>
                <li class="item2n" onclick="openModal('monturas');">
                    <a href="#">Monturas</a>
                </li>
                <li class="item2n" onclick="openModal('inter');">
                    <a href="#">Busqueda por Modelo</a>
                </li>
                <li class="item2n" onclick="openModal('masivo');">
                    <a href="#">Precio Mínimo</a>
                </li>
                <li class="item2n" onclick="openModal('inventario');">
                    <a href="#">Inventarios</a>
                </li>
                <li class="item2n" onclick="openModal('movimientoMonturas');">
                    <a href="#">Traslado de Monturas</a>
                </li>
                <li class="item2n" onclick="openModal('buscarMontura');">
                    <a href="#">Busqueda de Montura</a>
                </li>
                <li class="item2n" onclick="openModal('monturaxmes');">
                    <a href="#">Tiempo en inventario</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a href="#" class="menuTitu">Productos<span class="icon-cerrado"></span></a> 
            <ul class="subitem">
                <li class="item2n" onclick="openModal('productos');">
                    <a href="#">Registro de Producto</a>
                </li>
                <li class="item2n" onclick="openModal('ingresoProd');">
                    <a href="#">Ingreso de Productos</a>
                </li>
                <li class="item2n" onclick="openModal('movimientoProd');">
                    <a href="#">Envios a Óptica</a>
                </li>
                <li class="item2n" onclick="openModal('inventarioP');">
                    <a href="#">Inventarios</a>
                </li>
                <li class="item2n" onclick="openModal('asicom');">
                    <a href="#">Asignar comisión</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a href="#" class="menuTitu">Ventas<span class="icon-cerrado"></span></a> 
            <ul class="subitem">
                <li class="item2n" onclick="openModal('buscarVenta');">
                    <a href="#">Buscar por Código</a>
                </li>
                <li class="item2n"  onclick="openModal('anular');">
                    <a href="#">Anular Venta</a>
                </li>
                <li class="item2n" onclick="openModal('informecomision');">
                    <a href="#">Informe de Comisiones</a>
                </li>
                <li class="item2n" onclick="openModal('informecomision2');">
                    <a href="#">Informe de Comisiones por Lunas</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a href="#" class="menuTitu">Gastos<span class="icon-cerrado"></span></a> 
            <ul class="subitem">
                <li class="item2n" onclick="openModal('mantenedorTiposGasto');">
                    <a href="#">Tipos de Gasto</a>
                </li>
                <li class="item2n" onclick="openModal('gastosOpByAdmin');">
                    <a href="#">Registrar Gastos</a>
                </li>
                <li class="item2n" onclick="openModal('reporteDeGastos');">
                    <a href="#">Reporte de Gastos</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a href="#">Pedidos<span class="icon-cerrado"></span></a> 
            <ul class="subitem">
                <li class="item2n" onclick="openModal('detallegastoventa2');">
                    <a href="#">Pedidos</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a href="#" class="menuTitu">Reportes<span class="icon-cerrado"></span></a> 
            <ul class="subitem">
                <li class="item2n" onclick="openModal('reporteflujocaja');">
                    <a href="#">Reporte de Flujo de Caja</a>
                </li>
                <li class="item2n" onclick="openModal('ri');">
                    <a href="#">Reporte de Ventas</a>
                </li>
                <li class="item2n" onclick="openModal('rc');">
                    <a href="#">Reporte por Comprobante</a>
                </li>
                <li class="item2n" onclick="openModal('rbet');">
                    <a href="#">Reporte por Boleta</a>
                </li>
                <li class="item2n" onclick="openModal('rvmm'); modalmodelo();">
                    <a href="#">Reporte de Ventas de Modelos</a>
                </li>
                <li class="item2n" onclick="openModal('salesxvend');">
                    <a href="#">Reporte por Vendedores</a>
                </li>
            </ul>
        </li>
        <?php
    }
    if ($cargo == 'Ventas') {
        ?>
        <li class="item">
            <a href="#" class="menuTitu" title="<?php echo $_SESSION['nametienda'];?>" style="white-space:nowrap;overflow:hidden;white-space:nowrap;text-overflow: ellipsis; padding-right: 45px">OPTICA <?php echo $_SESSION['nametienda'];?><span class="icon-cerrado"></span></a> 
            <ul class="subitem">
                <li class="item2n" onclick="openModal('alta');">
                    <a href="#">Alta de Monturas</a>
                </li>
                <li class="item2n" onclick="openModal('altaP');">
                    <a href="#">Alta de Productos</a>
                </li>
                <li class="item2n" onclick="openModal('inventarioT');">
                    <a href="#">Inventario de Monturas</a>
                </li>
                <li class="item2n" onclick="openModal('inventarioPT');">
                    <a href="#">Inventario de Productos</a>
                </li>
                <li class="item2n" onclick="openModal('inter');">
                    <a href="#">Busqueda de modelo</a>
                </li>
                  <li class="item2n" onclick="openModal('gastosOpByTienda');">
                    <a href="#">Gastos en Tienda</a>
                </li>
                <li class="item2n" onclick="openModal('reporteDeGastosTienda');">
                    <a href="#">Reporte de Gastos</a>
                </li>
            </ul>
        </li>
        <?php
    }
    ?>
</ul>

