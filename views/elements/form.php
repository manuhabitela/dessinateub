<form class="teube-add teube-container" action="<?php echo $app->urlFor('draw-post'); ?>" method="post">
	<div id="teuboard">

	</div>

	<div class="teube-info">
		<label for="teube-name-input" class="teu teube-name teube-field">Nom de la teube</label>

		<input type="text" id="teube-name-input" class="teube-name-input teube-field" name="name">

		<button class="teu teube-submit teube-button">Je valide la teube</button>

		<input type="hidden" name="image" value="">
	</div>
</form>