<?php

class ShopCart extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->controllerP = new Products();
    }

    public function addToCart($prodId, $undToBuy = null)
    {
        if (isset($_SESSION['shopCart'])) {
            $prodToAdd = $this->controllerP->model->getProdByIdM($prodId);
            $undToAdd = isset($_POST['undToAdd']) ? $_POST['undToAdd'] : $undToBuy;
            $prodFound = false;
            foreach ($_SESSION['shopCart'] as $addProd) {
                if ($addProd['prodId'] == $prodToAdd['id']) {
                    $prodFound = true;
                }
            }
            if ($prodFound == false) {
                $_SESSION['shopCart'][$prodToAdd['id']] = array(
                    'prodId' => $prodToAdd['id'],
                    'prodName' => $prodToAdd['nombre'],
                    'prodPrice' => $prodToAdd['precio'],
                    'prodDisc' => $prodToAdd['oferta'],
                    'totalPrice' => (($prodToAdd['precio']) - ($prodToAdd['precio']*($prodToAdd['oferta']/100))) * $undToAdd,
                    'undToBuy' => $undToAdd,
                    'prodImg' => $prodToAdd['imagen'],
                    'prodDet' => $prodToAdd
                );
                header('Location:'.URL."shopCart/prodsFromCart");
            } else {
                $_SESSION['shopCart'][$prodId]['undToBuy'] += $undToAdd;
                $_SESSION['shopCart'][$prodId]['totalPrice'] =  ($_SESSION['shopCart'][$prodId]['undToBuy'])*(($prodToAdd['precio']) - ($prodToAdd['precio']*($prodToAdd['oferta']/100)));
                header('Location:'.URL."shopCart/prodsFromCart");
            }
        } else {
            $_SESSION['shopCart'] = [];
            header('Location:'.URL."shopCart/addToCart/".$prodId."/".$_POST['undToAdd']);
        }
    }

    public function empCart()
    {
        Utils::dropSession('shopCart');
        header('Location:'.URL."shopCart/prodsFromCart");
    }

    public function prodsFromCart()
    {
        if (!isset($_SESSION['shopCart'])) {
            $_SESSION['cartAlert'] = "Aún no tienes productos en tu carrito de compra.";
            $this->controllerP->view->renderView('shopCartDet');
        } else {
            $this->controllerP->view->renderView('shopCartDet');
        }
    }

    public function modProdUnitsC($prodId, $mod)
    {
        if (isset($_SESSION['userId']) && isset($_SESSION['shopCart'])) {
            if ($mod == '1') {
                $_SESSION['shopCart'][$prodId]['undToBuy']++;
                header('Location:'.URL.'/shopCart/prodsFromCart');
            } elseif ($mod == '0') {
                $_SESSION['shopCart'][$prodId]['undToBuy']--;
                header('Location:'.URL.'/shopCart/prodsFromCart');
            } else {
                $this->view->renderView('error');
            }
        } else {
            $this->view->renderView('error');
        }
    }
}
