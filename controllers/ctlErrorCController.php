<?php

class ErrorC extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function render()
    {
        $this->view->mensaje = 'Página no encontrada';
        $this->view->renderView('error');
    }
}
