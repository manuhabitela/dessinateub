<!DOCTYPE html>
<?php $page = !empty($page) ? "page--".$page.' ' : ''; ?>
<!--[if lt IE 7]>      <html lang="fr" class="<?php echo $page ?>no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="fr" class="<?php echo $page ?>no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="fr" class="<?php echo $page ?>no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="fr" class="<?php echo $page ?>no-js "> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php echo (!empty($title) ? $title.'&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;' : ''). APP_TITLE  ?></title>
		<meta name="description" content="<?php echo !empty($description) ? $description : APP_TITLE ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="shortcut icon" type="image/png" href="img/curseube.png" />

		<!--[if gt IE 8]><!-->
		<link href='http://fonts.googleapis.com/css?family=Chewy' rel='stylesheet' type='text/css'>
		<!--<![endif]-->

		<!-- dev : /css/style.css -->
		<?php $css = PROD ? '/css/style.min.css?v=957465612021901' : '/css/style.css?v='.time() ?>
		<link rel="stylesheet" href="<?php echo $css ?>">
		<link rel="stylesheet" href="/components/drawingboard.js/dist/drawingboard.css">
		<script src="/js/modernizr.custom.js"></script>
	</head>
	<body>

		<!--[if lte IE 8]>
			<p class="obsolete-browser">Vous utilisez un navigateur <strong>obsolète</strong>. <a href="http://browsehappy.com/" target="_blank">Mettez-le à jour</a> pour naviguer sur Internet de façon <strong>sécurisée</strong> ! Et accessoirement, pour pouvoir dessiner des teubs.</p>
		<![endif]-->

		<ul class="nav">
			<li><h1 class="nav__title teu">Dessine et regarde les plus belles teubs de l'interwebz</h1></li>
			<li><a href="<?php echo $app->urlFor('home'); ?>">Accueil</a></li>
			<li>
				<a href="/mater?ordre=nouvelles">Les dernières créations</a>
				<div class="dropdown">
					<a href="/mater?ordre=anciennes">Les plus anciennes</a>
				</div>
			</li>
			<li>
				<a href="/mater?ordre=belles">Les mieux notées</a>
				<div class="dropdown">
					<a href="/mater?ordre=moches">Les moins bien notées</a>
				</div>
			</li>
			<li><a href="<?php echo $app->urlFor('draw'); ?>" class="button">Dessiner</a></li>
			<li><a href="<?php echo $app->urlFor('random'); ?>">J'ai de la chance</a></li>
		</ul>

		<div id="container">
			<?php if (!empty($flash)): ?>
			<?php foreach ($flash as $type => $message): ?>
				<p class="button flash flash--<?php echo $type ?>"><?php echo $message ?></p>
			<?php endforeach ?>
			<?php endif ?>