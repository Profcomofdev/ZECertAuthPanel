<?php
use zengine\Router;

//default routes
Router::add('^manage$', ['controller' => 'Main', 'action' => 'index', "prefix" => "manage"]);
Router::add('^manage/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['controller' => 'Main', 'action' => 'index', "prefix" => "manage"]);

//default routes
Router::add('^personal$', ['controller' => 'Main', 'action' => 'index', "prefix" => "personal"]);
Router::add('^personal/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['controller' => 'Main', 'action' => 'index', "prefix" => "personal"]);

Router::add('^api$', ['controller' => 'Main', 'action' => 'index', "prefix" => "api"]);
Router::add('^api/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['controller' => 'Main', 'action' => 'index', "prefix" => "api"]);

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['controller' => 'Main', 'action' => 'index']);