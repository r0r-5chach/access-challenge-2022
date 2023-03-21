<?php
namespace site;
class Routes extends \framework\Routes {
    public function __construct() {
        $this->databaseTables = [];
        $this->controllers = [];
        $this->initTables();
        //TODO: Add database tables to array
        //TODO: Add controllers to array
        //TODO: add login controllers to array
    }
    public function initTables(){
        $this->databaseTables['users'] = new DatabaseTable("users", "user_id");
    }
}