<?php

class UsersModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->errorM = "";
        $this->userData = [];
        $this->dataImg = [];
    }

    public function register($userdata)
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('INSERT INTO usuarios VALUES (null, :firstName, :lastName, :email, :passw, :roll, :profilePic);');
            $stmt->execute(['firstName' => $userdata['firstName'], 'lastName' => $userdata['lastName'], 'email' => $userdata['email'], 'passw' => $userdata['passw'], 'roll' => $userdata['roll'],'profilePic' => $userdata['profilePic']]);
            $this->db = null;
            return true;
        } catch (PDOException $e) {
            $errorM = $e->getMessage();
            $this->errorM = $errorM;
            return false;
        }
    }

    public function login($user)
    {
        try {
            $pdo = $this->db->connect();
            $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email;');
            $stmt->execute(['email' => $user['email']]);
            $this->userData = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->db = null;
            return true;
        } catch (PDOException $e) {
            $errorM = $e->getMessage();
            $this->errorM = $errorM;
            return false;
        }
    }
}
