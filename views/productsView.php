<?php require_once DIR.'views/headerView.php'; ?>
<?php $allCtg = Utils::getCategoriesU(); ?>
<!--Bloque Principal-->
<div id="content">
    <!--Barra Lateral-->
    <?php require_once DIR.'views/sideBarView.php'; ?>
    <!--Contenido Central-->
    <div id="container">
        <h2>Productos</h2>
        <hr>
        <div id="prodOpBox">
            <h3><a href="<?=URL?>products/newProductC">+Crear
                    producto</a></h3>
            <h3><a href="<?=URL?>products/getProdByCtgC">+Listar
                    productos</a></h3>
        </div>
        <?php if (isset($_SESSION['modProd'])): ?>

        <?php if (isset($_SESSION['modProd']['alert'])): ?>
        <center>
            <p class="alertC"><?=$_SESSION['modProd']['alert'];?>
            </p>
        </center>
        <?php endif; ?>
        <?php endif; ?>
        <?php Utils::dropSession('modProd'); ?>
        <?php if (isset($_SESSION['delProd'])): ?>

        <?php if (isset($_SESSION['delProd']['alert'])): ?>
        <center>
            <p class="alertC"><?=$_SESSION['delProd']['alert'];?>
            </p>
        </center>
        <?php endif; ?>
        <?php endif; ?>
        <?php Utils::dropSession('delProd'); ?>
        <center>
            <?php if (isset($_SESSION['getProd'])): ?>

            <?php if (isset($_SESSION['getProd']['alert'])): ?>
            <center>
                <p class="alertC"><?=$_SESSION['getProd']['alert'];?>
                </p>
            </center>
            <?php endif; ?>
            <h3 id="formTitle">Listar Productos</h3>
            <form action="<?=URL?>products/getProdByCtgC"
                id="prodForm" method="POST">
                <label for="prodCtg">Selecciona la categoria</label>
                <select name="prodCtg">
                    <?php foreach ($allCtg as $categorie): ?>
                    <?php if (isset($_SESSION['getProd']['ctgId'])): ;?>
                    <option
                        value="<?=$categorie['id']?>"
                        <?php if ($_SESSION['getProd']['ctgId'] == $categorie['id']): ?>
                        <?php echo htmlspecialchars('selected'); ?>
                        <?php endif ?>>
                        <?=$categorie['nombre'];?>
                    </option>
                    <?php else: ;?>
                    <option
                        value="<?=$categorie['id']?>">
                        <?=$categorie['nombre'];?>
                    </option>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Ver Productos">
            </form>
            <?php if (isset($_SESSION['getProd']['tab'])): ?>
            <center>
                <table id="ctgTable">
                    <tr>
                        <th>Id</th>
                        <th>Nombre del Producto</th>
                        <th>Unidades Disp.</th>
                        <th>Modificar</th>
                        <th>Eliminar</th>
                    </tr>
                    <?php foreach ($this->ctgProducts as $product) :?>
                    <tr>
                        <td><?=$product['id'];?>
                        </td>
                        <td><?=$product['nombre'];?>
                        </td>
                        <td><?=$product['stock'];?>
                        </td>
                        <td>
                            <a
                                href="<?=URL?>products/modProdByIdC/<?=$product['id']; ?>">Modificar</a>
                        </td>
                        <td>
                            <a
                                href="<?=URL?>products/delProdByIdC/<?=$product['id']; ?>">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </center>
            <?php endif; ?>
            <?php endif; ?>
            <?php Utils::dropSession('getProd') ; ?>

            <?php if (isset($_SESSION['newProd'])): ?>
            <center>
                <?php if (isset($_SESSION['newProd']['alert'])): ?>
                <center>
                    <p class="alertC"><?=$_SESSION['newProd']['alert'];?>
                    </p>
                </center>
                <?php endif; ?>
                <h3 id="formTitle">Crear Producto</h3>
                <form id="prodForm"
                    action="<?=URL?>products/newProductC"
                    method="POST" enctype="multipart/form-data">
                    <label for="prodCtg">Selecciona la categoria de tu producto</label>
                    <select name="prodCtg">
                        <?php foreach ($allCtg as $categorie): ?>
                        <option
                            value="<?=$categorie['id']?>">
                            <?=$categorie['nombre'];?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="prodName">Nombre</label>
                    <input type="text" name="prodName" minlength="1" required pattern="[A-Za-z ]+"
                        title="No debe contener carácteres especiales o números.">
                    <label for=" prodDesc">Descripción</label>
                    <textarea name="prodDesc" minlength="1" required"></textarea>
                    <label for="prodPrice">Precio</label>
                    <input type="number" name="prodPrice" min="0" required pattern="[0-9]+"
                        title="Ingresa el valor del producto sin puntos o comas.">
                    <label for="prodUn">Unidades</label>
                    <input type="number" name="prodUnd" min="1" required pattern="[0-9]+"
                        title="Ingresa el número de unidades del producto.">
                    <label for="prodDisc">Descuento % (0 = Sin Descuento)</label>
                    <input type="number" name="prodDisc" min="0" max="100" required
                        title="Ingresa un descuento entre el 0% y 100%. Si no ingresas un valor se asumirá como 0.">
                    <label for="prodImg">Imagen</label><br>
                    <input type="file" name="prodImg" accept="image/jpeg, image/jpg" / required><br>
                    <input type="submit" value="Cargar Producto"><br>
                </form>
            </center>
            <?php endif; ?>
            <?php Utils::dropSession('newProd') ; ?>
    </div>
</div>
<?php require_once DIR.'views/footerView.php';
