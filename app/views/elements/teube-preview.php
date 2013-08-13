<div class="teube-preview">
	<a class="teube-preview__link" href="<?php echo HOST.$app->urlFor('regarder', array('slug' => $teube->id)) ?>">
		<div class="teube-preview__img-wrapper">
			<div>
				<img src="<?php echo Halp::drawing($teube) ?>" alt="<?php echo $teube->name ?>">
			</div>
		</div>
		<p class="teube-preview__title"><?php echo $teube->name ?></p>
	</a>
	<a data-icon-after="b" class="teube-preview__comment-count" title="Nombre de commentaires" href="<?php echo HOST.$app->urlFor('regarder', array('slug' => $teube->id)) ?>#disqus_thread" data-disqus-identifier="teube-<?php echo $teube->id ?>"></a>
	<?php if (!empty($teube->rating)): ?>
	<span data-icon-before="s" class="teube-preview__rating" title="Note : <?php echo $teube->rating ?> sur 5"> <?php echo $teube->rating ?></span>
	<?php else: ?>
	<span data-icon-before="s" class="teube-preview__rating" title="Aucune note pour le moment !" data-rating="NA"> -</span>
	<?php endif ?>
</div>