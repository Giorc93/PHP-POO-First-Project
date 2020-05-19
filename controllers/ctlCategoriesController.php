<?php

class Categories extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view = new View();
        $this->view->dispCategories = [];
        $this->model = new CategoriesModel();
    }

    public function showCategories()
    {
        if (isset($_SESSION['userId']) && $_SESSION['userId']['roll'] == 'admin') {
            if ($this->model->getCategories()) {
                $categories = $this->model->categories;
                $this->view->dispCategories = $categories;
                $this->view->renderView('categories');
            } else {
                $this->view->renderView('error');
            }
            return $categories;
        } else {
            header('Location:'.URL);
        }
    }

    public function newCategorie()
    {
        if (isset($_SESSION['userId']) && $_SESSION['userId']['roll'] == 'admin') {
            if (empty($_POST)) {
                $_SESSION['newCategorie'] = true;
                header('Location:'.URL.'categories/showCategories');
            } else {
                $ctgName = $this->alphNumValidate($_POST['ctgName']) ? $this->alphNumValidate($_POST['ctgName']) : null;
                $ctgValidate = $this->model->ctgValidate($ctgName) ? $this->model->ctgValidate($ctgName): 'Valid';
                if ($ctgValidate == 'Valid') {
                    if ($this->model->createCategorie(['ctgName' => $ctgName])) {
                        $_SESSION['newCategorie']['alert'] = "¡Categoria creada con éxito!";
                        header('Location:'.URL.'categories/showCategories');
                    }
                } else {
                    $_SESSION['newCategorie']['alert'] = "El nombre es inválido o ya existe una categoria con ese nombre. Intenta nuevamente";
                    header('Location:'.URL.'categories/showCategories');
                }
            }
        } else {
            $this->view->renderView('error');
        }
    }

    public function delCategorie()
    {
        if (isset($_SESSION['userId']) && ($_SESSION['userId']['roll']) == 'admin') {
            if (empty($_POST)) {
                $_SESSION['delCategorie'] = true;
                header('Location:'.URL.'categories/showCategories');
            } else {
                $ctgName = $this->alphNumValidate($_POST['ctgNameD']) ? $this->alphNumValidate($_POST['ctgNameD']) : null;
                $ctgValidate = $this->model->ctgValidate($ctgName) ? 'Valid': 'Invalid';
                if ($ctgValidate == 'Valid') {
                    if ($this->model->deleteCategorie(['ctgName' => $ctgName])) {
                        $_SESSION['delCategorie']['alert'] = "¡Categoria eliminada con éxito!";
                        header('Location:'.URL.'categories/showCategories');
                    }
                } else {
                    $_SESSION['delCategorie']['alert'] = "La categoria no existe. Intenta nuevamente";
                    header('Location:'.URL.'categories/showCategories');
                }
            }
        } else {
            $this->view->renderView('error');
        }
    }
}
