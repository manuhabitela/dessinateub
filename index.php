<?php
	session_cache_limiter(false);
	session_start();
	
	require 'config/app.php';

	define('PROD', (!empty($_SERVER['SERVER_NAME']) && strpos($_SERVER['SERVER_NAME'], APP_SERVER) !== false));
	if (PROD)
		error_reporting(0);

	require 'config/database.php';
	require 'vendor/autoload.php';
	require 'lib/helpers.php';

	$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME."", DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	$app = new \Slim\Slim(array(
		'templates.path' => './views',
		'debug' => intval(!PROD)
	));
	define('HOST', $app->request()->getUrl());

	/**
	 * accueil
	 *
	 */
	$app->get('/', function() use ($app, $db) {
		$app->render('home.php');
	})->name('home');


	/**
	 *
	 *
	 */
	$app->get('/:slug', function($slug) use($app) {

	});

	/**
	 *
	 *
	 */
	$app->run();
?>