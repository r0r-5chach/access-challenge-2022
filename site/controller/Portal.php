<?php

namespace site\controller;
use framework\Controller;

class Portal extends Controller
{
    public function home() {
        return [
            'template' => 'patientprofile.html.php',
            'title' => 'Portal',
            'stylesheet' => 'patientprofile',
            'vars' => []
        ];
    }

    public function manage() {
        return [
        'template' => 'managepatients.html.php',
        'title' => 'Portal',
        'stylesheet' => 'managepatients',
        'vars' => []
        ];
    }

    
}