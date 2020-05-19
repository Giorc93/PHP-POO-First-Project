<?php

class OrdersModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->errorM = "";
        $this->lastId = "";
    }

    public function sendOrderM($orderData)
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('INSERT INTO pedidos VALUES (null, :userId, :orderDept, :orderMuncp, :orderAddr, :orderTotal, :orderStatus, CURDATE(), CURTIME())');
            $stmt->execute(['userId' => $orderData['userId'], 'orderDept' => $orderData['orderDept'], 'orderMuncp' => $orderData['orderMuncp'], 'orderAddr' => $orderData['orderAddr'], 'orderTotal' => $orderData['orderTotal'], 'orderStatus' => $orderData['orderStatus']]);
            $this->lastId = $pdo->lastInsertId();

            return true;
        } catch (PDOException $e) {
            $this->errorM = $e->getMessage();
            return false;
        }
    }

    public function saveOrderDetM($orderId)
    {
        try {
            $pdo = $this->db->connect();
            foreach ($_SESSION['shopCart'] as $prodDet) {
                if ($prodDet['undToBuy'] > 0) {
                    $stmt = $pdo->prepare('INSERT INTO lineas_pedido VALUES (null, :orderId, :prodId, :units) ;');
                    $stmt->execute(['orderId' => $orderId, 'prodId' => $prodDet['prodId'], 'units' => $prodDet['undToBuy']]);
                    $stmt = $pdo->prepare('UPDATE productos AS PR INNER JOIN lineas_pedido AS LP ON PR.id = LP.producto_id SET PR.stock = PR.stock - :units WHERE LP.producto_id = :prodId');
                    $stmt->execute(['prodId' => $prodDet['prodId'], 'units' => $prodDet['undToBuy']]);
                }
            }
    
            return true;
        } catch (PDOException $e) {
            $this->errorM = $e->getMessage();
            return false;
        }
    }

    public function getLastOrderDetailByIdM($orderId)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->query('SELECT p.id as pedido_id, lp.producto_id as producto_id, p.usuario_id as usuario_id, pr.nombre, lp.unidades, p.fecha, p.total as total_pedido FROM pedidos p INNER JOIN lineas_pedido lp On p.id = lp.pedido_id INNER JOIN productos pr ON pr.id = lp.producto_id WHERE p.id = '.$orderId.'');
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->db = null;

        return $result;
    }

    public function getOrderDetailByIdM($orderId)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->query('SELECT pr.imagen, pr.nombre, pr.precio, lp.unidades, p.departamento, p.municipio, p.direccion, p.estado, p.fecha, p.id as pedido_id, pr.precio - (pr.precio * (pr.oferta/100)) as precio_unidad, p.total, (pr.precio - (pr.precio * (pr.oferta/100))) * lp.unidades as precio_neto FROM lineas_pedido lp INNER JOIN pedidos p ON p.id = lp.pedido_id INNER JOIN productos pr ON pr.id = lp.producto_id WHERE p.id = '.$orderId.'');
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->db = null;

        return $result;
    }

    public function getOrdersByUser($userId)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->query('SELECT * FROM pedidos WHERE usuario_id = '.$userId.'');
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->db = null;

        return $result;
    }

    public function showOrdersM()
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->query('SELECT p.*, u.nombre FROM pedidos p INNER JOIN usuarios u ON p.usuario_id = u.id;');
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->db = null;

        return $result;
    }

    public function modOrderStatusM($orderId, $orderStatus)
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('UPDATE pedidos SET estado = :orderStatus WHERE id = :orderId');
            $stmt->execute(['orderStatus' => $orderStatus, 'orderId' => $orderId]);
            $this->db=null;
    
            return true;
        } catch (PDOException $e) {
            var_dump($this->errorM = $e->getMessage());
            die();
            return false;
        }
    }

    public function modProdUnitsM($prodId, $mod)
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('UPDATE lineas_pedido AS LP INNER JOIN productos AS PR ON PR.id = LP.producto_id SET LP.unidades = LP.unidades + 1 WHERE LP.pedido_id = :orderId AND LP.producto_id = 10');
            $stmt->execute(['orderStatus' => $orderStatus, 'orderId' => $orderId]);
            $this->db=null;
    
            return true;
        } catch (PDOException $e) {
            var_dump($this->errorM = $e->getMessage());
            die();
            return false;
        }
    }
}
