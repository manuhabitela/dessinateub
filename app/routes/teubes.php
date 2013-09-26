<?php
use RedBean_Facade as R;

/**
 * LISTE
 *
 */
$app->get('/mater', 'listTeubes')->name('teubes');


/**
 * CREATION
 *
 */
$app->get('/etjelemontre', function() use ($app) {
	$app->render('draw.php', array('page' => 'draw', 'title' => 'Dessiner une teub'));
})->name('draw');


/**
 * EDITION
 *
 */
$app->get('/etjelemontre/:slug', function($slug) use ($app) {
	$teube = null;
	if (!empty($_SESSION['slugs']) && in_array($slug, $_SESSION['slugs'])) {
		$teube = getTeubeBySlug($slug);
		$teube->getImageURI();
	}
	else {
		$app->flash('info', "Impossible de modifier cette teub");
		$app->redirect($app->request()->getReferrer());
	}
	$teube->w_rating = round($teube->w_rating, 2);
	$app->render('draw.php', array('page' => 'draw', 'teube' => $teube, 'title' => $teube->name.' - Modification'));
})->name('draw-edit');


/**
 * CREATION (POST)
 *
 */
$app->post('/etjelemontre', function() use ($app) {
	$teube = R::dispense('teube');
	$teube->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
	$teube->artist = filter_input(INPUT_POST, 'artist', FILTER_SANITIZE_STRING);
	$teube->image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);
	$teube->ua = $_SERVER['HTTP_USER_AGENT'];
	$teube->ip = $_SERVER['REMOTE_ADDR'];
	if ($teube->isDuplicate())
		$app->redirect($app->request()->getReferrer());
	if (!empty($teube->name) && !empty($teube->artist) && !empty($teube->image)) {
		$teubeId = R::store($teube);
		$savedTeube = R::load('teube', $teubeId);
		if (isset($_SESSION['slugs']))
			$_SESSION['slugs'][]= $savedTeube->slug;
		else
			$_SESSION['slugs'] = array($savedTeube->slug);
		$app->flash('success', "Teub ajoutée ! Tu peux la modifier ou la supprimer pendant encore quelques minutes.");
		$app->redirect($app->urlFor('regarder', array('slug' => $savedTeube->slug)));
	}
	else {
		$app->flash('error', "Erreur : t'es sûr d'avoir bien dessiné, nommé et signé ta teub ?");
		$app->redirect($app->request()->getReferrer());
	}
})->name('draw-post');


/**
 * EDITION (PUT)
 */
$app->put('/etjelemontre/:slug', function($slug) use($app) {
	$teube = getTeubeBySlug($slug);
	if (!empty($teube) && !empty($_SESSION['slugs']) && in_array($teube->slug, $_SESSION['slugs'])) {
		$teube->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
		$teube->artist = filter_input(INPUT_POST, 'artist', FILTER_SANITIZE_STRING);
		$teube->image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);
		$teube->modified = date('Y-m-d H:i:s');
		$teube->modified_count++;
		$teube->color = ''; //remise à jour côté JS
		R::store($teube);
		$app->flash('success', "Teub modifiée !");
	} else {
		$app->flash('info', "Impossible de modifier cette teub");
	}
	$app->redirect($app->urlFor('regarder', array('slug' => $teube->slug)));
})->name('draw-put');


/**
 * SUPPRESSION
 */
$app->post('/etjelemontreplus/:slug', function($slug) use($app) {
	$teube = getTeubeBySlug($slug);
	if (!empty($teube) && !empty($_SESSION['slugs']) && in_array($teube->slug, $_SESSION['slugs'])) {
		R::trash($teube);
		$app->flash('success', "Teub supprimée !");
	} else {
		$app->flash('info', "Impossible de supprimer cette teub");
	}
	$app->redirect($app->urlFor('home'));
})->name('draw-delete');


/**
 * VUE
 */
$app->get('/de-:slug-cm', function($slug) use($app) {
	$teube = getTeubeBySlug($slug);
	if (empty($teube) || empty($teube->active)) {
		$message = "Erreur : cette teub n'existe pas.";
		if (!empty($teube) && empty($teube->active))
			$message = "Erreur : cette teub étant beaucoup trop moche, elle a dû quitter ce site à vie.";
		$app->flash('error', $message);
		$urlToRedirect = $app->request()->getReferrer() ? $app->request()->getReferrer() : $app->urlFor('home');
		$app->redirect($urlToRedirect);
	}
	$isEditable = (!empty($_SESSION['slugs']) && in_array($teube->slug, $_SESSION['slugs']));
	$userVote = $teube->getUserVote();

	//liens de navigation changeant suivant l'ordre voulu
	$sort = filter_input(INPUT_GET, 'voisines', FILTER_SANITIZE_STRING);
	$position = filter_input(INPUT_GET, 'pos', FILTER_SANITIZE_NUMBER_INT);
	if (!empty($sort) && $position !== false) {
		$sortData = getSortData($sort);
		$otherTeubes = getSiblings($sortData, $position);
		$prevTeube = $otherTeubes['prev'];
		$nextTeube = $otherTeubes['next'];
	}

	$teube->getImageURI();

	$teube->w_rating = round($teube->w_rating, 2);

	$data = array('page' => 'view', 'teube' => $teube, 'title' => $teube->name.(!empty($teube->artist) ? ' par '.$teube->artist : ''), 'userVote' => $userVote, 'isEditable' => $isEditable);
	if (!empty($sortData))
		$data = array_merge($data, array('prevTeube' => $prevTeube, 'sort' => $sort, 'position' => $position, 'nextTeube' => $nextTeube));
	$app->render('view.php', $data);
})->name('regarder');


/**
 * SIGNALER UN ABUS
 */
$app->post('/NANMAISCAVAPAS/:slug', function($slug) use($app) {
	$teube = getTeubeBySlug($slug);
	if (!empty($teube))
		$teube->report();
	$app->flash('success', "Merci, on va voir ce qu'on fait d'elle.");
	$app->redirect($app->request()->getReferrer());
})->name('abus');

/**
 * RANDOM
 */
$app->get('/balancebalancebalancebalancetoi', function() use($app) {
	$rand = R::getCell('SELECT slug FROM teube WHERE active = 1 ORDER BY RAND() limit 1');
	if (!empty($rand))
		$app->redirect($app->urlFor('regarder', array('slug' => $rand)));
	else
		$app->redirect($app->urlFor('home'));
})->name('random');