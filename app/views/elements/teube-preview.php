<div class="teube-preview">
	<a class="teube-preview__link" href="<?php echo HOST.$app->urlFor('regarder', array('slug' => $teube->id)).(!empty($sort) ? "?voisines=".$sort.( isset($teube->list_position) ? "&pos=".$teube->list_position : '') : '') ?>">
		<div class="teube-preview__img-wrapper" <?php if (!empty($teube->color)): ?> style="border-color: <?php echo $teube->color ?>; background-color: <?php echo $teube->color ?>" <?php endif ?>>
			<div>
				<img src="<?php echo Halp::drawing($teube, false, true) ?>" alt="<?php echo $teube->name ?>">
			</div>
		</div>
		<p class="teube-preview__title" title="<?php echo $teube->name.($teube->artist ? " par ".$teube->artist : '') ?>"><?php echo $teube->name ?></p>
	</a>
	<div class="teube-preview__info-wrapper">
		<div>
			<span data-icon-before="e" class="teube-preview__views" title="<?php echo Halp::pluralize($teube->views, 'vue') ?>"> <?php echo $teube->views ? $teube->views : 0 ?></span>
			<?php if (!empty($teube->w_rating)): ?>
			<span data-icon-before="s" class="teube-preview__rating" title="<?php echo Halp::pluralize($teube->ratings_count, 'vote'); ?>"> <?php echo $teube->w_rating ?></span>
			<?php else: ?>
			<span data-icon-before="s" class="teube-preview__rating" title="Aucune note pour le moment !" data-rating="NA"> -</span>
			<?php endif ?>
		</div>
	</div>
	<?php $teubeTimestamp = strtotime($teube->created); ?>
	<?php $teubeDate = date("d/m/Y à H:i", $teubeTimestamp); ?>
	<span data-icon-before="c" class="teube-preview__date" data-timestamp="<?php echo $teubeTimestamp*1000 ?>" title="Le <?php echo $teubeDate ?>"><?php echo strstr($teubeDate, 'à', true); ?></span>
</div>