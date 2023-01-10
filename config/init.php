<?php
define("DEBUG", 1);
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . '/public');
define("APP", ROOT . '/app');
define("CORE", ROOT . '/vendor/zengine/core');
define("LIBS", ROOT . '/vendor/zengine/core/libs');
define("CACHE", ROOT . '/tmp/cache');
define("CONF", ROOT . '/config');
define("LAYOUT", 'default');
define("DOMAIN", 'AD.local');
define("SALT", "sECsl0sWaAk50MxKHEyWRtuCoI4SDcDuL0nuN2XahD7xa3WeLFQwG2CPyYUeBo0YFtCU3wddB08eMdtB");
define("OPENSSL", ROOT . '/ssl');
define("OPENSSLP", ROOT . '/pssl');
define("EMAIL", "me@corp.com");

require_once(ROOT . '/vendor/autoload.php');
