<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/head.php'); ?>

<form class="teube-drawing" action="<?php echo $app->urlFor('draw-post'); ?>" method="post">
	<h2>Dessiner</h2>

	<div id="teuboard" class="teube-drawing__board">

	</div>

	<div class="teube-drawing__field teube-drawing__field-name">
		<input type="text" id="teube-name-input" name="name" required placeholder="Comment s'appelle cette teub ?">
		<label for="teube-name-input" class="teu">Nom de l'œuvre</label>
	</div>

	<div class="teube-drawing__field teube-drawing__field-artist">
		<input type="text" id="teube-artist-input" name="artist" required placeholder="Qui es-tu ?">
		<label for="teube-artist-input" class="teu">Signature de l'artiste</label>
	</div>

	<div class="teube-drawing__submit">
		<button class="teube-drawing__submit condom condom--expandable">Je valide</button>
	</div>

	<input type="hidden" name="image" value="">
</form>

<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/foot.php'); ?>