<?php
use RedBean_Facade as R;

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

function getTeube($slug) {
	$slug = $slug/100;
	return R::findOne('teube', ' slug = ? ', array($slug));
}