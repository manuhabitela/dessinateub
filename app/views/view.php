<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/head.php'); ?>

<div class="teube teube--view" data-url="<?php echo Halp::drawing($teube, true) ?>">

	<div id="teuboard">

	</div>

	<div class="teube__info">
		<?php if ($isEditable): ?>
		<a class="teube__edit-link" href="<?php echo $app->urlFor('draw-edit', array('slug' => $teube->id)) ?>">Modifier cette teube</a>
		<form action="<?php echo $app->urlFor('draw-delete', array('slug' => $teube->id)) ?>" method="post">
			<input type="hidden" name="_METHOD" value="DELETE">
			<button class="teube__delete-link">Supprimer cette teube</button>
		</form>
		<?php endif ?>
		<h2 class="teube__label teube__label--name"><?php echo $teube->name ?></h2>

		<label for="teube-url" class="teu teube__label">Partager cette teub :</label>
		<input type="text" id="teube-url" class="teube__field teube__field--url" value="<?php echo HOST.$app->urlFor('regarder', array('slug' => $teube->id)) ?>">
		<div>
			<!-- <a class="twitter teube-button" href="https://twitter.com/intent/tweet?text=" target="_blank">Twitter</a> -->
			<a class="twitter teube__button" href="#" target="_blank">Twitter</a>
		</div>
		<div>
			<!-- <a class="facebook teube-button" href="http://www.facebook.com/sharer/sharer.php?u=&amp;t=jaiunegrosseteu.be" target="_blank">Facebook</a> -->
			<a class="facebook teube__button" href="#" target="_blank">Facebook</a>
		</div>

		<div>
			<form action="#" class="teube__vote">
				<input type="hidden" name="teube-id" value="<?php echo $teube->id ?>">
				<fieldset>
					<legend>Voter :</legend>
					<input type="radio" id="teube-vote-5" name="teube-vote" value="5" /><label for="teube-vote-5" title="C'est parfait ! Maintenant j'ai besoin d'un slip de rechange.">5</label>
					<input type="radio" id="teube-vote-4" name="teube-vote" value="4" /><label for="teube-vote-4" title="J'aimerais avoir la même à la maison !">4</label>
					<input type="radio" id="teube-vote-3" name="teube-vote" value="3" /><label for="teube-vote-3" title="J'ai une demi-molle bien entamée.">3</label>
					<input type="radio" id="teube-vote-2" name="teube-vote" value="2" /><label for="teube-vote-2" title="C'est moche mais un peu excitant.">2</label>
					<input type="radio" id="teube-vote-1" name="teube-vote" value="1" /><label for="teube-vote-1" title="Non. NON.">1</label>
				</fieldset>
			</form>
		</div>

	</div>

	<div class="disqus-container">
		<div id="disqus_thread">

		</div>
	</div>
</div>

<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/foot.php'); ?>