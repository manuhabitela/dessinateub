<?php
	require dirname(__FILE__).'/../app/config/init.php';

	require_once ROUTES_PATH.'/teubes.php';
	require_once MODELS_PATH.'/teube.php';

	$app->get('/', function() use ($app) {
		$app->render('home.php', array('page' => 'home'));
	})->name('home');

	$app->run();
?>