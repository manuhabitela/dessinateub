(function() {
	var $teuboard = $("#teuboard");
	if ($teuboard.length) {
		$teuboard.addClass('hidden');
		$teuboard.height(
			$(window).height() - $('#container').outerHeight()
		);
		$teuboard.removeClass('hidden');
		var board = new DrawingBoard.Board('teuboard', {
			controls: [{ Color: {defaultColor: "rgba(255, 191, 127, 1)"}}, 'Size', 'Navigation']
		});
	}

	$('.teu').each(function(key, item) {
		console.log(item.innerHTML);
		item.innerHTML = item.innerHTML.replace(/teube/, 'teu<span class="be">be</span>');
	});
})();