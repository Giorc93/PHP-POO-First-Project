<?php

class Orders extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new OrdersModel();
    }

    public function setOrderInfC()
    {
        if (isset($_SESSION['userId'])) {
            $this->view->renderView('orderForm');
        } else {
            $_SESSION['orderAlert'] = "¡Debes inciar sesión para confirmar tu compra!";
            header('Location:'.URL."shopCart/prodsFromCart");
        }
    }

    public function sendOrderC()
    {
        if (isset($_SESSION['userId'])) {
            if (empty($_POST)) {
                header('Location:'.URL."orders/setOrderInfC");
            } else {
                if (empty($_SESSION['shopCart'])) {
                    $_SESSION['orderAlert'] = "Tu carrito está vacío, agrega algunos productos y confirma tu compra";
                    header('Location:'.URL."orders/setOrderInfC");
                } else {
                    $orderDept = $this->textValidate($_POST['dept']) ? $this->textValidate($_POST['dept']) : null;
                    $orderMuncp = $this->textValidate($_POST['muncp']) ? $this->textValidate($_POST['muncp']) : null;
                    $orderAddr = $this->textValidate($_POST['addr']) ? $this->textValidate($_POST['addr']) : null;
                    $userId = $_SESSION['userId']['id'];
                    $orderTotal = Utils::shopCartStats()['shopCartTot'];
                    $orderStatus = 'En Revisión';
    
                    if ($this->model->sendOrderM(['userId' => $userId,'orderDept' => $orderDept, 'orderMuncp' => $orderMuncp, 'orderAddr' => $orderAddr, 'orderTotal' => $orderTotal, 'orderStatus' => $orderStatus])) {
                        $orderId = $this->model->lastId;
                        if ($this->model->saveOrderDetM($orderId)) {
                            $_SESSION['orderAlert'] = "¡Tu pedido se ha procesado con éxito!";
                            $orderDetail = $this->model->getLastOrderDetailByIdM($orderId);
                            $_SESSION['orderDetail'] = $orderDetail;
                            Utils::dropSession('shopCart');
                            header('Location:'.URL."orders/setOrderInfC");
                        }
                    } else {
                        $_SESSION['orderAlert'] = "¡No ha sido posible procesar tu pedido. Verifica la información e intenta nuevamente";
                        header('Location:'.URL."orders/setOrderInfC");
                    }
                }
            }
        } else {
            $this->view->renderView('error');
        }
    }

    public function getOrdersByUserC($userId)
    {
        if (isset($_SESSION['userId'])) {
            $userOrders = $this->model->getOrdersByUser($userId);
            if (!empty($userOrders)) {
                $_SESSION['userOrders'] = $userOrders;
                header('Location:'.URL."orders/showOrdersByUser");
            } else {
                header('Location:'.URL."orders/showOrdersByUser");
            }
        } else {
            $this->view->renderView('error');
        }
    }

    public function getOrderDetailByIdC($orderId)
    {
        if (isset($_SESSION['userId'])) {
            $orderDetail = $this->model->getOrderDetailByIdM($orderId);
            $_SESSION['orderDetail'] = $orderDetail;
            header('Location:'.URL."orders/showOrderDetail");
        } else {
            $this->view->renderView('error');
        }
    }

    public function showOrdersByUser()
    {
        if (isset($_SESSION['userId']) && isset($_SESSION['userOrders'])) {
            $this->view->renderView('userOrders');
        } elseif (isset($_SESSION['userId'])) {
            $_SESSION['orderAlert'] = "Aún no tienes ordenes procesadas, añade productos a tu carrito y confirma la compra.";
            $this->view->renderView('userOrders');
        } else {
            $this->view->renderView('error');
        }
    }

    public function showOrderDetail()
    {
        if (isset($_SESSION['userId']) && isset($_SESSION['orderDetail'])) {
            $this->view->renderView('orderDetail');
        } else {
            $this->view->renderView('error');
        }
    }

    public function showOrders()
    {
        if (isset($_SESSION['userId']) && $_SESSION['userId']['roll'] == 'admin') {
            $this->view->renderView('allOrders');
        } else {
            $this->view->renderView('error');
        }
    }

    public function getOrdersC()
    {
        if (isset($_SESSION['userId']) && $_SESSION['userId']['roll'] == 'admin') {
            $allOrders = $this->model->showOrdersM();
            if (!empty($allOrders)) {
                $_SESSION['allOrders'] = $allOrders;
                header('Location:'.URL."orders/showOrders");
            } else {
                $_SESSION['orderAlert'] = "Aún no existen ordenes";
                header('Location:'.URL."orders/showOrders");
            }
        } else {
            $this->view->renderView('error');
        }
    }

    public function modOrderStatusC($orderId)
    {
        if (isset($_SESSION['userId']) && $_SESSION['userId']['roll'] == 'admin') {
            if (!empty($_POST)) {
                $orderStatus = $_POST['estado'];
                if ($this->model->modOrderStatusM($orderId, $orderStatus)) {
                    $_SESSION['modAlert'] = "¡El estado del pedido ha sido modificado exitosamente!";
                    header('Location:'.URL."orders/getOrderDetailByIdC/".$orderId."");
                } else {
                    $_SESSION['modAlert'] = "No ha sido posible modificar el estado del pedido. Intenta nuevamente";
                    header('Location:'.URL."orders/showOrderDetail");
                }
            } else {
                $this->view->renderView('error');
            }
        } else {
            $this->view->renderView('error');
        }
    }
}
