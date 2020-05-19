<?php

class CategoriesModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->categories = [];
        $this->categorieName = "";
    }

    public function getCategories()
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('SELECT * FROM categorias;');
            $stmt->execute();
            $this->db = null;
            
            return  $this->categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->errorM = $e->get_message();
            return false;
        }
    }

    public function ctgValidate($dataCtg)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->query('SELECT * FROM categorias WHERE nombre ="'.$dataCtg.'";');
        $count = $stmt->fetchColumn();
        return $count;
    }

    public function createCategorie($dataCtg)
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('INSERT INTO categorias VALUES (null, :ctgName);');
            $stmt->execute(['ctgName' => $dataCtg['ctgName']]);
            $this->db = null;
            return true;
        } catch (PDOException $e) {
            $this->errorM = $e->get_message();
            return false;
        }
    }

    public function deleteCategorie($dataCtg)
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('DELETE FROM categorias WHERE nombre = :ctgName;');
            $stmt->execute(['ctgName' => $dataCtg['ctgName']]);
            $this->db = null;
            return true;
        } catch (PDOException $e) {
            $this->errorM = $e->get_message();
            return false;
        }
    }

    public function getCtgNameByIdM($ctgId)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->query('SELECT nombre FROM categorias WHERE id ="'.$ctgId.'";');
        $count = $stmt->fetchColumn();
        return $count;
    }
}
