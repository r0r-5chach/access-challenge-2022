<?php
namespace framework;
class Controller {
    protected $vars = [];

    public function home() {
        return ['template' => 'home.html.php',
                'title' => 'Home',
                'vars' => $this->vars
            ];
    }
}
?>