<?php
namespace app\controllers\personal;

//require_once(APP . '/libs/RB/jsdb.php');

use zengine\base\Controller;
use Jajo\JSONDB;
use \app\models\MOpenssl;

class MainController extends Controller{

    public function indexAction(){
        if (isset($_SESSION["loggened"])){
               $session = true;
               if ($_SESSION["loggened"]["role"] == 1){
                   $role = 1;
               }else{
                   $role = 0;
               }
        }else{
            header('Location: /');
        }
    }

    public function authAction(){
        $json_db = new JSONDB(APP . '/db');
        if (!empty($_POST)){
            if ((isset($_POST["username"])) and (isset($_POST["password"]))){
                $users = $json_db->select( '*' )
                ->from( 'users.json' )
                ->get();
                if (count($users) == 0){
                    $json_db->insert( 'users.json', 
                        [ 
                            'username' => $_POST["username"], 
                            'password' => md5($_POST["password"]), 
                            'role' => 1 
                        ]
                    );
                    $_SESSION["loggened"] = $_POST;
                    $_SESSION["loggened"]["role"] = 1;
                    header('Location: /personal');
                }else{
                    $users = $json_db->select( '*'  )
                    ->from( 'users.json' )
                    ->where( [ 'username' => $_POST["username"] ] )
                    ->get();
                    if (count($users) > 0){
                        if (md5($_POST['password']) == $users[0]["password"]){
                            $_SESSION["loggened"] = $users[0];
                            header('Location: /personal');
                        }else{
                            header('Location: /?error=Auth failed. Wrong username or password.');
                        }
                    }else{
                        $json_db->insert( 'users.json', 
                            [ 
                                'username' => $_POST["username"], 
                                'password' => md5($_POST["password"]), 
                                'role' => 0 
                            ]
                        );
                        $_SESSION["loggened"] = $_POST;
                        $_SESSION["loggened"]["role"] = 0;
                    }
                }
            }
        }else{
            header('Location: /');
        }
    }

    public function issueAction(){
        if (isset($_SESSION["loggened"])){
            $session = true;
            if (!empty($_POST)){
                $get = false;
                if (isset($_POST["hostname"])){
                    $g = new MOpenssl();
                    $issueCert = $g->createPReq($_POST["hostname"], $_SESSION["loggened"]["username"]);
                    if ($issueCert[0] == 1){
                        $text = '<div class="error">Error occured in creating certificate!</div><div class="error uk-margin-left">'.$issueCert[1].'</div>';
                        if ($_SESSION["loggened"]["role"] == 1){
                            $database = $g->getAllPDatabase();
                            $this->set(compact('database', 'text'));
                        }else{
                            $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                            $this->set(compact('database', 'text'));
                        }
                    }else{
                        $text = '<div class="success">Successfully issued certificate!</div>';
                        if ($_SESSION["loggened"]["role"] == 1){
                            $database = $g->getAllPDatabase();
                            $this->set(compact('database', 'text'));
                        }else{
                            $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                            $this->set(compact('database', 'text'));
                        }
                    }
                }else{
                    header('Location: /personal/issue?error=Error getting variables!');
                }
            }else{
                $g = new MOpenssl();
                if ($_SESSION["loggened"]["role"] == 1){
                    $database = $g->getAllPDatabase();
                    $this->set(compact('database'));
                }else{
                    $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                    $this->set(compact('database'));
                }
            }
        }else{
            header('Location: /');
        }
    }

    public function renewAction(){
        if (isset($_SESSION["loggened"])){
            $session = true;
            if (isset($_GET["id"])){
                $get = false;
                if (isset($_GET["id"])){
                    $g = new MOpenssl();
                    $issueCert = $g->renewPCrt($_GET["id"], $_SESSION["loggened"]["username"]);
                    if ($issueCert[0] == 1){
                        $text = '<div class="error">Error occured in renewing certificate!</div><div class="error uk-margin-left">'.$issueCert[1].'</div>';
                        if ($_SESSION["loggened"]["role"] == 1){
                            $database = $g->getAllPDatabase();
                            $this->set(compact('database', 'text'));
                        }else{
                            $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                            $this->set(compact('database', 'text'));
                        }
                    }else{
                        $text = '<div class="success">Successfully renewed certificate!</div>';
                        if ($_SESSION["loggened"]["role"] == 1){
                            $database = $g->getAllPDatabase();
                            $this->set(compact('database', 'text'));
                        }else{
                            $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                            $this->set(compact('database', 'text'));
                        }
                    }
                }else{
                    header('Location: /personal/main/renew?error=Error getting variables!');
                }
            }else{
                $g = new MOpenssl();
                if ($_SESSION["loggened"]["role"] == 1){
                    $database = $g->getAllPDatabase();
                    $this->set(compact('database'));
                }else{
                    $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                    $this->set(compact('database'));
                }
            }
        }else{
            header('Location: /');
        }
    }

    public function deleteAction(){
        if (isset($_SESSION["loggened"])){
            $session = true;
            if (isset($_GET["id"])){
                $get = false;
                if (isset($_GET["id"])){
                    $g = new MOpenssl();
                    $issueCert = $g->removeHostPCertificate($_GET["id"]);
                    if ($issueCert[0] == 1){
                        $text = '<div class="error">Error occured in deleting certificate!</div><div class="error uk-margin-left">'.$issueCert[1].'</div>';
                        if ($_SESSION["loggened"]["role"] == 1){
                            $database = $g->getAllPDatabase();
                            $this->set(compact('database', 'text'));
                        }else{
                            $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                            $this->set(compact('database', 'text'));
                        }
                    }else{
                        $text = '<div class="success">Successfully deleted certificate!</div>';
                        if ($_SESSION["loggened"]["role"] == 1){
                            $database = $g->getAllPDatabase();
                            $this->set(compact('database', 'text'));
                        }else{
                            $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                            $this->set(compact('database', 'text'));
                        }
                    }
                }else{
                    header('Location: /personal/main/delete?error=Error getting variables!');
                }
            }else{
                $g = new MOpenssl();
                if ($_SESSION["loggened"]["role"] == 1){
                    $database = $g->getAllPDatabase();
                    $this->set(compact('database'));
                }else{
                    $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                    $this->set(compact('database'));
                }
            }
        }else{
            header('Location: /');
        }
    }

    public function signAction(){
        if (isset($_SESSION["loggened"])){
            $session = true;
            if (isset($_GET["id"])){
                $get = false;
                if (isset($_GET["id"])){
                    $g = new MOpenssl();
                    $issueCert = $g->genPCrt($_GET["id"]);
                    if ($issueCert[0] == 1){
                        $text = '<div class="error">Error occured in signing certificate!</div><div class="error uk-margin-left">'.$issueCert[1].'</div>';
                        if ($_SESSION["loggened"]["role"] == 1){
                            $database = $g->getAllPDatabase();
                            $this->set(compact('database', 'text'));
                        }else{
                            $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                            $this->set(compact('database', 'text'));
                        }
                    }else{
                        $text = '<div class="success">Successfully signed certificate!</div>';
                        if ($_SESSION["loggened"]["role"] == 1){
                            $database = $g->getAllPDatabase();
                            $this->set(compact('database', 'text'));
                        }else{
                            $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                            $this->set(compact('database', 'text'));
                        }
                    }
                }else{
                    header('Location: /personal/main/sign?error=Error getting variables!');
                }
            }else{
                $g = new MOpenssl();
                if ($_SESSION["loggened"]["role"] == 1){
                    $database = $g->getAllPDatabase();
                    $this->set(compact('database'));
                }else{
                    $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                    $this->set(compact('database'));
                }
            }
        }else{
            header('Location: /');
        }
    }

    public function exportAction(){
        $g = new MOpenssl();
        if (isset($_GET['hostname'])){
            $certf = $g->getPCertFiles($_GET["hostname"], $_GET["type"]);
            if ($_SESSION["loggened"]["role"] == 1){
                $database = $g->getAllPDatabase();
                $this->set(compact('database', 'certf'));
            }else{
                $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                $this->set(compact('database', 'certf'));
            }
        }else{
            if ($_SESSION["loggened"]["role"] == 1){
                $database = $g->getAllPDatabase();
                $this->set(compact('database'));
            }else{
                $database = $g->getAllUPDatabase($_SESSION["loggened"]["username"]);
                $this->set(compact('database'));
            }
        }
    }

}