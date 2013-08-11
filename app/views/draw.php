<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/head.php'); ?>

<form class="teube teube--draw" action="<?php echo $app->urlFor('draw-post'); ?>" method="post">
	<div id="teuboard">

	</div>

	<div class="teube__info">
		<label for="teube-name-input" class="teu teube__label teube__label--name">Nom de la teub</label>

		<input type="text" id="teube-name-input" class="teube__field teube__field--name" name="name" required>

		<button class="teube__button--submit teube__button">Je valide</button>

		<input type="hidden" name="image" value="">
	</div>
</form>

<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/foot.php'); ?>