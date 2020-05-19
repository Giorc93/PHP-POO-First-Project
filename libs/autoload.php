<?php

function autoload($className)
{
    $controllerFile = DIR.'controllers/ctl'.$className.'Controller.php';
    if (file_exists($controllerFile)) {
        include $controllerFile;
    }
    $modelFile = DIR.'models/mdl'.$className.'Model.php';
    if (file_exists($modelFile)) {
        include $modelFile;
    }
}

spl_autoload_register("autoload");

function autoloadS($staticName)
{
    $staticFile = DIR.'libs/static/'.$staticName.'Static.php';
    if (file_exists($staticFile)) {
        include $staticFile;
    }
}

spl_autoload_register("autoloadS");
