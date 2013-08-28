<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/head.php'); ?>

<div class="teube-view" data-id="<?php echo $teube->id ?>" data-url="<?php echo Halp::drawing($teube, true) ?>" data-rating="<?php echo round($teube->w_rating) ?>">

	<h2 class="teube-view__name">
		<?php echo $teube->name ?>
		<?php if ($isEditable): ?>
		<div class="teube-view__user-actions">
			<a data-icon-before="p" class="teube-view__edit-link button" href="<?php echo $app->urlFor('draw-edit', array('slug' => $teube->id)) ?>" title="Modifier cette teub"></a>
			<form action="<?php echo $app->urlFor('draw-delete', array('slug' => $teube->id)) ?>" method="post">
				<input type="hidden" name="_METHOD" value="DELETE">
				<button data-icon-before="t" class="teube-view__delete-link button" title="Supprimer cette teub"></button>
			</form>
		</div>
		<?php endif ?>
	</h2>

	<p class="teube-view__info">
		<?php $teubeTimestamp = strtotime($teube->created); ?>
		<?php $teubeDate = date("d/m/Y à H:i", $teubeTimestamp); ?>
		Œuvre réalisée
		par <span class="teube-view__artist"><?php echo $teube->artist ? $teube->artist : 'un inconnu' ?></span>
		<span class="teube-view__date" data-timestamp="<?php echo $teubeTimestamp*1000 ?>" title="Le <?php echo $teubeDate ?>">le <?php echo strstr($teubeDate, 'à', true); ?></span>
	</p>

	<div class="teube-view__vote-container cf">
		<?php if (isset($userVote)): ?>
		<span class="teube-view__user-vote">votre note : <span><?php echo $userVote->value ?></span></span>
		<?php endif ?>
		<form action="#" class="teube-view__vote cf">
			<input type="hidden" name="teube-id" value="<?php echo $teube->id ?>">
			<fieldset>
				<input type="radio" id="teube-vote-5" name="teube-vote" value="5" /><label for="teube-vote-5" title="C'est parfait ! Maintenant j'ai besoin d'un slip de rechange.">5</label>
				<input type="radio" id="teube-vote-4" name="teube-vote" value="4" /><label for="teube-vote-4" title="J'aimerais avoir la même à la maison !">4</label>
				<input type="radio" id="teube-vote-3" name="teube-vote" value="3" /><label for="teube-vote-3" title="J'ai une demi-molle bien entamée.">3</label>
				<input type="radio" id="teube-vote-2" name="teube-vote" value="2" /><label for="teube-vote-2" title="C'est moche mais un peu excitant.">2</label>
				<input type="radio" id="teube-vote-1" name="teube-vote" value="1" /><label for="teube-vote-1" title="Non. NON.">1</label>
			</fieldset>
		</form>
		<span class="teube-view__avg-vote">moyenne : <?php echo $teube->w_rating ?> avec <?php echo Halp::pluralize($teube->ratings_count, 'vote'); ?></span>
	</div>

	<div class="teube-view__drawing-container">
		<?php if (!empty($prevTeube)): ?>
			<a data-icon-before="l" href="<?php echo $app->urlFor('regarder', array('slug' => $prevTeube->id)).(!empty($sort) ? "?voisines=".$sort.( isset($position) ? "&pos=".($position-1) : '') : '') ?>" class="teube-view__navigation-link teube-view__navigation-link--prev" title="Teub précédente"></a>
		<?php endif ?>

		<img class="teube-view__drawing" src="<?php echo Halp::drawing($teube, true) ?>">

		<?php if (!empty($nextTeube)): ?>
			<a data-icon-before="r" href="<?php echo $app->urlFor('regarder', array('slug' => $nextTeube->id)).(!empty($sort) ? "?voisines=".$sort.( isset($position) ? "&pos=".($position+1) : '') : '') ?>" class="teube-view__navigation-link teube-view__navigation-link--next" title="Teub suivante"></a>
		<?php endif ?>
	</div>

	<div class="teube-view__share-container">
		<span class="teu">Partager sur&nbsp;</span>
		<!-- <a class="twitter teube-button" href="https://twitter.com/intent/tweet?text=" target="_blank">Twitter</a> -->
		<a class="condom--twitter condom--expandable teube-view__share-link" href="#" target="_blank">Twitter</a>
		<!-- <a class="facebook teube-button" href="http://www.facebook.com/sharer/sharer.php?u=&amp;t=jaiunegrosseteu.be" target="_blank">Facebook</a> -->
		<a class="condom--facebook condom--expandable teube-view__share-link" href="#" target="_blank">Facebook</a>
	</div>

	<form class="teube-view__report-form" action="<?php echo $app->urlFor('abus', array('slug' => $teube->id)) ?>" method="post">
		<button data-icon-before="w" class="teube-view__report-button">Signaler un abus ou un problème</button>
	</form>

	<div class="disqus-container">
		<div id="disqus_thread">

		</div>
	</div>
</div>

<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/foot.php'); ?>