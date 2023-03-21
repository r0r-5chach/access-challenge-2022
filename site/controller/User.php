<?php

namespace site\controller;

use site\DatabaseTable;
use framework\Controller;

class User extends Controller
{
    private $userTable;

    private $validator;

    public function __construct(DatabaseTable $userTable) {
        $this->userTable = $userTable;
        $this->validator = new Validations();
        $this->vars = [];
    }

    public function login(){
        if (isset($_GET['type']) && trim($_GET['type']) == 'admin') {
            return [
            'title' => 'Login',
            'template' => 'worker_login.html.php',
            'stylesheet' => 'worker_login'];
        }
        else {
            return [
            'title' => 'Login',
            'vars' => $this->vars,
            'template' => 'patient_login.html.php',
            'stylesheet' => 'patient_login'];
        }
    }

    public function loginSubmit()
    {
        $template = 'login.html.php';
        $errors = [];
        $message = '';

        if ($_POST) {
            if (isset($_POST['submit'])) {
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                $errors = $this->validator->validateLoginForm($email, $password);
                if (empty($errors)){
                    $user = $this->userTable->find("email",
                        $_POST['email']);
                    if ($user) {
                        $chkPassword = password_verify($_POST['password'],
                            $user[0]["password"]);
                        if ($chkPassword) {
                            //  valid
                            $_SESSION['loggedin'] = $user[0]['id'];
                            $_SESSION['userDetails'] = $user[0];

                            header('Location: home');
                        } else {
                            $message = "Invalid Cred"; // password
                        }
                    } else {
                        $message = "Invalid Cred"; // username
                    }
                }
            }
        }
        return ['template' => $template, 'title' => 'login',
            'vars' => ['errors' => $errors,
                'message' => $message]];
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }
}