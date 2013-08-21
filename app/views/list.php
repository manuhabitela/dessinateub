<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/head.php'); ?>

<div class="teubes-list cf">
	<h2 class="teubes-list__title teu"><?php echo $title ?></h2>

	<?php if (!empty($teubes)): ?>

	<div class="teubes-list__items-wrapper cf">
		<?php foreach ($teubes as $teube): ?>
		<div class="teubes-list__item">
			<?php include(__DIR__ . '/elements/teube-preview.php'); ?>
		</div>
		<?php endforeach ?>
	</div>

	<?php include(__DIR__ . '/elements/teube-pagination.php'); ?>

	<?php else: ?>
		<p class="teubes-list__empty-warning">
			Il n'y a plus rien !
			<?php if (!empty($pageNb)): ?>
			<?php if ($pageNb > 1): ?>
			<a href="<?php echo Halp::pageURL($pageNb - 1) ?>">Retourner à la page précédente.</a>
			<?php endif ?>
			<a href="<?php echo Halp::pageURL(1) ?>">Retourner à la première page.</a>
			<?php endif ?>
		</p>
	<?php endif ?>
</div>

<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/foot.php'); ?>