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
        $template = 'patient_login.html.php';
        $stylesheet = 'patient_login';
        if(isset($_GET['type'])) {
            if ($_GET['type'] == "admin") {
                $template = 'worker_login.html.php';
                $stylesheet = 'worker_login';
            }
        }
        return ['template' => $template,
            'title' => 'Login',
            'stylesheet' => $stylesheet,
            'vars' => $this->vars];
    }

    public function loginSubmit()
    {
        $template = 'patient_login.html.php';
        $stylesheet = 'patient_login';
        $errors = [];
        $message = '';

        if (isset($_GET['type']) && $_GET['type'] == "admin") {
            $template = 'worker_login.html.php';
            $stylesheet = 'worker_login';
        }

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
        return ['template' => $template,
            'title' => 'Login',
            'stylesheet' => $stylesheet,
            'vars' => ['errors' => $errors,
                'message' => $message]
        ];
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }
}