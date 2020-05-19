<?php require_once DIR.'views/headerView.php'; ?>
<!--Bloque Principal-->
<div id="content">
    <!--Barra Lateral-->
    <?php require_once DIR.'views/sideBarView.php'; ?>
    <!--Contenido Central-->
    <div id="container">
        <h2>Información de Envío</h2>
        <hr>
        <br>
        <?php if (isset($_SESSION['orderAlert'])): ?>
        <?php if (isset($_SESSION['orderDetail'])):  ?>
        <h3>Detalles de la Orden</h3>
        <ul id="orderDetailList">
            <li>
                <h4>ID Pedido:</h4> <?=$_SESSION['orderDetail'][0]['pedido_id']?>

            </li>
            <li>
                <h4>Total Compra:</h4> $ <?=$_SESSION['orderDetail'][0]['total_pedido']?>
                COP

            </li>
            <li>
                <h4>Fecha:</h4> <?=$_SESSION['orderDetail'][0]['fecha']?>

            </li>
            <li>
                <h4>Productos:</h4>
                <?php foreach ($_SESSION['orderDetail'] as $orderProd): ?>
                <?=$orderProd['nombre']?> x
                <?=$orderProd['unidades']?>
                Und<br>
                <?php endforeach; ?>
            </li>
        </ul>
        <?php endif; ?>
        <center>
            <p class="alertC"><?=$_SESSION['orderAlert'];?>
            </p>
        </center>
        <?php else: ?>
        <form id="orderInf" action="<?=URL?>orders/sendOrderC"
            method="POST">
            <label for="dept">Departamento: </label>
            <input type="text" name="dept" required pattern="[A-Za-z]+" title="Ingresa el departamento">
            <label for=" muncp">Municipio: </label>
            <input type="text" name="muncp" required pattern="[A-Za-z]+" title="Ingresa el municipio">
            <label for=" addr">Dirección: </label>
            <input type="text" name="addr" required pattern="[A-Za-z0-9 #-]+" title="Ingresa la direacción">
            <input type="submit" value="Confirmar Información" class="confirmBttn">
        </form>
        <?php endif; ?>
    </div>
</div>
<?php Utils::dropSession('orderAlert')?>
<?php Utils::dropSession('orderDetail')?>
<?php require_once DIR.'views/footerView.php';
