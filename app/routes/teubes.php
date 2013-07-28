<?php
define('IMGS_FOLDER', '/drawings/');
use RedBean_Facade as R;
/**
 * LISTE
 *
 */
function teubes($page = '') {
	$app = \Slim\Slim::getInstance();
	if (empty($page) || !is_numeric($page) || $page <= 0)
		$page = 1;
	$itemsNb = 50;
	$limit = ($page - 1)*$itemsNb;
	$teubes = R::findAll('teube', ' LIMIT ?,?', array($limit, $itemsNb));
	$app->render('list.php', array('page' => 'list', 'teubes' => $teubes));
}

$app->get('/teubes', 'teubes')->name('teubes');
$app->get('/teubes/:page', 'teubes');


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


function saveTeubImg($URI, $teubeId) {
	if (empty($URI) || empty($teubeId)) return false;
	//http://j-query.blogspot.fr/2011/02/save-base64-encoded-canvas-image-to-png.html
	$img = str_replace(' ', '+', str_replace('data:image/png;base64,', '', $URI));
	$data = base64_decode($img);
	$file = dirname(__FILE__). IMGS_FOLDER . $teubeId . '.png';
	return file_put_contents($file, $data);
}

function deleteTeubImg($teubeId) {
	if (empty($teubeId)) return false;
	return unlink(dirname(__FILE__). IMGS_FOLDER . $teubeId . '.png');
}

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
		saveTeubImg($teube->image, $teubeId);
		if (isset($_SESSION['ids']))
			$_SESSION['ids'][]= $teubeId;
		else
			$_SESSION['ids'] = array($teubeId);
		$app->flash('success', "Teube ajoutée ! Tu peux la modifier ou la supprimer pendant encore quelques minutes.");
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
$app->put('/etjelemontre/:slug', function() use($app) {
	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);
	$teube = R::load('teube', $slug);
	if (!empty($teube) && !empty($_SESSION['ids']) && in_array($slug, $_SESSION['ids'])) {
		$teube->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
		$teube->image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);
		R::store($teube);
		saveTeubImg($teube->image, $teube->id);
		$app->flash('success', "Teube modifiée !");
	} else {
		$app->flash('info', "Impossible de modifier cette teub");
		$app->redirect('/etjelemontre');
	}
})->name('draw-put');


/**
 * VUE
 */
$app->get('/regarder/:slug', function($slug) use($app) {
	$slug = filter_var($slug, FILTER_SANITIZE_NUMBER_INT);
	$teube = R::load('teube', $slug);
	$isEditable = (!empty($_SESSION['ids']) && in_array($teube->id, $_SESSION['ids']));
	$app->render('view.php', array('page' => 'view', 'teube' => $teube, 'isEditable' => $isEditable));
})->name('regarder');