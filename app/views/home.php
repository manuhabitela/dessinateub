<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/head.php'); ?>

<?php $teulists = array($nouvelles, $belles, $moches);
foreach ($teulists as $list): ?>
<div class="teubes-list cf">
	<h2 class="teubes-list__title teu"><?php echo $list["title"] ?></h2>

	<div class="teubes-list__items-wrapper cf">
		<?php foreach ($list["teubes"] as $teube): ?>
		<div class="teubes-list__item">
			<?php include(__DIR__ . '/elements/teube-preview.php'); ?>
		</div>
		<?php endforeach ?>
	</div>

	<a href="/mater?ordre=<?php echo $list['sort'] ?>" class="teubes-list__see-more" data-icon-after="r">Voir toutes <?php echo lcfirst($list["title"]) ?>&nbsp;</a>
</div>
<?php endforeach ?>

<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/foot.php'); ?>