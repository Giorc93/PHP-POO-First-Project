<?php require_once DIR.'views/headerView.php'; ?>
<?php $stats = Utils::shopCartStats(); ?>
<!--Bloque Principal-->
<div id="content">
    <!--Barra Lateral-->
    <?php require_once DIR.'views/sideBarView.php'; ?>
    <!--Contenido Central-->
    <div id="container">
        <h2>Tu Carrito de Compra</h2>
        <hr>
        <?php if (isset($_SESSION['cartAlert'])): ?>
        <center>
            <p class="alertC"><?=$_SESSION['cartAlert'];?>
            </p>
        </center>
        <?php endif; ?>
        <?php if (isset($_SESSION['orderAlert'])): ?>
        <center>
            <p class="alertC"><?=$_SESSION['orderAlert'];?>
            </p>
        </center>
        <?php endif; ?>
        <?php if (isset($_SESSION['shopCart'])): ?>
        <table id="shopCartTable">
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio Unidad</th>
                <th>Descuento</th>
                <th>Unidades</th>
                <th>Stock Disp</th>
                <th>Total</th>
            </tr>
            <?php foreach ($_SESSION['shopCart'] as $prod): ?>
            <?php if ($prod['undToBuy'] >= 1): ?>
            <tr>
                <td><img src="http://localhost/master-php/uploads/prodImg/<?=$prod['prodImg']?>"
                        alt="">
                </td>
                <td><a
                        href="<?=URL?>products/getProdByIdC/<?=$prod['prodId']?>"><?=$prod['prodName']; ?></a>
                </td>
                <td>$ <?=$prod['prodPrice']; ?>
                    COP
                </td>
                <td><?=$prod['prodDisc']; ?>%
                </td>
                <td><a
                        href="<?=URL?>shopCart/modProdUnitsC/<?=$prod['prodId'] ?>/0">-</a><?=$prod['undToBuy'] ?><a
                        href="<?=URL?>shopCart/modProdUnitsC/<?=$prod['prodId'] ?>/1">+</a>
                </td>
                <td>
                    <?=$prod['prodDet']['stock']?>
                </td>
                <td>$ <?=((($prod['prodPrice']-($prod['prodPrice']*($prod['prodDisc']/100))))*$prod['undToBuy']) ?>
                    COP
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="7"><strong>Total Compra: $ <?=$stats['shopCartTot'];?> COP
                    </strong></td>
            </tr>
        </table>
        <br>
        <a href="<?=URL?>orders/setOrderInfC"
            class="confirmBttn">Confirmar
            Pedido</a>
        <?php endif; ?>
    </div>
</div>
<?php Utils::dropSession('cartAlert') ?>
<?php Utils::dropSession('orderAlert') ?>
<?php require_once DIR.'views/footerView.php';
