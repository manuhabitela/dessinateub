		<?php if (CURRENT === "/"): ?>
			<div class="justdoit">
				<a href="<?php echo $app->urlFor('draw'); ?>" class="teu button">Je dessine ma teub</a>
			</div>
		<?php endif ?>
		</div>

		<p class="cf credits teu">
			Fait avec amour par <a href="http://manu.habite.la" target="_blank">Leimi</a>.
		</p>

		<!-- dev : /js/script.js -->
		<?php $js = PROD ? 'http://stateuic.habite.la/js/scripts.'.APP_VERSION.'.min.js' :
			array('/components/jquery/jquery.min.js', '/components/drawingboard.js/dist/drawingboard.js', '/components/moment/moment.js', '/components/moment/min/lang/fr.js', '/components/color-thief/js/color-thief.js', '/js/fingerprint.js', '/js/detect.js', '/js/script.js');
		$t = time();
		if (is_string($js)): ?>
		<script src="<?php echo $js ?>"></script>
		<?php else: foreach ($js as $script): ?>
		<script src="<?php echo $script ?>?v=<?php echo $t ?>"></script>
		<?php endforeach; endif; ?>

		<?php include(__DIR__ . '/../elements/piwik.php'); ?>
	</body>
</html>
