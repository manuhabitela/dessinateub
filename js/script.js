(function() {
	$('.teu').each(function(key, item) {
		item.innerHTML = item.innerHTML.replace(/teube(s|)/, 'teu<span class="pointbe">.</span>b<span class="pointbe">e</span>$1');
	});

	/**
	 * page de dessin de teube
	 */
	window.teuboard = new DrawingBoard.Board('teuboard', {
		color: "rgba(255, 191, 127, 1)",
		size: 5,
		localStorage: true,
		errorMessage: "<p>Votre navigateur est obsolète : mettez-le à jour pour pouvoir dessiner des teubs.</p>"
	});

	var existingImg = $('.teube-view') ? $('.teube-view').attr('data-url') : null;
	if (existingImg) {
		teuboard.setImg(existingImg);
	}

	$('.teube-add').on('submit', function(e) {
		$(this).find('input[name=image]').val( teuboard.getImg() );
	});
})();