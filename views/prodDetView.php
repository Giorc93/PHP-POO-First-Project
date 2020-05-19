<?php $prodDetail = $this->prodDetail; ?>
<?php require_once DIR.'views/headerView.php'; ?>
<?php $prodDetail = $this->prodDetail; ?>
<!--Bloque Principal-->
<div id="content">
    <!--Barra Lateral-->
    <?php require_once DIR.'views/sideBarView.php'; ?>
    <!--Contenido Central-->
    <div id="container">
        <h2><?=$prodDetail['nombre']?>
        </h2>
        <hr>
        <div id="prodDetail">
            <h4>Descripción: </h4>
            <p><?=$prodDetail['descripcion']?>
            </p><br>
            <h4>Precio: </h4>
            <p>$ <?=$prodDetail['precio']?>
            </p><br>
            <h4>N° de Unidades Disponibles: </h4>
            <p><?=$prodDetail['stock']?>
            </p><br>
            <h4>Descuento: </h4>
            <p><?=$prodDetail['oferta']?>%
            </p><br>
        </div>
        <div id="prodImg">
            <img src="http://localhost/master-php/uploads/prodImg/<?=$prodDetail['imagen']?>"
                alt="prodImage" class="profilePic">
        </div>
        <div id="buyForm">
            <center>
                <form
                    action="<?=URL?>shopCart/addToCart/<?=$prodDetail['id']?>"
                    method="POST">
                    <label for="undToAdd">Unidades: </label>
                    <input type="number" name="undToAdd" min="1" required
                        title="Ingresa el número de unidades a añadir">
                    <input type="submit" value="Comprar" class="buybtn">
                </form>
            </center>
        </div>
    </div>
</div>
<?php require_once DIR.'views/footerView.php';
