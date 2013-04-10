(function() {
	window.teuboard = new DrawingBoard.Board('teuboard', {
		color: "rgba(255, 191, 127, 1)",
		size: 5,
		localStorage: true
	});

	$('.teu').each(function(key, item) {
		item.innerHTML = item.innerHTML.replace(/teube(s|)/, 'teu<span class="pointbe">.</span>b<span class="pointbe">e</span>$1');
	});
})();