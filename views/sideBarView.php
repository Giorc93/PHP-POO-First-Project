<?php $stats = Utils::shopCartStats(); ?>
<div id="aside">
    <div id="login" class="blockaside">
        <?php if (isset($_SESSION['userId'])): ?>
        <center><img
                src="http://localhost/master-php/uploads/<?=$_SESSION['userId']['imagen']?>"
                alt="profilePic" class="profilePic">
        </center>
        <div class="name">¡Bienvenid@ <?=$_SESSION['userId']['nombre'];?>!
        </div>
        <a href=" <?=URL?>users/userLogout">Cerrar
            Sesión</a>
        <hr>
        <?php else: ?>
        <?php if (isset($_SESSION['error'])): ?>
        <p class="alert"><?=$_SESSION['error']?>
        </p>
        <?php Utils::dropSession('error') ?>
        <?php endif; ?>
        <form action="<?=URL?>users/userLogin" method="POST">
            <label for="email">Usuario</label>
            <img class="vectorInput"
                src="<?=URL?>public/img/uservector.png" />
            <input type="email" name="email" required placeholder="E-Mail"><br>
            <label for="password">Contraseña</label>
            <img class="vectorInput"
                src="<?=URL?>public/img/passvector.png" />
            <input type="password" name="passw" required placeholder="********" />
            <input type="submit" value="Ingresar" class="inputbtn" />
        </form>
        <br>
        <hr>
        <?php endif; ?>
    </div>
    <div id="cartAside" class="blockaside">
        <ul>
            <li>
                <p>Elementos en el Carrito: <?=$stats['shopCartUnt']; ?>
                </p>
            </li>
            <li>
                <p>Total de la Compra: $ <?=$stats['shopCartTot']; ?> COP
                </p>
            </li>
            <li><a href="<?=URL?>shopCart/prodsFromCart">Ver
                    Carrito</a></li>
        </ul>
    </div>
    <hr>
    <div id="linksaside" class="blockaside">
        <ul>
            <?php if (!isset($_SESSION['userId'])): ?>
            <li>
                <p class="center">¿Aún no tienes una cuenta?</p>
                <a href="<?=URL?>users/registerForm"
                    class="center">¡Registrate!</a>
            </li>
            <?php endif; ?>
            <?php if (isset($_SESSION['userId'])): ?>
            <li>
                <a
                    href="<?=URL?>orders/getOrdersByUserC/<?=$_SESSION['userId']['id']?>">Mis
                    Pedidos</a>
            </li>
            <hr>
            <?php if ($_SESSION['userId']['roll'] == 'admin'): ?>
            <li>
                <p style="font-size:24px;">Opciones de Administración</p>
            </li>
            <li>
                <a href="<?=URL?>orders/getOrdersC">Gestionar
                    Pedidos</a>
            </li>
            <li>
                <a href="<?=URL?>products/prodMngmt">Gestionar
                    Productos</a>
            </li>
            <li>
                <a href="<?=URL?>categories/showCategories">Gestionar
                    Categorias</a>
            </li>
            <?php endif; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>