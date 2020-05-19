<?php require_once DIR.'views/headerView.php'; ?>
<!--Bloque Principal-->
<div id="contentR">
    <div class="alert"><?php echo(isset($this->mensaje) ? $this->mensaje : null) ; ?>
    </div>
    <form action="<?=URL?>users/userRegister" method="POST"
        enctype="multipart/form-data">
        <label for="firstName">Nombre</label><br>
        <input type="text" name="firstName" minlength="1" required pattern="[A-Za-z]+"
            title="No debe contener carácteres especiales o números."><br>
        <label for="lastName">Apellido</label><br>
        <input type="text" name="lastName" minlength="1" required pattern="[A-Za-z]+"
            title="No debe contener carácteres especiales o números."><br>
        <label for="email">E-Mail</label><br>
        <input type="email" name="email" required title="Introduce un e-mail válido"><br>
        <label for="passw">Contraseña</label><br>
        <input type="password" name="passw" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Debe contener al menos 8 carácteres entre ellos una mayúscula, una minúscula y un número."><br>
        <label for="profilePic">Foto de Perfil</label><br>
        <input type="file" name="profilePic" accept="image/jpeg, image/jpg" / required><br>
        <input type="submit" value="Registrar"><br>
    </form>
</div>
<?php require_once DIR.'views/footerView.php';
