<?php

namespace zengine\base;

use zengine\Db;

abstract class Model{

    public $attributes = [];
    public $errors = [];
    public $rules = [];

    public function __construct(){
        Db::instance();
    }

    public function load($data){
        foreach ($this->attributes as $name => $value){
            if (isset($data[$name])){
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function save($table){
        $tbl = \R::dispense($table);
        foreach ($this->attributes as $name => $value){
            $tbl[$name] = $value;
        }
        //echo $tbl;
        return \R::store($tbl);
    }

    public function update($table, $id){
        $tbl = \R::load($table, $id);
        foreach ($this->attributes as $name => $value){
            if (!empty($value) or trim($value) != ''){
                $tbl[$name] = $value;
            }
        }
        //echo $tbl;
        return \R::store($tbl);
    }

}