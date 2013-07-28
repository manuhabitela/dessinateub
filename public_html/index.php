<?php
	session_cache_limiter(false);
	session_start();

	define('APP_PATH', dirname(__FILE__).'/../app/');
	
	require APP_PATH.'config/app.php';

	error_reporting(PROD ? 0 : E_ALL);

	require APP_PATH.'config/database.php';
	require APP_PATH.'vendor/autoload.php';
	use RedBean_Facade as R;
	require APP_PATH.'models/teube.php';

	R::setup("mysql:host=".DB_HOST.";dbname=".DB_NAME."", DB_USER, DB_PASSWORD);
	R::$writer->setUseCache(true);

	$app = new \Slim\Slim(array(
		'templates.path' => APP_PATH.'views',
		'debug' => intval(!PROD),
		'mode' => 'development'
	));
	define('HOST', $app->request()->getUrl());
	define('CURRENT', $app->request()->getPath());

	$app->hook('slim.before.dispatch', function() use ($app) {
		$app->view()->setData('app', $app);
	});

	/**
	 * HOME
	 *
	 */
	$app->get('/', function() use ($app) {
		$app->render('home.php', array('page' => 'home'));
	})->name('home');
	

	/**
	 * ROUTES
	 *
	 */
	$routes = array('teubes');
	foreach ($routes as $route) {
		require APP_PATH.'routes/'.$route.'.php';
	}

	$app->run();
?>