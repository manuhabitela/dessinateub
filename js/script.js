(function() {
	if ($('#teuboard').length)
		var board = new DrawingBoard.Board('teuboard', {
			controls: [{ Color: {defaultColor: "rgba(255, 191, 127, 1)"}}, 'Size', 'Navigation']
		});
	$('.teu').each(function(key, item) {
		console.log(item.innerHTML);
		item.innerHTML = item.innerHTML.replace(/teube/, 'teu<span class="be">be</span>');
	});
})();