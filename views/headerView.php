<!DOCTYPE HTML>
<html leng="es">

<head>
    <meta charset="UTF-8">
    <title>Hanger Hangar</title>
    <link rel="stylesheet" type="text/css"
        href="<?=URL?>public/css/styles.css" />
</head>
<?php $allCtg = Utils::getCategoriesU(); ?>

<body>
    <!--Contenedor-->
    <div id="containerM">
        <!--Cabecera-->
        <header id="header">
            <div id="logo">
                <img id="logopng"
                    src="<?=URL?>public/img/logoRS-removebg.png"
                    alt="storeLogo" />
                <a href="<?=URL?>">HANGER HANGAR STORE</a>
            </div>
        </header>
        <!--Menu-->
        <nav id="menu">
            <ul>
                <li>
                    <a href="<?=URL?>">Inicio</a>
                </li>
                <?php foreach ($allCtg as $categorie): ?>
                <li>
                    <a
                        href="<?=URL?>products/showProdByCtgC/<?=$categorie['id'];?>"><?=$categorie['nombre'];?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>