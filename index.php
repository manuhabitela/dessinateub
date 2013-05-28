<?php
	session_cache_limiter(false);
	session_start();

	require 'config/app.php';

	// define('PROD', (!empty($_SERVER['SERVER_NAME']) && strpos($_SERVER['SERVER_NAME'], APP_SERVER) !== false));
	define('PROD', false);
	if (PROD) {
		error_reporting(0);
	} else {
		error_reporting(E_ALL);
	}

	require 'config/database.php';
	require 'vendor/autoload.php';
	use RedBean_Facade as R;
	require 'lib/helpers.php';

	R::setup("mysql:host=".DB_HOST.";dbname=".DB_NAME."", DB_USER, DB_PASSWORD);
	R::$writer->setUseCache(true);

	$app = new \Slim\Slim(array(
		'templates.path' => './views',
		'debug' => intval(!PROD)
	));
	define('HOST', $app->request()->getUrl());
	define('CURRENT', $app->request()->getPath());

	$app->hook('slim.before.dispatch', function() use ($app) {
		$app->view()->setData('app', $app);
	});

	/**
	 * accueil
	 *
	 */
	$app->get('/', function() use ($app) {

		$app->render('home.php', array('page' => 'home'));
	})->name('home');

	/**
	 *
	 *
	 */
	$app->get('/teubes', function() use ($app) {

		$app->render('view.php', array('teube' => array('name' => "azdazd")));
	})->name('teubes');

	/**
	 *
	 *
	 */
	$app->get('/etjelemontre', function() use ($app) {
		$app->render('draw.php', array('page' => 'draw'));
	})->name('draw');

	/**
	 *
	 *
	 */
	$app->post('/etjelemontre', function() use ($app) {
		$teube = R::dispense('teube');
		$teube->slug = base_convert($teube->id, 10, 16);
		$teube->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
		$teube->image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);
		$teube->votes = 0;
	})->name('draw-post');

	/**
	 *
	 *
	 */
	$app->post('/regarder/:slug', function($slug) use($app) {
		$slug = filter_var($slug, FILTER_SANITIZE_STRING);
		$teube = R::findOne('teube', ' slug = ? ', array($slug) );
		if (!empty($teube))
			return false;
	});

	/**
	 *
	 *
	 */
	$app->run();
?>