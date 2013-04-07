(function() {
	var $teuboard = $("#teuboard");
	if ($teuboard.length) {
		$teuboard.addClass('hidden');
		$teuboard.height(
			$(window).height() - $('#container').outerHeight()
		);
		$teuboard.removeClass('hidden');
		window.teuboard = new DrawingBoard.Board('teuboard', {
			color: "rgba(255, 191, 127, 1)",
			size: 5
		});
	}

	$('.teu').each(function(key, item) {
		item.innerHTML = item.innerHTML.replace(/teube/, 'teu<span class="point">.</span>b<span class="be">e</span>');
	});
})();