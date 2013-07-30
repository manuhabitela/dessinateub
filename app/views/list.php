<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/head.php'); ?>

<div class="teubes-list">
<?php foreach ($teubes as $teube): ?>
	<div class="teube-list-item">
		<a href="<?php echo $app->urlFor('regarder', array('slug' => $teube->id)) ?>">
			<img src="<?php echo Halp::drawing($teube) ?>" alt="<?php echo $teube->name ?>">
			<p><?php echo $teube->name ?></p>
		</a>
	</div>
<?php endforeach ?>
</div>

<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/foot.php'); ?>