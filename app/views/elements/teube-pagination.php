<div class="teubes-list__pagination cf">
	<?php if (!empty($pageNb) && $pageNb > 1): ?>
	<a data-icon-before="l" href="<?php echo Halp::pageURL($pageNb - 1) ?>" class="teubes-list__pagination-link teubes-list__pagination-link--prev" title="Teubs précédentes"></a>
	<?php else: ?>
	<span data-icon-before="l" class="teubes-list__pagination-link teubes-list__pagination-link--prev" title="Teubs précédentes"></span>
	<?php endif ?>

	<span class="teubes-list__pagination-count">Page <?php echo $pageNb ?></span>

	<?php if ($fullList): ?>
	<a data-icon-after="r" href="<?php echo Halp::pageURL($pageNb + 1) ?>" class="teubes-list__pagination-link teubes-list__pagination-link--next" title="Teubs suivantes"></a>
	<?php else: ?>
	<span data-icon-after="r" class="teubes-list__pagination-link teubes-list__pagination-link--next" title="Teubs suivantes"></span>
	<?php endif ?>
</div>