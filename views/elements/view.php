<div class="teube-view teube-container" data-url="<?php echo $teube->image ?>">

	<div id="teuboardz">

	</div>

	<div class="teube-info">
		<?php if ($isEditable): ?>
		<a href="<?php echo $app->urlFor('draw-edit', array('slug' => $teube->id)) ?>">Modifier cette teube</a>
		<?php endif ?>
		<h2 class="teube-name teube-field"><?php echo $teube->name ?></h2>

		<h3 class="teu teube-field">Partager cette teub :</h3>
		<input type="text" id="teube-url" class="teube-field" value="<?php echo HOST.$app->urlFor('regarder', array('slug' => $teube->id)) ?>">
		<div>
			<!-- <a class="twitter teube-button" href="https://twitter.com/intent/tweet?text=" target="_blank">Twitter</a> -->
			<a class="twitter teube-button" href="#" target="_blank">Twitter</a>
		</div>
		<div>
			<!-- <a class="facebook teube-button" href="http://www.facebook.com/sharer/sharer.php?u=&amp;t=jaiunegrosseteu.be" target="_blank">Facebook</a> -->
			<a class="facebook teube-button" href="#" target="_blank">Facebook</a>
		</div>
	</div>
</div>