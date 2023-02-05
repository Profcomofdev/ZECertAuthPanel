<?php

namespace zengine;

use zengine\Db;

class DbFunctions{

    public function __construct(){
        $db = require_once(CONF . '/config_db.php');
        //
        if(!\R::testConnection()){
            if ($db["user"]){
                \R::setup($db['dsn'], $db['user'], $db['pass']);
            }else{
                \R::setup($db['dsn']);
            }
        }
        if (!\R::testConnection()){
            throw new \Exception('No connection to database!', 500);
        }
        \R::freeze(true);
        if (DEBUG){
            \R::debug(true, 1);
        }
    }

    public function userGetCount(){
        return (\R::count( 'users' ));
    }

    public function userGetAll(){
        $users = \R::findAll('users');
        return $users;
    }

    public function usersGetInfo($username){
        $user = \R::findOne('users', 'username = ?', [$username]);
        if ($user){
            return $user;
        }else{
            return null;
        }
    }

    public function usersCreateNew($attributes){
        $user = \R::dispense('users');
        foreach ($attributes as $key=>$value){
            $user[$key] = $value;
        }
        if (!$attributes["uuid"]){
            $user["uuid"] = '00000000-0000-0000-0000-000000000000';
        }
        if (\R::store($user)){
            return true;
        }else{
            return false;
        }
    }

    public function openSSLPersonalgetAll(){
        $certificates = \R::findAll('personalc');
        return $certificates;       
    }

    public function openSSLPersonalgetAllbyUser($username){
        $certificates = \R::findAll('personalc', 'user = ?', [$username]);
        return $certificates;       
    }

    public function openSSLPersonalcreateNew($attributes){
        $certificate = \R::dispense('personalc');
        foreach ($attributes as $key=>$value){
            $certificate[$key] = $value;
        }
        if (\R::store($certificate)){
            return true;
        }else{
            return false;
        }
    }

    public function openSSLPersonaleditInfo($hostname, $attributes){
        $certificate = \R::findOne('personalc', 'hostname = ?', [$hostname]);
        foreach ($attributes as $key=>$value){
            $certificate[$key] = $value;
        }
        if (\R::store($certificate)){
            return true;
        }else{
            return false;
        }
    }

    public function openSSLPersonaldelete($hostname){
        $certificate = \R::findOne('personalc', 'hostname = ?', [$hostname]);
        \R::trash($certificate);
    }

    public function openSSLServergetAll(){
        $certificates = \R::findAll('serverc', 'INNER JOIN users ON users.id = serverc.user');
        return $certificates;       
    }

    public function openSSLServercreateNew($attributes){
        $certificate = \R::dispense('serverc');
        foreach ($attributes as $key=>$value){
            $certificate[$key] = $value;
        }
        if (\R::store($certificate)){
            return true;
        }else{
            return false;
        }
    }

    public function openSSLServereditInfo($hostname, $attributes){
        $certificate = \R::findOne('serverc', 'hostname = ?', [$hostname]);
        foreach ($attributes as $key=>$value){
            $certificate[$key] = $value;
        }
        if (\R::store($certificate)){
            return true;
        }else{
            return false;
        }
    }

    public function openSSLServerdelete($hostname){
        $certificate = \R::findOne('serverc', 'hostname = ?', [$hostname]);
        \R::trash($certificate);
    }

    public function openSSLServergetAllbyUser($username){
        $certificates = \R::findAll('serverc', 'user = ?', [$username]);
        return $certificates;       
    }

}