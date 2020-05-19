<?php

class View
{
    public function __construct()
    {
    }

    public function renderView($nombre)
    {
        require_once DIR.'views/'.$nombre.'View.php';
    }
}
