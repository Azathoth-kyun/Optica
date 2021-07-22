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

        <li  onclick="openModal('dia');">
            <a href="#" class="borde-izquierdo icon-dia2">Día</a>
        </li>

        <li id="desplegar">
            <a href="#" class="icon-desplegar cl-userIz"><?= $_SESSION['minNom']; ?> <?= $_SESSION['minApe']; ?></a><a href="#" class="cl-userDer"><?= strtoupper($_SESSION['cargo']); ?></a>
            <ul class="subnav">
                <li onclick="logout();"><a href="#">Salir</a></li>
            </ul>
        </li>
    </ul>

</nav>