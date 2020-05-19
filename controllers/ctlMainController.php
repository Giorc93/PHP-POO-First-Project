<?php

class Main extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $this->view->renderView('main');
    }
}
