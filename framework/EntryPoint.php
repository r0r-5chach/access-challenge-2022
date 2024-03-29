<?php
namespace framework;
class EntryPoint {
    private $routes;

    public function __construct(\framework\Routes $routes) {
        $this->routes = $routes;
    }

    public function loadTemplate($fileName, $templateData) {
        \extract($templateData);
        \ob_start();
        require $fileName;
        return \ob_get_clean();  
    }

    public function run() {
        $route = \ltrim(\explode('?', $_SERVER['REQUEST_URI'])[0], '/');


        if ($route == '') {
            $route = $this->routes->getDefaultRoute();
        }

        if (count(\explode('/', $route)) == 1) {
            $controllerName = \explode('/', $route)[0];
            $functionName = "";
        }
        else {
            list($controllerName, $functionName) = \explode('/', $route);
        }
        if ($functionName == '') {
            $functionName = 'home';
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $functionName = $functionName . 'Submit';
        }
        $page = $this->routes->getController($controllerName, $functionName);
        if ($page == null) {
            $page = $this->routes->notFound();
        }
        else {
            $page = $page->$functionName();
        }
        $content = $this->loadTemplate('../templates/' . $page['template'], $page['vars']);
        $title = $page['title'];
        $stylesheet = $page['stylesheet'];
        require '../templates/layout.html.php';
    }
}
?>