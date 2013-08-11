<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/head.php'); ?>

<div class="teubes-list-sorter">
	<p>Voir :</p>
	<ul>
		<li class="duo"><a href="/teubes?ordre=nouvelles">les dernières créations</a> /</li>
		<li class="duo"><a href="/teubes?ordre=anciennes">les premières</a> &nbsp;-&nbsp;</li>
		<li class="duo"><a href="/teubes?ordre=belles">les plus belles</a> /</li>
		<li class="duo"><a href="/teubes?ordre=moches">les plus moches</a> &nbsp;-&nbsp;</li>
		<li><a href="/teubes?ordre=kamoulox">celles dont on parle le plus</a></li>
	</ul>
</div>

<div class="teubes-list">
<?php foreach ($teubes as $teube): ?>
	<div class="teubes-list__item">
		<?php include(__DIR__ . '/elements/teube-preview.php'); ?>
	</div>
<?php endforeach ?>
</div>

<?php if (!$app->request()->isAjax()) include(__DIR__ . '/layout/foot.php'); ?>