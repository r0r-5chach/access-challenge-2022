<?php

namespace site\controller;

use site\DatabaseTable;

class User
{
    private $userTable;

    private $validator;

    public function __construct(DatabaseTable $userTable) {
        $this->userTable = $userTable;
        $validator = new Validations();
        $this->validator = $validator;
    }

    public function login(){
            return ['template' => 'login.html.php',
                'title' => 'Login',
                'vars' => []];
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
                            $this->session();
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
        session_start();
        session_unset();
        session_destroy();

        header('Location: index');
    }




    /**
     * @return void
     */
    public function session()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }
}