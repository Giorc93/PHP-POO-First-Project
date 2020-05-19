<?php require_once DIR.'views/headerView.php'; ?>

<!--Bloque Principal-->
<div id="content">
    <!--Barra Lateral-->
    <?php require_once DIR.'views/sideBarView.php'; ?>
    <!--Contenido Central-->
    <div id="container">
        <h2>Listado de Categorias</h2>
        <hr>
        <?php if (isset($_SESSION['newCategorie']['alert'])): ?>
        <center>
            <p class="alertC"><?=$_SESSION['newCategorie']['alert'];?>
            </p>
        </center>
        <?php endif; ?>
        <?php if (isset($_SESSION['delCategorie']['alert'])): ?>
        <center>
            <p class="alertC"><?=$_SESSION['delCategorie']['alert'];?>
            </p>
        </center>
        <?php endif; ?>
        <center>
            <table id="ctgTable">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
                <?php foreach ($this->dispCategories as $categorie) :?>
                <tr>
                    <td><?=$categorie['id'];?>
                    </td>
                    <td><?=$categorie['nombre'];?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (!isset($_SESSION['newCategorie'])): ?>
                <tr>
                    <td colspan="2">
                        <a href="<?=URL?>categories/newCategorie">+
                            Añadir categoria</a>
                    </td>
                </tr>
                <?php endif; ?>
                <?php if (!isset($_SESSION['delCategorie'])): ?>
                <tr>
                    <td colspan="2">
                        <a href="<?=URL?>categories/delCategorie">-
                            Eliminar categoria</a>
                    </td>
                </tr>
                <?php endif; ?>
            </table>
            <?php if (isset($_SESSION['newCategorie'])): ?>
            <form id="ctgForm"
                action="<?=URL?>categories/newCategorie"
                method="POST">
                <label for="ctgName">Nombre de la categoria</label>
                <input type="text" name="ctgName" minlength="1" required pattern="[A-Za-z0-9 ]+">
                <input id="catBtt" type="submit" value="Crear Categoria">
            </form>
            <?php endif; ?>
            <?php Utils::dropSession('newCategorie'); ?>
            <?php if (isset($_SESSION['delCategorie'])): ?>
            <form id="ctgForm"
                action="<?=URL?>categories/delCategorie"
                method="POST">
                <label for="ctgNameD">Nombre de la categoria a eliminar</label>
                <input type="text" name="ctgNameD" minlength="1" required pattern="[A-Za-z0-9 ]+">
                <input id="catBtt" type="submit" value="Eliminar Categoria">
            </form>
            <?php endif; ?>
            <?php Utils::dropSession('delCategorie'); ?>
        </center>
    </div>
</div>
<?php require_once DIR.'views/footerView.php';
