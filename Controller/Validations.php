<?php

namespace Controller;

class Validations
{
    public function validateLoginForm($email, $password): array
    {
        $errors = [];

        if (empty($email)) {
            $errors[] = 'Email is required';
        }
        if (empty($password)) {
            $errors[] = 'Password is required';
        }

        return $errors;
    }
}