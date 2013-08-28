<?php
use RedBean_Facade as R;

/**
 * VOTER
 */
$app->post('/a-voter/:slug', function($slug) use ($app) {
	$error = false;

	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);
	$teube = R::load('teube', $slug);
	if (empty($teube->id))
		$error = true;
	else {

		$vote = R::dispense('voteub');
		$vote->ua = $_SERVER['HTTP_USER_AGENT'];
		$vote->ip = $_SERVER['REMOTE_ADDR'];
		$vote->value = filter_input(INPUT_POST, 'value', FILTER_SANITIZE_NUMBER_INT);
		$vote->fingerprint = filter_input(INPUT_POST, 'fingerprint', FILTER_SANITIZE_NUMBER_INT);
		$vote->teube = $teube;
		$voteId = R::store($vote);

		if (empty($voteId))
			$error = true;
		else {
			$maxRand = mt_getrandmax();
			$app->setCookie('vote_teub_'.$teube->id, mt_rand((int)$maxRand/6, $maxRand), time()+60*60*24*30, '/', 'jaiunegrosseteu.be');
		}

	}


	$res = $app->response();
	$res['Content-Type'] = 'application/json';
	$response = $error ?
		array('message' => 'Erreur lors du vote...', 'status' => 'error') :
		array('message' => 'A voté !', 'status' => 'success');
	echo json_encode($response);
})->name('a-voter');


/**
 * RÉCUPÉRATION DU DERNIER VOTE DE L'UTILISATEUR ACTUEL POUR UNE TEU
 */
$app->get('/ancien-vote/:slug', function($slug) use($app) {
	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);

	$res = $app->response();
	$res['Content-Type'] = 'application/json';

	$teube = R::load('teube', $slug);
	if (empty($teube->id))
		$nothing = true;
	else {
		$fingerprint = filter_input(INPUT_GET, 'fingerprint', FILTER_SANITIZE_NUMBER_INT);

		$vote = $teube->getUserVote($fingerprint);
		if (empty($vote->id))
			$nothing = true;
		else
			echo json_encode(array('vote' => $vote->value));
	}

	if (!empty($nothing))
		echo '{"vote": null}';
})->name('ancien-vote');