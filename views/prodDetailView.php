<?php require_once DIR.'views/headerView.php'; ?>
<?php $prodDetail = $this->prodDetail; ?>
<?php Utils::dropSession('newProd') ; ?>
<!--Bloque Principal-->
<div id="content">
    <!--Barra Lateral-->
    <?php require_once DIR.'views/sideBarView.php'; ?>
    <!--Contenido Central-->
    <div id="container">
        <?php if (isset($_SESSION['modProd'])): ;?>
        <h2>Modificar Producto '<?=$prodDetail['nombre']?>'
        </h2>
        <hr>
        <center>
            <form id="prodForm"
                action="<?=URL?>products/modProdC/<?=$prodDetail['id']?>/<?=$prodDetail['categoria_id']?>/<?=$prodDetail['nombre']?>"
                method="POST" enctype="multipart/form-data">
                <label for="prodCtg">Selecciona la nueva categoria de tu producto</label>
                <select name="prodCtg">
                    <?php foreach ($allCtg as $categorie): ?>
                    <option
                        value="<?=$categorie['id']?>"
                        <?php if ($prodDetail['categoria_id'] == $categorie['id']): ?>
                        <?php echo htmlspecialchars('selected'); ?>
                        <?php endif ?>>
                        <?=$categorie['nombre'];?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <label for="prodName">Nombre</label>
                <input type="text" name="prodName" minlength="1" required pattern="[A-Za-z ]+"
                    title="No debe contener carácteres especiales o números."
                    value="<?=$prodDetail['nombre']; ?>">
                <label for=" prodDesc">Descripción</label>
                <textarea name="prodDesc" minlength="1"
                    required"><?=$prodDetail['descripcion'];?></textarea>
                <label for="prodPrice">Precio</label>
                <input type="number" name="prodPrice" min="0" required pattern="[0-9]+"
                    title="Ingresa el valor del producto sin puntos o comas."
                    value="<?=$prodDetail['precio']; ?>">
                <label for="prodUn">Unidades</label>
                <input type="number" name="prodUnd" min="1" required pattern="[0-9]+"
                    title="Ingresa el número de unidades del producto."
                    value="<?=$prodDetail['stock']; ?>">
                <label for="prodDisc">Descuento % (0 = Sin Descuento)</label>
                <input type="number" name="prodDisc" min="0" max="100" required
                    title="Ingresa un descuento entre el 0% y 100%. Si no ingresas un valor se asumirá como 0."
                    value="<?=$prodDetail['oferta']; ?>">
                <label for="prodImg">Imagen</label><br>
                <center><img
                        src="http://localhost/master-php/uploads/prodImg/<?=$prodDetail['imagen']?>"
                        alt="prodImage" class="profilePic"></center>
                <input type="file" name="prodImg" accept="image/jpeg, image/jpg" / required><br>
                <input type="submit" value="Modificar Producto"><br>
            </form>
            <?php Utils::dropSession('modProd'); ?>
        </center>
        <?php elseif (isset($_SESSION['delProd'])): ;?>
        <h2>Confirmación de Eliminación del Producto: '<?=$prodDetail['nombre']?>'
        </h2>
        <hr>
        <div id="prodDetail">
            <h4>ID: </h4>
            <p><?=$prodDetail['id']?>
            </p><br>
            <h4>Categoria: </h4>
            <p><?php foreach ($allCtg as $categorie): ?>
                <?php if ($prodDetail['categoria_id'] == $categorie['id']): ?>
                <?php echo $categorie['nombre'] ?>
                <?php endif ?>
                <?php endforeach; ?>
            </p><br>
            <h4>Nombre: </h4>
            <p><?=$prodDetail['nombre']?>
            </p><br>
            <h4>Descripción: </h4>
            <p><?=$prodDetail['descripcion']?>
            </p><br>
            <h4>Precio: </h4>
            <p><?=$prodDetail['precio']?>
            </p><br>
            <h4>N° de Unidades: </h4>
            <p><?=$prodDetail['stock']?>
            </p><br>
            <h4>Descuento: </h4>
            <p><?=$prodDetail['oferta']?>
            </p><br>
            <h4>Fecha de creación: </h4>
            <p><?=$prodDetail['fecha']?>
            </p><br>
        </div>
        <div id="prodImg">
            <img src="http://localhost/master-php/uploads/prodImg/<?=$prodDetail['imagen']?>"
                alt="prodImage" class="profilePic">
        </div>
        <div id="delForm">
            <center>
                <form
                    action="<?=URL?>products/delProdC/<?=$prodDetail['id']?>"
                    method="POST">
                    <label for="delProd">¿Confirmas la eliminación del producto?</label></br>
                    <input type="radio" name="delProd" value="Y"><span>Si</span>
                    <input type="radio" name="delProd" value="N"><span>No</span>
                    <input type="submit" value="Eliminar">
                </form>
            </center>
        </div>
        <?php Utils::dropSession('delProd'); ?>
        <?php else: ?>
        <?php header('Location:'.URL.'products/prodMngmt'); ?>
        <?php endif; ?>
    </div>
</div>
<?php require_once DIR.'views/footerView.php';
