<div class="teubes-list__pagination cf">
	<?php if (!empty($pageNb) && $pageNb > 1): ?>
	<a href="<?php echo Halp::pageURL($pageNb - 1) ?>" class="teubes-list__pagination-link teubes-list__pagination-link--prev">&larr; Page précédente</a>
	<?php else: ?>
	<span class="teubes-list__pagination-link teubes-list__pagination-link--prev">&larr; Page précédente</span>
	<?php endif ?>

	<?php if ($fullList): ?>
	<a href="<?php echo Halp::pageURL($pageNb + 1) ?>" class="teubes-list__pagination-link teubes-list__pagination-link--next">Page suivante &rarr;</a>
	<?php else: ?>
	<span class="teubes-list__pagination-link teubes-list__pagination-link--next">Page suivante &rarr;</span>
	<?php endif ?>
</div>