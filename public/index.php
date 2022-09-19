<?php
include_once(dirname(__DIR__) . '/config/init.php');
include_once(LIBS . '/functions.php');
include_once(CONF . '/routes.php');

new \zengine\App();

//use app\models\MOpenssl;
//$g = new MOpenssl();
//$gg = $g->createReq('dd.telsi.intranet');
//$ggg = $g->genCrt('dd.telsi.intranet');
//$gggg = $g->getCrtInfo('dd.telsi.intranet');
//$ggggg = $g->renewCrt('dd.telsi.intranet');
//$gggggg = $g->getCrtInfo('dd.telsi.intranet');
//debug($gg);
//debug($ggg);
//debug($gggg);
//debug($ggggg);
//debug($gggggg);
//throw new Exception("Hi man", 404);