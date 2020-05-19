<?php

class ProductsModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->errorM = "";
        $this->products = [];
    }

    public function newProductM($data)
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('INSERT INTO productos VALUES (null, :ctgId, :prodName, :prodDesc, :prodPrice, :prodUnd, :prodDisc, CURDATE(), :prodImg);');
            $stmt->execute(['ctgId' => $data['ctgId'], 'prodName' => $data['prodName'], 'prodDesc' => $data['prodDesc'], 'prodPrice' => $data['prodPrice'], 'prodUnd' => $data['prodUnd'], 'prodDisc' => $data['prodDisc'],'prodImg' => $data['prodImg']]);
            $this->db = null;
            return true;
        } catch (PDOException $e) {
            $errorM = $e->getMessage();
            $this->errorM = $errorM;
            return false;
        }
    }

    public function prodValidate($dataProd)
    {
        $ctgId = $dataProd['ctgId'];
        $prodName = $dataProd['prodName'];
        $pdo = $this->db->connect();
        $stmt = $pdo->query('SELECT * FROM productos WHERE categoria_id = '.$ctgId.' AND nombre = "'.$prodName.'";');
        $count = $stmt->fetchColumn();
        return $count;
    }

    public function prodExists($id)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->query('SELECT * FROM productos WHERE id = '.$id.';');
        $count = $stmt->fetchColumn();
        return $count;
    }

    public function getProdByIdM($id)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->query('SELECT * FROM productos WHERE id = '.$id.';');
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        return $count;
    }

    public function modProductM($data)
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('UPDATE productos SET categoria_id = :ctgId, nombre = :prodName, descripcion = :prodDesc, precio = :prodPrice, stock = :prodUnd, oferta = :prodDisc, imagen = :prodImg WHERE id = :prodId');
            $stmt->execute(['ctgId' => $data['ctgId'], 'prodName' => $data['prodName'], 'prodDesc' => $data['prodDesc'], 'prodPrice' => $data['prodPrice'], 'prodUnd' => $data['prodUnd'], 'prodDisc' => $data['prodDisc'],'prodImg' => $data['prodImg'], 'prodId' => $data['prodId']]);
            $this->db = null;
            return true;
        } catch (PDOException $e) {
            $errorM = $e->getMessage();
            $this->errorM = $errorM;
            return false;
        }
    }

    public function getProdByCtgM($ctgId)
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('SELECT * FROM productos WHERE categoria_id = "'.$ctgId.'";');
            $stmt->execute();
            $this->db = null;
            
            return  $this->products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->errorM = $e->getMessage();
            return false;
        }
    }

    public function delProdM($prodId)
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('DELETE FROM productos WHERE id = "'.$prodId.'";');
            $stmt->execute();
            $this->db = null;
            
            return true;
        } catch (PDOException $e) {
            $this->errorM = $e->get_message();
            return false;
        }
    }

    public function lastProdM()
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('SELECT * FROM productos ORDER BY fecha DESC LIMIT 9;');
            $stmt->execute();
            $this->db = null;
            
            return  $this->products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->errorM = $e->get_message();
            return false;
        }
    }

    public function showProdByCtgM($ctgId)
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('SELECT * FROM productos WHERE categoria_id = "'.$ctgId.'"');
            $stmt->execute();
            
            return  $this->products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->errorM = $e->get_message();
            return false;
        }
    }
}
