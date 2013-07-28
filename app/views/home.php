<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/head.php'); ?>

<div class="home-part home-draw">
	<h1><a href="<?php echo $app->urlFor('draw'); ?>" class="teu bouton">Je dessine ma teub</a></h1>
</div>

<div class="home-part home-galery">
	<ul class="hidden verbs">
		<li>Je mate</li>
		<li>Je vote pour</li>
		<li>J'admire</li>
	</ul>
	<h1><a href="<?php echo $app->urlFor('teubes'); ?>" class="teu bouton"><span class="verb">Je mate</span> les teubs</a></h1>
</div>

<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/foot.php'); ?>