<?php

class Controller
{
    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model();
    }

    public function textValidate($data)
    {
        if (empty($data) || (trim($data) == "") || preg_match("[^A-Za-z ]", $data)) {
            return false;
        } else {
            $lcase = strtolower($data);
            $valid = ucwords($lcase);
            return $valid;
        }
    }

    public function alphNumValidate($data)
    {
        if (empty($data) || (trim($data) == "") || preg_match("[^A-Za-z0-9 ]", $data)) {
            return false;
        } else {
            $lcase = trim(strtolower($data));
            $valid = ucwords($lcase);
            return $valid;
        }
    }

    public function alphNumValidateD($data)
    {
        if (empty($data) || (trim($data) == "")) {
            return false;
        } else {
            $lcase = trim(strtolower($data));
            $valid = ucfirst($lcase);
            return $valid;
        }
    }

    public function numValidate($data)
    {
        if (empty($data) || (trim($data) == "") || preg_match("[^0-9]", $data)) {
            return false;
        } else {
            return $data;
        }
    }

    public function discValidate($data)
    {
        if ($data < 0 || $data > 100) {
            return false;
        } else {
            return $data;
        }
    }

    public function emailValidate($data)
    {
        if (empty($data) || (trim($data) == "") || (!filter_var($data, FILTER_VALIDATE_EMAIL) == true)) {
            return false;
        } else {
            return true;
        }
    }

    public function passValidate($data)
    {
        if ((empty($data)) || (trim($data)) == "") {
            return false;
        } else {
            return true;
        }
    }

    public function imgValidate($data)
    {
        $imgName = $data['name'];
        $imgType = $data['type'];
        $imgSize = $data['size'];
        if ($imgSize <= 5000000) {
            if ($imgType == "image/jpeg" || $imgType == "image/jpg") {
                $uplPath = $_SERVER['DOCUMENT_ROOT'].'/master-php/uploads/';
                move_uploaded_file($_FILES['profilePic']['tmp_name'], $uplPath.$imgName);
            }
            return true;
        } else {
            return false;
        }
    }

    public function imgValidateP($data)
    {
        $imgName = $data['name'];
        $imgType = $data['type'];
        $imgSize = $data['size'];
        if ($imgSize <= 5000000) {
            if ($imgType == "image/jpeg" || $imgType == "image/jpg") {
                $uplPath = $_SERVER['DOCUMENT_ROOT'].'/master-php/uploads/prodImg/';
                move_uploaded_file($_FILES['prodImg']['tmp_name'], $uplPath.$imgName);
            }
            return true;
        } else {
            return false;
        }
    }

    public function lastProd()
    {
        $lastProd = $this->model->lastProdM();
    }
}
