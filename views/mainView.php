<?php require_once DIR.'views/headerView.php'; ?>
<?php $lastProds = Utils::lastProdU(); ?>

<!--Bloque Principal-->
<div id="content">
    <!--Barra Lateral-->
    <?php require_once DIR.'views/sideBarView.php'; ?>
    <!--Contenido Central-->
    <div id="container">
        <h2>ÚLTIMOS PRODUCTOS</h2>
        <hr>
        <?php foreach ($lastProds as $prod): ?>
        <div class="product">
            <img
                src="http://localhost/master-php/uploads/prodImg/<?=$prod['imagen']?>" />
            <h2><a
                    href="<?=URL?>products/getProdByIdC/<?=$prod['id']?>"><?=$prod['nombre']?>
                </a></h2>
            <p style="color:black">$ <?=$prod['precio']?>
            </p>
            <form
                action="<?=URL?>products/getProdByIdC/<?=$prod['id']?>"
                method="POST">
                <input type="submit" value="Comprar" class="buybtn">
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require_once DIR.'views/footerView.php';
