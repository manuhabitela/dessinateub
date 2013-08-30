<?php
use RedBean_Facade as R;

/**
 * LISTE
 *
 */
function listTeubes() {
	$app = \Slim\Slim::getInstance();

	$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
	$sort = filter_input(INPUT_GET, 'ordre', FILTER_SANITIZE_STRING);

	if (empty($page) || !is_numeric($page) || $page <= 0)
		$page = 1;

	$itemsNb = 15;
	$limit = ($page - 1)*$itemsNb;

	$teu = getTeubes($sort, $limit, $itemsNb);

	$app->render('list.php', array(
		'page' => 'list',
		'teubes' => $teu["teubes"],
		'title' => $teu["title"],
		'pageNb' => $page,
		'sort' => !empty($sort) ? $sort : null,
		'fullList' => count($teu['teubes']) == $itemsNb
	));
}

function getSortData($sort) {
	switch ($sort) {
		case 'anciennes':
			$field = "created";
			$direction = "ASC";
			$title = "Les plus anciennes teubs";
			break;
		case 'belles':
			$field = "w_rating";
			$direction = "DESC";
			$title = "Les teubs préférées de la communauté";
			break;
		case 'moches':
			$field = "w_rating";
			$direction = "ASC";
			$title = "Les plus moches";
			break;
		case 'kamoulox':
			$field = "comments_count";
			$direction = "DESC";
			$title = "Les teubs dont on débat le plus";
			break;
		case 'nouvelles':
		default:
			$field = "created";
			$direction = "DESC";
			$title = "Les dernières créations";
			break;
	}
	return array('field' => $field, 'direction' => $direction, 'title' => $title, 'sort' => $sort);
}

function getTeubes($sort, $limit, $itemsNb) {
	$sortData = getSortData($sort);

	$teubes = R::findAll('teube', '
		ACTIVE = 1
		ORDER BY
			CASE WHEN '.$sortData['field'].' IS NULL THEN 1 ELSE 0 END,
			'.$sortData['field'].' '.$sortData['direction'].'
		LIMIT '.$limit.','.$itemsNb
	);

	$i = 0;
	foreach ($teubes as $teube) {
		$teube->w_rating = round($teube->w_rating, 2);
		$teube->list_position = $limit + $i;
		$i++;
	}

	return array('title' => $sortData['title'], 'teubes' => $teubes, 'sort' => $sort);
}

function getSiblings($sortData, $pos = null) {
	if (!is_numeric($pos))
		return false;

	$prev = $pos > 0;
	$pos = $prev ? $pos - 1 : 0;
	$limit = $prev ? 3 : 2;

	$teubes = R::findAll('teube', '
		ACTIVE = 1
		ORDER BY
			CASE WHEN '.$sortData['field'].' IS NULL THEN 1 ELSE 0 END,
			'.$sortData['field'].' '.$sortData['direction'].'
		LIMIT '.$pos.','.$limit
	);
	if (empty($teubes))
		return array();

	$teubesArray = array();
	foreach ($teubes as $teube)
		$teubesArray[]= $teube;
	$siblings = array();
	$siblings['prev'] = ($prev && !empty($teubesArray[0])) ? $teubesArray[0] : null;
	if ($prev && !empty($teubesArray[2]))
		$siblings['next'] = $teubesArray[2];
	elseif ($prev)
		$siblings['next'] = null;
	else
		$siblings['next'] = $teubesArray[1];
	return $siblings;
}

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
	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);
	if (is_numeric($slug) && !empty($_SESSION['ids']) && in_array($slug, $_SESSION['ids']))
		$teube = R::load('teube', $slug);
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
	if (!empty($teube->name) && !empty($teube->artist) && !empty($teube->image)) {
		$teubeId = R::store($teube);
		if (isset($_SESSION['ids']))
			$_SESSION['ids'][]= $teubeId;
		else
			$_SESSION['ids'] = array($teubeId);
		$app->flash('success', "Teub ajoutée ! Tu peux la modifier ou la supprimer pendant encore quelques minutes.");
		$app->redirect($app->urlFor('regarder', array('slug' => $teube->id)));
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
	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);
	$teube = R::load('teube', $slug);
	if (!empty($teube->id) && !empty($_SESSION['ids']) && in_array($teube->id, $_SESSION['ids'])) {
		$teube->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
		$teube->artist = filter_input(INPUT_POST, 'artist', FILTER_SANITIZE_STRING);
		$teube->image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);
		R::store($teube);
		$app->flash('success', "Teub modifiée !");
	} else {
		$app->flash('info', "Impossible de modifier cette teub");
	}
	$app->redirect($app->urlFor('regarder', array('slug' => $teube->id)));
})->name('draw-put');


/**
 * SUPPRESSION
 */
$app->post('/etjelemontreplus/:slug', function($slug) use($app) {
	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);
	$teube = R::load('teube', $slug);
	if (!empty($teube->id) && !empty($_SESSION['ids']) && in_array($teube->id, $_SESSION['ids'])) {
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
	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);
	$teube = R::load('teube', $slug);
	if (empty($teube->id) || empty($teube->active)) {
		$app->flash('error', "Erreur : impossible de visualiser cette teub");
		$app->redirect($app->request()->getReferrer());
	}
	$isEditable = (!empty($_SESSION['ids']) && in_array($teube->id, $_SESSION['ids']));
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
	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);
	$teube = R::load('teube', $slug);
	if (!empty($teube->id))
		$teube->report();
	$app->flash('success', "Merci, on va voir ce qu'on fait d'elle.");
	$app->redirect($app->request()->getReferrer());
})->name('abus');

/**
 * RANDOM
 */
$app->get('/balancebalancebalancebalancetoi', function() use($app) {
	$rand = R::getCell('SELECT id FROM teube WHERE active = 1 ORDER BY RAND() limit 1');
	if (!empty($rand))
		$app->redirect($app->urlFor('regarder', array('slug' => $rand)));
	else
		$app->redirect($app->urlFor('home'));
})->name('random');