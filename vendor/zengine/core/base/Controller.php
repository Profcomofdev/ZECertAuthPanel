<?php

namespace zengine\base;

abstract class Controller{
    
    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public $data = [];
    public $meta = ['title' => '', 'keywords' => '', 'desc' => ''];

    public function __construct($route){
        $this->route = $route;
        $this->controller = $route["controller"];
        $this->model = $route["controller"];
        $this->view = $route["action"];
        $this->prefix = str_replace('\\', '/', $route["prefix"]);
    }

    public function getView(){
        $this->route["prefix"]= str_replace('\\', '/', $this->route["prefix"]);
        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
        $viewObject->render($this->data);
    }

    public function set($data){
        $this->data = $data;
    }

    public function setMeta($title='', $desc='', $keywords=''){
        $this->meta["title"] = $title;
        $this->meta["desc"] = $desc;
        $this->meta["keywords"] = $keywords;
    }

}