(function() {
	$('.teu').each(function(key, item) {
		item.innerHTML = item.innerHTML.replace(/teub(s|)/, 'teu<span class="pointbe">.</span>b<span class="pointbe">e</span>$1');
	});


	if ($('html.draw').length) {
		window.teuboard = new DrawingBoard.Board('teuboard', {
			color: "rgba(255, 191, 127, 1)",
			size: 5,
			localStorage: true,
			errorMessage: "<p>Votre navigateur est obsolète : mettez-le à jour pour pouvoir dessiner des teubs.</p>"
		});
		var submitted = false;
		window.onbeforeunload = function() {
			if (!submitted && typeof window.teuboard.blankCanvas !== "undefined" && window.teuboard.blankCanvas !== window.teuboard.getImg())
				return "Attention : votre teube disparaitra à jamais si vous continuez.";
			else
				return;
		};

		$('.teube-add').on('submit', function(e) {
			var img = teuboard.getImg();
			var imgInput = (teuboard.blankCanvas == img) ? '' : img;
			$(this).find('input[name=image]').val( img );
			submitted = true;
		});
	}

	if ($('html.view').length) {
		window.teuboard = new DrawingBoard.Board('teuboardz', {
			color: "rgba(255, 191, 127, 1)",
			size: 5,
			localStorage: false,
			errorMessage: "<p>Votre navigateur est obsolète : mettez-le à jour pour pouvoir dessiner des teubs.</p>"
		});
		var existingImg = $('.teube-view') ? $('.teube-view').attr('data-url') : null;
		if (existingImg) {
			teuboard.setImg(existingImg);
		}
		$('#teube-url').on('click', function(e) { $(this).select(); });
	}
})();