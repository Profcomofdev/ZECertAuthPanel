<?php

namespace zengine;

class ErrorHandler{

    public function __construct(){
        if (DEBUG){
            error_reporting(-1);
        }else{
            error_reporting(0);
        }
        set_exception_handler([$this, 'exceptionHandler']);
    }

    public function exceptionHandler($e){
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayErrors('Exception', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

    protected function logErrors($message = '', $file= '', $line = ''){
        error_log("[" . date('Y-m-d H:i:s') . '] Error text: ' . $message . ' | Line: ' . $line . "\n=========================\n", 3, ROOT . '/tmp/errors.log');
    }

    protected function displayErrors($errno, $errstr, $errfile, $errline, $response= 404){
        http_response_code($response);
        if ($response == 404 and !DEBUG){
            require_once(WWW . '/errors/404.php');
            die;
        }
        if (DEBUG){
            require_once(WWW . '/errors/dev.php');
        }else{
            require_once(WWW . '/errors/prod.php');
        }
        die;
    }
}