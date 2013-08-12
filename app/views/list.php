<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/head.php'); ?>

<div class="teubes-list cf">
<?php foreach ($teubes as $teube): ?>
	<div class="teubes-list__item">
		<?php include(__DIR__ . '/elements/teube-preview.php'); ?>
	</div>
<?php endforeach ?>
</div>

<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/foot.php'); ?>