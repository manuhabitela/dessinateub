<?php
use RedBean_Facade as R;

/**
 * LISTE
 *
 */
$app->get('/teubes', function() use ($app) {
	$app = \Slim\Slim::getInstance();

	$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
	$sort = filter_input(INPUT_GET, 'ordre', FILTER_SANITIZE_STRING);

	if (empty($page) || !is_numeric($page) || $page <= 0)
		$page = 1;

	switch ($sort) {
		case 'anciennes': $order = "created ASC"; break;
		case 'belles': $order = "rating DESC"; break;
		case 'moches': $order = "rating ASC"; break;
		case 'kamoulox': $order = "comments_count DESC"; break;
		case 'nouvelles':
		default: $order = "created DESC"; break;
	}

	$itemsNb = 50;
	$limit = ($page - 1)*$itemsNb;

	$teubes = R::findAll('teube', ' ORDER BY '.$order.' LIMIT '.$limit.','.$itemsNb);
	$app->render('list.php', array('page' => 'list', 'teubes' => $teubes));
})->name('teubes');


/**
 * CREATION
 *
 */
$app->get('/etjelemontre', function() use ($app) {
	$app->render('draw.php', array('page' => 'draw'));
})->name('draw');


/**
 * EDITION
 *
 */
$app->get('/etjelemontre/:slug', function($slug) use ($app) {
	$teube = null;
	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);
	if (is_numeric($slug) && !empty($_SESSION['ids']) && in_array($slug, $_SESSION['ids']))
		$teube = R::load('teube', $slug);
	else {
		$app->flash('info', "Impossible de modifier cette teub");
		$app->redirect('/etjelemontre');
	}
	$app->render('draw.php', array('page' => 'draw', 'teube' => $teube));
})->name('draw-edit');


/**
 * CREATION (POST)
 *
 */
$app->post('/etjelemontre', function() use ($app) {
	$teube = R::dispense('teube');
	$teube->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
	$teube->image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);
	$teube->votes = 0;
	$teube->active = 0;
	if (!empty($teube->name) && !empty($teube->image)) {
		$teubeId = R::store($teube);
		if (isset($_SESSION['ids']))
			$_SESSION['ids'][]= $teubeId;
		else
			$_SESSION['ids'] = array($teubeId);
		$app->flash('success', "Teub ajoutée ! Tu peux la modifier ou la supprimer pendant encore quelques minutes.");
	}
	else {
		$app->flash('error', "Erreur : êtes-vous sûr d'avoir bien dessiné et nommé votre teub ?");
		$app->redirect($app->request()->getReferrer());
	}
	$app->redirect('/regarder/'.$teube->id);
})->name('draw-post');


/**
 * EDITION (PUT)
 */
$app->put('/etjelemontre/:slug', function($slug) use($app) {
	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);
	$teube = R::load('teube', $slug);
	if (!empty($teube->id) && !empty($_SESSION['ids']) && in_array($slug, $_SESSION['ids'])) {
		$teube->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
		$teube->image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);
		R::store($teube);
		$app->flash('success', "Teube modifiée !");
	} else {
		$app->flash('info', "Impossible de modifier cette teube");
		$app->redirect('/etjelemontre');
	}
})->name('draw-put');


/**
 * SUPPRESSION
 */
$app->delete('/etjelemontre/:slug', function($slug) use($app) {
	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);
	$teube = R::load('teube', $slug);
	if (!empty($teube->id) && !empty($_SESSION['ids']) && in_array($slug, $_SESSION['ids'])) {
		R::trash($teube);
		$app->flash('success', "Teub supprimée !");
	} else {
		$app->flash('info', "Impossible de supprimer cette teub");
	}
	$app->redirect('/etjelemontre');
})->name('draw-delete');


/**
 * VUE
 */
$app->get('/regarder/:slug', function($slug) use($app) {
	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);
	$teube = R::load('teube', $slug);
	$isEditable = (!empty($_SESSION['ids']) && in_array($teube->id, $_SESSION['ids']));
	$userVote = $teube->getUserVote();
	$app->render('view.php', array('page' => 'view', 'teube' => $teube, 'isEditable' => $isEditable));
})->name('regarder');


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