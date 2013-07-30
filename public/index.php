<?php
	require dirname(__FILE__).'/../app/config/init.php';

	require_once APP_PATH.'/routes/teubes.php';
	require_once APP_PATH.'/models/teube.php';

	$app->get('/', function() use ($app) {
		$app->render('home.php', array('page' => 'home'));
	})->name('home');

	$app->run();
?>