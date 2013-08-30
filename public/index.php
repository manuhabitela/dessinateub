<?php
	require dirname(__FILE__).'/../app/config/init.php';

	require_once LIB_PATH.'/teubes.php';
	require_once ROUTES_PATH.'/teubes.php';
	require_once ROUTES_PATH.'/votes.php';
	require_once ROUTES_PATH.'/updates.php';
	require_once MODELS_PATH.'/teube.php';
	require_once MODELS_PATH.'/voteub.php';

	$app->get('/', function() use ($app) {
		$nouvelles = getTeubes("nouvelles", 0, 5);
		$belles = getTeubes("belles", 0, 5);
		$moches = getTeubes("moches", 0, 5);
		$app->render('home.php', array(
			'nouvelles' => $nouvelles,
			'belles' => array_merge($belles, array("title" => "Les plus belles")),
			'moches' => $moches,
			'page' => 'list',
			'title' => 'jaiunegrosseteu.be'
		));
	})->name('home');

	$app->run();
?>