<!DOCTYPE HTML>
<html leng="es">

<head>
    <meta charset="UTF-8">
    <title>¡Algo salió mal!</title>
    <link rel="stylesheet" type="text/css"
        href="<?=URL?>public/css/styles.css" />
    <meta http-equiv="Refresh" content="2;url=<?=URL?>">
</head>

<body>
    <div id="containerM">
        <header id="header">
            <div id="logo">
                <img id="logopng"
                    src="<?=URL?>public/img/logoRS-removebg.png"
                    alt="storeLogo" />
                <a href="<?=URL?>">HANGER HANGAR STORE</a>
            </div>
        </header>
        <div id="sep"></div>
        <div id="content">
            <div class="alert">
                Algo salió mal... Serás redireccionado al inicio.<br>
                <a class="alert" href="<?=URL?>">Si no eres
                    redireccionado haz
                    click aquí.</a>
            </div>
        </div>
        <?php require_once DIR.'views/footerView.php' ?>;