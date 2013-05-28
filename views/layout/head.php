<!DOCTYPE html>
<?php $page = !empty($page) ? $page.' ' : ''; ?>
<!--[if lt IE 7]>      <html lang="fr" class="<?php echo $page ?>no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="fr" class="<?php echo $page ?>no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="fr" class="<?php echo $page ?>no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="fr" class="<?php echo $page ?>no-js "> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php echo !empty($title) ? $title : APP_TITLE  ?></title>
		<meta name="description" content="<?php echo !empty($description) ? $description : APP_TITLE ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href='http://fonts.googleapis.com/css?family=Chewy' rel='stylesheet' type='text/css'>
		<!-- dev : /css/style.css -->
		<?php $css = PROD ? '/css/style.min.css?v=957465612021901' : '/css/style.css?v='.time() ?>
		<link rel="stylesheet" href="<?php echo $css ?>">
		<link rel="stylesheet" href="/components/drawingboard.js/dist/drawingboard.css">
		<script src="/js/modernizr.custom.js"></script>
	</head>
	<body>

		<!--[if lte IE 8]>
			<p class="obsolete-browser">Vous utilisez un navigateur <strong>obsolète</strong>. <a href="http://browsehappy.com/" target="_blank">Mettez-le à jour</a> pour naviguer sur Internet de façon <strong>sécurisée</strong> !</p>
		<![endif]-->

		<ul class="nav">
			<li class="<?php if (CURRENT == $app->urlFor('home')) echo 'active' ?>" ><a href="<?php echo $app->urlFor('home'); ?>">Accueil</a></li>
			<li class="<?php if (CURRENT == $app->urlFor('draw')) echo 'active' ?>" ><a href="<?php echo $app->urlFor('draw'); ?>">Dessiner</a></li>
			<li class="<?php if (CURRENT == $app->urlFor('teubes')) echo 'active' ?>"><a href="<?php echo $app->urlFor('teubes'); ?>">Mater</a></li>
		</ul>

		<div id="container">