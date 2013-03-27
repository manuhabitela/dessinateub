(function() {
	if ($('#teuboard').length)
		var board = new DrawingBoard.Board('teuboard', {
			controls: [{ Color: {defaultColor: "rgba(255, 191, 127, 1)"}}, 'Size', 'Navigation']
		});
})();