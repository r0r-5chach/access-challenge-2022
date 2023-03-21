<?php
namespace site;

use site\controller\Portal;
use site\controller\User;

class Routes extends \framework\Routes {
    public function __construct() {
        $this->databaseTables = [];
        $this->controllers = [];
        $this->initTables();
        $this->initControllers();
        //TODO: Add database tables to array
        //TODO: Add controllers to array
        //TODO: add login controllers to array
    }
    private function initTables(){
        $this->databaseTables['users'] = new DatabaseTable("users", "user_id");
    }

    private function initControllers() {
        $this->controllers['user'] = new User($this->databaseTables['users']);
        $this->controllers['portal'] = new Portal();
    }

    public function getDefaultRoute() {
        return 'user/login';
    }
}