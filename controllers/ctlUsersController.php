<?php

class Users extends Controller
{
    const HASH = PASSWORD_BCRYPT;
    const COST = 10;

    public function __construct()
    {
        parent::__construct();
        $this->model = new UsersModel();
        $this->view->mensaje = "";
    }

    public function registerForm()
    {
        $this->view->renderView('registerForm');
    }

    public function userRegister()
    {
        if (!empty($_POST)) {
            $firstName = $this->textValidate($_POST['firstName']) ? $this->textValidate($_POST['firstName']) : null;
            $lastName = $this->textValidate($_POST['lastName']) ? $this->textValidate($_POST['lastName']) : null;
            $email = $this->emailValidate($_POST['email']) ? $_POST['email'] : null;
            $passw = $this->passValidate($_POST['passw']) ? $_POST['passw'] : null;
            $passwc = password_hash($passw, self::HASH, ['cost' => self::COST]);
            $roll = 'user';
            $imgName = $this->imgValidate($_FILES['profilePic']) ? $_FILES['profilePic']['name'] : null;
            if ($this->model->register(['firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'passw' => $passwc, 'roll' => $roll,'profilePic' => $imgName])) {
                $this->view->renderView('succes');
            } else {
                $this->view->renderView('errorReg');
            }
        } else {
            $this->view->renderView('error');
        }
    }

    public function userLogin()
    {
        if (!empty($_POST)) {
            $email = $this->emailValidate($_POST['email']) ? $_POST['email'] : null;
            $passw = $this->passValidate($_POST['passw']) ? $_POST['passw'] : null;
            if ($this->model->login(['email' => $email])) {
                $userData = $this->model->userData;
                $verify = password_verify($passw, $userData['passw']);
                if ($verify) {
                    $_SESSION['userId'] = $userData;
                    header('Location:'.URL);
                } else {
                    $_SESSION['error'] = '¡Credenciales inválidas! Intenta nuevamente';
                    header('Location:'.URL);
                }
            } else {
                $this->view->mensaje = $this->model->errorM;
                $this->view->renderView('error');
            }
        } else {
            $this->view->renderView('error');
        }
    }

    public function userLogout()
    {
        Utils::dropSession('userId');
        Utils::dropAll();
        header('Location:'.URL);
    }
}
