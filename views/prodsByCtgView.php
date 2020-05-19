<?php require_once DIR.'views/headerView.php'; ?>
<?php $ctgProducts = $this->ctgProducts; ?>
<?php $ctgName = Utils::getCtgNameByIdU($_SESSION['ctgId']); ?>

<!--Bloque Principal-->
<div id="content">
    <!--Barra Lateral-->
    <?php require_once DIR.'views/sideBarView.php'; ?>
    <!--Contenido Central-->
    <div id="container">
        <h2><?=strtoupper($ctgName)?>
        </h2>
        <hr>
        <?php if (isset($_SESSION['showProd'])): ?>
        <center>
            <p class="alertC"><?=$_SESSION['showProd'];?>
            </p>
        </center>
        <?php endif; ?>
        <?php foreach ($ctgProducts as $prod): ?>
        <?php if ($prod['stock'] > 0): ?>
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
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
<?php Utils::dropSession('showProd') ?>
<?php Utils::dropSession('ctgId') ?>
<?php require_once DIR.'views/footerView.php';
