<?php

namespace app\controllers;

use zengine\base\Controller;

class MainController extends Controller{

    public function indexAction(){
        if (isset($_SESSION["loggedin"])){
            $session = true;
        }
    }

}