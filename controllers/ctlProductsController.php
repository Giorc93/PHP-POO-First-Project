<?php

class Products extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->modelC = new Categories();
        $this->model = new ProductsModel();
        $this->view->ctgProducts = [];
        $this->view->prodDetail = [];
        $this->view->lastProd = [];
    }

    public function prodMngmt()
    {
        $this->view->renderView('products');
    }

    public function newProductC()
    {
        if (isset($_SESSION['userId']) && ($_SESSION['userId']['roll'] == 'admin')) {
            if (empty($_POST)) {
                $_SESSION['newProd'] = true;
                header('Location:'.URL.'products/prodMngmt');
            } else {
                $ctgId = $_POST['prodCtg'];
                $prodName = $this->textValidate($_POST['prodName']) ? $this->textValidate($_POST['prodName']) : null;
                $prodValidate = $this->model->prodValidate(['ctgId' => $ctgId, 'prodName' => $prodName]) ? $this->model->prodValidate(['ctgId' => $ctgId, 'prodName' => $prodName]) : 'Valid';
                if ($prodValidate == 'Valid') {
                    $prodDesc =  $this->alphNumValidateD($_POST['prodDesc']) ? $this->alphNumValidate($_POST['prodDesc']) : null;
                    $prodPrice = $this->numValidate($_POST['prodPrice']) ? $this->numValidate($_POST['prodPrice']) : null;
                    $prodUnd = $this->numValidate($_POST['prodUnd']) ? $this->numValidate($_POST['prodUnd']) : null;
                    $prodDisc = ($_POST['prodDisc'] == null) ? 0 : $this->discValidate($_POST['prodDisc']);
                    $prodImg =  $this->imgValidateP($_FILES['prodImg']) ? $_FILES['prodImg']['name'] : null;

                    if ($this->model->newProductM(['ctgId' => $ctgId, 'prodName' => $prodName, 'prodDesc' => $prodDesc, 'prodPrice' => $prodPrice, 'prodUnd' => $prodUnd, 'prodDisc' => $prodDisc,'prodImg' => $prodImg])) {
                        $_SESSION['newProd']['alert'] = "¡Producto registrado exitosamente!";
                        header('Location:'.URL.'products/prodMngmt');
                    } else {
                        $_SESSION['newProd']['alert'] = "No ha sido posible registrar el producto. Revisa los campos en intenta nuevamente.";
                        header('Location:'.URL.'products/prodMngmt');
                    }
                } else {
                    $_SESSION['newProd']['alert'] = "Este producto ya existe. Puedes modificarlo desde listar productos, en la opción 'Modificar'";
                    header('Location:'.URL.'products/prodMngmt');
                }
            }
        } else {
            $this->view->renderView('error');
        }
    }

    public function modProdByIdC($id)
    {
        if (isset($_SESSION['userId']) && ($_SESSION['userId']['roll'] == 'admin')) {
            $prodId = $this->model->prodExists($id) ? $this->model->prodExists($id) : false;
            if ($prodId != false) {
                $product = $this->model->getProdByIdM($id);
                $this->view->prodDetail = $product;
                $_SESSION['modProd'] = true;
                $this->view->renderView('prodDetail');
            } else {
                $this->view->renderView('error');
            }
        } else {
            $this->view->renderView('error');
        }
    }

    public function getProdByIdC($id)
    {
        $prodId = $this->model->prodExists($id) ? $this->model->prodExists($id) : false;
        if ($prodId != false) {
            $product = $this->model->getProdByIdM($id);
            $this->view->prodDetail = $product;
            $this->view->renderView('prodDet');
        } else {
            $this->view->renderView('error');
        }
    }

    public function delProdByIdC($id)
    {
        if (isset($_SESSION['userId']) && ($_SESSION['userId']['roll'] == 'admin')) {
            $prodId = $this->model->prodExists($id) ? $this->model->prodExists($id) : false;
            if ($prodId != false) {
                $product = $this->model->getProdByIdM($id);
                $this->view->prodDetail = $product;
                $_SESSION['delProd'] = true;
                $this->view->renderView('prodDetail');
            } else {
                $this->view->renderView('error');
            }
        } else {
            $this->view->renderView('error');
        }
    }
    
    public function getProdByCtgC()
    {
        if (isset($_SESSION['userId']) && ($_SESSION['userId']['roll'] == 'admin')) {
            if (empty($_POST)) {
                $_SESSION['getProd'] = true;
                header('Location:'.URL.'products/prodMngmt');
            } else {
                $ctgId = $_POST['prodCtg'];
                $_SESSION['getProd']['ctgId'] = $ctgId;
                if ($this->model->getProdByCtgM($ctgId)) {
                    $ctgProducts = $this->model->products;
                    $this->view->ctgProducts = $ctgProducts;
                    $_SESSION['getProd']['tab'] = true;
                    $this->view->renderView('products');
                } else {
                    $_SESSION['getProd']['alert'] = "No ha sido posible cargar los productos. Intenta nuevamente";
                    header('Location:'.URL.'products/prodMngmt');
                }
            }
        } else {
            $this->view->renderView('error');
        }
    }

    public function modProdC($id, $actCtgId = null, $actName = null)
    {
        if (isset($_SESSION['userId']) && ($_SESSION['userId']['roll'] == 'admin')) {
            if (empty($_POST)) {
                header('Location:'.URL.'products/prodMngmt');
            } else {
                $prodId = $id;
                $ctgId = $actCtgId;
                $prodName = $actName;
                if ($_POST['prodCtg'] == $actCtgId) {
                    $prodValidate = true;
                } else {
                    $prodValidate = $this->model->prodValidate(['ctgId' => $ctgId, 'prodName' => $prodName]) ? true : false;
                }
                if ($prodValidate == true) {
                    if ($_POST['prodName'] == $actName) {
                        $modProdValidate = false;
                    } else {
                        $modProdValidate = $this->model->prodValidate(['ctgId' => $_POST['prodCtg'], 'prodName' => $_POST['prodName']]) ? true : false;
                    }
                    if ($modProdValidate == true) {
                        $_SESSION['modProd']['alert'] = "Ya existe un producto con éste nombre en la categoría seleccionada. Intenta nuevamente.";
                        header('Location:'.URL.'products/prodMngmt');
                    } else {
                        $ctgId = $_POST['prodCtg'];
                        $prodName = $this->textValidate($_POST['prodName']) ? $this->textValidate($_POST['prodName']) : null;
                        $prodDesc =  $this->alphNumValidateD($_POST['prodDesc']) ? $this->alphNumValidate($_POST['prodDesc']) : null;
                        $prodPrice = $this->numValidate($_POST['prodPrice']) ? $this->numValidate($_POST['prodPrice']) : null;
                        $prodUnd = $this->numValidate($_POST['prodUnd']) ? $this->numValidate($_POST['prodUnd']) : null;
                        $prodDisc = ($_POST['prodDisc'] == null) ? 0 : $this->discValidate($_POST['prodDisc']);
                        $prodImg =  $this->imgValidateP($_FILES['prodImg']) ? $_FILES['prodImg']['name'] : null;

                        if ($this->model->modProductM(['ctgId' => $ctgId, 'prodName' => $prodName, 'prodDesc' => $prodDesc, 'prodPrice' => $prodPrice, 'prodUnd' => $prodUnd, 'prodDisc' => $prodDisc,'prodImg' => $prodImg, 'prodId' => $prodId ])) {
                            $_SESSION['modProd']['alert'] = "¡Producto modificado exitosamente!";
                            header('Location:'.URL.'products/prodMngmt');
                        } else {
                            $_SESSION['modProd']['alert'] = "No ha sido posible modificar el producto. Revisa los campos en intenta nuevamente.";
                            header('Location:'.URL.'products/prodMngmt');
                        }
                    }
                } else {
                    $_SESSION['modProd']['alert'] = "Este producto no existe. Puedes crearlo desde la opción: Crear Producto";
                    header('Location:'.URL.'products/prodMngmt');
                }
            }
        } else {
            $this->view->renderView('error');
        }
    }

    public function delProdC($id)
    {
        if (isset($_SESSION['userId']) && ($_SESSION['userId']['roll'] == 'admin')) {
            if (empty($_POST)) {
                header('Location:'.URL.'products/prodMngmt');
            } else {
                if (($_POST['delProd']) == "Y") {
                    if ($this->model->delProdM($id)) {
                        $_SESSION['delProd']['alert'] = "¡Producto eliminado exitosamente!";
                        header('Location:'.URL.'products/prodMngmt');
                    } else {
                        $_SESSION['delProd']['alert'] = "No ha sido posible eliminar el producto. Intenta nuevamente.";
                        header('Location:'.URL.'products/prodMngmt');
                    }
                } else {
                    $_SESSION['delProd']['alert'] = "Se ha declinado la confirmación de eliminación.";
                    header('Location:'.URL.'products/prodMngmt');
                }
            }
        } else {
            $this->view->renderView('error');
        }
    }

    public function showProdByCtgC($ctgId)
    {
        $_SESSION['ctgId'] = $ctgId;
        if ($this->model->showProdByCtgM($ctgId)) {
            $ctgProducts = $this->model->showProdByCtgM($ctgId);
            $this->view->ctgProducts = $ctgProducts;
            $this->view->renderView('prodsByCtg');
        } else {
            $_SESSION['showProd'] = "Aún no existen productos en ésta categoria.";
            $this->view->renderView('prodsByCtg');
        }
    }
}
