<div class="teube-preview">
	<a class="teube-preview__link" href="<?php echo $app->urlFor('regarder', array('slug' => $teube->id)) ?>">
		<img class="teube-preview__img" src="<?php echo Halp::drawing($teube) ?>" alt="<?php echo $teube->name ?>">
		<p class="teube-preview__title blue-button"><?php echo $teube->name ?></p>
	</a>
	<a class="teubes-list__comment-count" href="<?php echo HOST.$app->urlFor('regarder', array('slug' => $teube->id)) ?>#disqus_thread"></a>
</div>