<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/head.php'); ?>

<?php $formAction = !empty($teube) ? $app->urlFor('draw-put', array('slug' => $teube->slug)) : $app->urlFor('draw-post'); ?>
<form class="teube-drawing" action="<?php echo $formAction; ?>" method="post" <?php echo !empty($teube) ? 'data-url="'.Halp::drawing($teube, true).'"' : ''; ?>>
	<?php if (!empty($teube)): ?>
		<input type="hidden" name="_METHOD" value="PUT"/>
	<?php endif ?>

	<h2>Dessiner</h2>

	<div id="teuboard" class="teube-drawing__board">

	</div>

	<div class="teube-drawing__field teube-drawing__field-name">
		<label for="teube-name-input" class="teu only-small">Nom de l'œuvre</label>
		<input value="<?php echo !empty($teube->name) ? $teube->name : '' ?>" type="text" id="teube-name-input" name="name" required placeholder="Comment s'appelle cette teub ?">
		<label for="teube-name-input" class="teu no-small">Nom de l'œuvre</label>
	</div>

	<div class="teube-drawing__field teube-drawing__field-artist">
		<label for="teube-artist-input" class="teu only-small">Signature de l'artiste</label>
		<input value="<?php echo !empty($teube->artist) ? $teube->artist : '' ?>" type="text" id="teube-artist-input" name="artist" required placeholder="Qui es-tu ?">
		<label for="teube-artist-input" class="teu no-small">Signature de l'artiste</label>
	</div>

	<div class="teube-drawing__submit">
		<button class="teube-drawing__submit condom condom--expandable">Je valide</button>
	</div>

	<input type="hidden" name="image" value="">
</form>

<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/foot.php'); ?>