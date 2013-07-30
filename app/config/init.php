<?php 
session_cache_limiter(false);
session_start();

define('APP_PATH', dirname(__FILE__).'/..');
define('WEBROOT_PATH', dirname(__FILE__).'/../../public');

require APP_PATH.'/config/app.php';

define('PROD', (!empty($_SERVER['SERVER_NAME']) && strpos($_SERVER['SERVER_NAME'], APP_SERVER) !== false));
error_reporting(PROD ? 0 : E_ALL);

require APP_PATH.'/config/database.php';
require APP_PATH.'/vendor/autoload.php';

RedBean_Facade::setup("mysql:host=".DB_HOST.";dbname=".DB_NAME."", DB_USER, DB_PASSWORD);
RedBean_Facade::$writer->setUseCache(true);

$app = new \Slim\Slim(array(
	'templates.path' => APP_PATH.'/views',
	'debug' => intval(!PROD),
	'mode' => 'development'
));

define('HOST', $app->request()->getUrl());
define('CURRENT', $app->request()->getPath());

$app->hook('slim.before.dispatch', function() use ($app) {
	$app->view()->setData('app', $app);
});