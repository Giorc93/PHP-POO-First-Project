<?php require_once DIR.'views/headerView.php'; ?>
<!--Bloque Principal-->
<div id="content">
    <!--Barra Lateral-->
    <?php require_once DIR.'views/sideBarView.php'; ?>
    <!--Contenido Central-->
    <div id="container">
        <h2>Detalle de la Orden</h2>
        <hr>
        <nav id="orderDetNav">
            <ul>
                <li>
                    <h4>ID Pedido </h4> <?=$_SESSION['orderDetail'][0]['pedido_id']?>

                </li>
                <li>
                    <h4>Departamento </h4> <?=$_SESSION['orderDetail'][0]['departamento']?>
                </li>
                <li>
                    <h4>Municipio </h4> <?=$_SESSION['orderDetail'][0]['municipio']?>
                </li>
                <li>
                    <h4>Estado </h4> <?=$_SESSION['orderDetail'][0]['estado']?>
                </li>
                <li>
                    <h4>Fecha </h4> <?=$_SESSION['orderDetail'][0]['fecha']?>
                </li>
            </ul>
        </nav>
        <?php if (isset($_SESSION['userId']) && $_SESSION['userId']['roll'] == 'admin'): ?>
        <form
            action="<?=URL?>orders/modOrderStatusC/<?=$_SESSION['orderDetail'][0]['pedido_id']?>"
            method="POST" id="modOrderStat">
            <hr>
            <label for="estado">Cambiar estado del pedido: </label>
            <select name="estado">
                <option value="En revisión">En Revisión</option>
                <option value="Pago pendiente">Pago Pendiente</option>
                <option value="En bodega">En Bodega</option>
                <option value="En ruta">En Ruta</option>
                <option value="Entregado">Entregado</option>
                <option value="Cancelado">Cancelado</option>
            </select>
            <input type="submit" value="Cambiar Estado">
            <?php if (isset($_SESSION['modAlert'])): ?>
            <p class="alert" style="text-align:left; margin-left: 0;"><?=$_SESSION['modAlert']?>
            </p>
            <?php endif; ?>
        </form>
        <?php endif; ?>
        <hr style="clear: both;">
        <table id="shopCartTable">
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio Und</th>
                <th>Unidades</th>
                <th>Precio Neto</th>
            </tr>
            <?php foreach ($_SESSION['orderDetail'] as $prod): ?>
            <tr>
                <td><img src="http://localhost/master-php/uploads/prodImg/<?=$prod['imagen']?>"
                        alt="">
                </td>
                <td><?=$prod['nombre']; ?>
                </td>
                <td><?=$prod['precio_unidad']; ?>
                </td>
                <td><?=$prod['unidades'] ?>
                </td>
                <td>$ <?=$prod['precio_neto'] ?>
                    COP
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="5"><strong>Total Compra: $ <?=$prod['total'];?> COP
                    </strong></td>
            </tr>
        </table>
        <br>
    </div>
</div>
<?php Utils::dropSession('modAlert') ?>
<?php require_once DIR.'views/footerView.php';
