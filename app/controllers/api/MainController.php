<?php
namespace app\controllers\api;

//require_once(APP . '/libs/RB/jsdb.php');

use zengine\base\Controller;
use Jajo\JSONDB;
use \app\models\MOpenssl;

class MainController extends Controller{

    public function indexAction(){
        $json_db = new JSONDB(APP . '/db');
        if (getBearerToken()){
            $certificates = $json_db->select( '*' )
            ->from( 'tokens.json' )
            ->where( [ 'tokenid' =>  getBearerToken() ] )
            ->get();
            return json_encode(["status" => "ok", "data" => "Token exists"]);
        }else{
            return json_encode(["status" => "failed", "data" => "Error logging in"]);
        }
    }

}