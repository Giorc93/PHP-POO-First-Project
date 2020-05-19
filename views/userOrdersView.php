<?php require_once DIR.'views/headerView.php'; ?>
<!--Bloque Principal-->
<div id="content">
    <!--Barra Lateral-->
    <?php require_once DIR.'views/sideBarView.php'; ?>
    <!--Contenido Central-->
    <div id="container">
        <h2>Ordenes Procesadas</h2>
        <hr>
        <?php if (isset($_SESSION['orderAlert'])): ?>
        <center>
            <p class="alertC"><?=$_SESSION['orderAlert'];?>
            </p>
        </center>
        <?php endif; ?>
        <?php if (isset($_SESSION['userOrders'])): ?>
        <table id="orderDetailTable">
            <tr>
                <th>Id Pedido</th>
                <th>Valor</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
            <?php foreach ($_SESSION['userOrders'] as $orderDetail): ?>
            <tr>
                <td><a
                        href="<?=URL?>orders/getOrderDetailByIdC/<?=$orderDetail['id'];?>"><?=$orderDetail['id'];?>
                    </a></td>
                <td>$ <?=$orderDetail['total'];?>
                    COP
                </td>
                <td><?=$orderDetail['estado'];?>
                </td>
                <td><?=$orderDetail['fecha'];?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
<?php Utils::dropSession('orderAlert') ?>
<?php require_once DIR.'views/footerView.php';
