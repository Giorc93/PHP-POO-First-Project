<?php
require_once 'C:/wamp64/www/master-php/proyecto-php-poo/libs/autoload.php';
session_start();
class App
{
    public function __construct()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        $className = $url[0];
        $methodName = isset($url[1]) ? $url[1] : "";

        if (empty($className)) {
            $controller = new Main();
            $controller->render();
        } elseif (class_exists($className) && method_exists($className, $methodName)) {
            $controller = new $className;

            $indexNum = sizeof($url);

            if ($indexNum > 1) {
                $methodName = $url[1];
                if ($indexNum > 2) {
                    $param = [];
                    for ($i = 2; $i < $indexNum; $i++) {
                        array_push($param, $url[$i]);
                    }
                    $controller->$methodName(intval($param[(0)]), $param2 = isset($param[(1)]) ? $param[(1)] : null, $param2 = isset($param[(2)]) ? $param[(2)] : null);
                } else {
                    $controller->$methodName();
                }
            } else {
                $controller->render();
            }
        } else {
            $controller = new ErrorC;
            $controller->render();
        }
    }
}
