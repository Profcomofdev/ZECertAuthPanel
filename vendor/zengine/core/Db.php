<?php

namespace zengine;

require_once(APP . '/libs/RB/rb.php');

class Db{

    use TSingletone;

    protected function __construct(){
        $db = require_once(CONF . '/config_db.php');
        //class_alias('\RedBeanPHP\R', '\R');
        //
        R::setup($db['dsn'], $db['user'], $db['pass']);
        if (!R::testConnection()){
            throw new \Exception('No connection to database!', 500);
        }
        //R::freeze(true);
        if (DEBUG){
            R::debug(true, 1);
        }
        //*/

    }
}