		</div>

		<script>
			var _gaq=[['_setAccount','<?php echo APP_ANALYTICS ?>'],['_trackPageview']];
			(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
			g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
			s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
		<!-- dev : /js/script.js -->
		<?php $js = PROD ? '/js/script.min.js?v=58797562341' :
			array('/components/jquery/jquery.min.js', '/components/drawingboard.js/dist/drawingboard.min.js', '/js/script.js');
		$t = time();
		if (is_string($js)): ?>
		<script src="<?php echo $js ?>"></script>
		<?php else: foreach ($js as $script): ?>
		<script src="<?php echo $script ?>?v=<?php echo $t ?>"></script>
		<?php endforeach; endif; ?>
	</body>
</html>
