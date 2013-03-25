		</div>

		<script>
			var _gaq=[['_setAccount','<?php echo APP_ANALYTICS ?>'],['_trackPageview']];
			(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
			g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
			s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
		<!-- dev : /js/script.js -->
		<?php $js = PROD ? 'script.min.js?v=58797562341' : 
			array('jquery.min.js', 'script.js');
		$t = time();
		if (is_string($js)): ?>
		<script src="/js/<?php echo $js ?>"></script>
		<?php else: foreach ($js as $script): ?>
		<script src="/js/<?php echo $js ?>?v=<?php echo $t ?>"></script>
		<?php endforeach; endif; ?>
	</body>
</html>
