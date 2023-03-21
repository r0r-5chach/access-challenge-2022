<?php
namespace site;
class Routes extends \framework\Routes {
    public function __construct() {
        $this->databaseTable = [];
        $this->controllers = [];
        $this->initTables();
        //TODO: Add database tables to array
        //TODO: Add controllers to array
        //TODO: add login controllers to array
    }
    public function initTables(){
        $this->databaseTable['users'] = new \site\DatabaseTable();
    }
}