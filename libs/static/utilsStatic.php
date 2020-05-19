<?php

class Utils
{
    public static function dropSession($sessionName)
    {
        if (isset($_SESSION[$sessionName])) {
            unset($_SESSION[$sessionName]);
        }
    }

    public static function dropAll()
    {
        session_destroy();
    }

    public static function getCategoriesU()
    {
        $staticCont = new Categories();
        $result = $staticCont->model->getCategories();

        return $result;
    }

    public static function getProductsU($ctgId)
    {
        $staticCont = new Products();
        $result = $staticCont->model->getProdByCtgM($ctgId);

        return $result;
    }

    public static function lastProdU()
    {
        $staticCont = new Products();

        $result = $staticCont->model->lastProdM();

        return $result;
    }

    public static function getCtgNameByIdU($ctgId)
    {
        $staticCont = new Categories();
        $result = $staticCont->model->getCtgNameByIdM($ctgId);

        return $result;
    }

    public static function shopCartStats()
    {
        $stats = array(
            'shopCartUnt' => 0,
            'shopCartTot' => 0
        );

        if (isset($_SESSION['shopCart'])) {
            foreach ($_SESSION['shopCart'] as $product) {
                $stats['shopCartUnt'] += $product['undToBuy'];
            }

            foreach ($_SESSION['shopCart'] as $product) {
                $stats['shopCartTot'] += $product['undToBuy'] * ($product['prodPrice']-($product['prodPrice']*($product['prodDisc']/100)));
            }
        }

        return $stats;
    }
}
