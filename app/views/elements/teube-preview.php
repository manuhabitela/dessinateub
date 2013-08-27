<div class="teube-preview">
	<a class="teube-preview__link" href="<?php echo HOST.$app->urlFor('regarder', array('slug' => $teube->id)).(!empty($sort) ? "?ordre=".$sort : '') ?>">
		<div class="teube-preview__img-wrapper">
			<div>
				<img src="<?php echo Halp::drawing($teube) ?>" alt="<?php echo $teube->name ?>">
			</div>
		</div>
		<p class="teube-preview__title" title="<?php echo $teube->name.($teube->artist ? " par ".$teube->artist : '') ?>"><?php echo $teube->name ?></p>
	</a>
	<div class="teube-preview__info-wrapper">
		<div>
			<a data-icon-after="b" class="teube-preview__comment-count" title="Nombre de commentaires" href="<?php echo HOST.$app->urlFor('regarder', array('slug' => $teube->id)) ?>#disqus_thread" data-disqus-identifier="teube-<?php echo $teube->id ?>"></a>
			<?php if (!empty($teube->w_rating)): ?>
			<span data-icon-before="s" class="teube-preview__rating" title="<?php echo $teube->ratings_count.' '.Halp::pluralize('vote', $teube->ratings_count); ?>"> <?php echo $teube->w_rating ?></span>
			<?php else: ?>
			<span data-icon-before="s" class="teube-preview__rating" title="Aucune note pour le moment !" data-rating="NA"> -</span>
			<?php endif ?>
		</div>
	</div>
	<?php $teubeTimestamp = strtotime($teube->created); ?>
	<?php $teubeDate = date("d/m/Y à H:i", $teubeTimestamp); ?>
	<span data-icon-before="c" class="teube-preview__date" data-timestamp="<?php echo $teubeTimestamp*1000 ?>" title="Le <?php echo $teubeDate ?>"><?php echo strstr($teubeDate, 'à', true); ?></span>
</div>