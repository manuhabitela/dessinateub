//méthode rache mothafucka
(function() {


	/**
	 * GLOBAL
	 */

	var html = $('html');

	//transformation de toutes les "teubs" en "teu.bes" au survol de la souris
	$('.teu').each(function(key, item) {
		item.innerHTML = item.innerHTML.replace(/teub(s|)/, 'teu<span class="pointbe">.</span>b<span class="pointbe">e</span>$1');
	});

	//ajout d'une classe current sur tous les liens concernant la page actuelle
	//ouais, la flemme de faire ça côté serveur
	$('a').each(function(key, item) {
		var $item = $(item);
		if (isCurrentURL($item.attr('href')))
			$item.addClass('current').attr('title', 'Vous êtes actuellement sur cette page');
	});

	//activation de disqus sur toutes les pages qui doivent l'afficher
	if ($('#disqus_thread').length) {
		(function() {
			var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
			dsq.src = '//jaiunegrosseteu.disqus.com/embed.js';
			(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		})();
	}

	var teuboard = null;
	//activation du drawingboard sur toutes les pages qui doivent l'afficher
	if ($('#teuboard').length) {
		var teubopts = {
			color: "rgba(255, 191, 127, 1)",
			size: 5,
			errorMessage: "<p>Votre navigateur est obsolète : mettez-le à jour pour pouvoir dessiner des teubs.</p>"
		};
		if (html.hasClass('page--view'))
			teubopts.webStorage = false;
		teuboard = new DrawingBoard.Board('teuboard', teubopts);
	}



	/**
	 * PAGE DE CREATION/EDITION
	 */

	if (html.hasClass('page--draw')) {
		$('.teube--draw').on('submit', function(e) {
			var img = teuboard.getImg();
			var imgInput = (teuboard.blankCanvas == img) ? '' : img;
			$(this).find('input[name=image]').val( imgInput );
			teuboard.clearWebStorage();
		});
	}



	/**
	 * PAGE DE VUE
	 */

	if (html.hasClass('page--view')) {
		var existingImg = $('.teube--view') ? $('.teube--view').attr('data-url') : null;
		if (existingImg)
			teuboard.setImg(existingImg);

		$('.teube__delete-link').on('click', function(e) {
			if (confirm("T'es sûr ?"))
				teuboard.clearWebStorage();
			else
				e.preventDefault();
		});

		$('#teube-url')
			.on('click', function(e) {
				$(this).select();
				$(this).prev('.teu').addClass('active');
			})
			.on('blur', function(e) {
				$(this).prev('.teu').removeClass('active');
			});

		$('.teube__vote input[name="teube-vote"]').on('change', function(e) {
			$.ajax({
				url: '/a-voter/' + $('.teube__vote input[name="teube-id"]').val(),
				method: 'POST',
				data: {
					value: $(this).val(),
					fingerprint: new Fingerprint().get()
				}
			});
		});

		$.ajax({
			url: '/ancien-vote/' + $('.teube__vote input[name="teube-id"]').val(),
			method: 'GET',
			data: {
				fingerprint: new Fingerprint().get()
			},
			success: function(e) {

			}
		});
	}



	/**
	 * PAGE DE LISTE
	 */

	if (html.hasClass('page--list')) {
		$('.teube-list__item img').on('error', function(e) {
			$(this).closest('.teube-list__item').addClass('hidden');
		});

		$('.teubes-list-sorter a').each(function(key, item) {
			var $item = $(item);
			if (isCurrentURL($item.attr('href')))
				$item.parent('li').addClass('hidden');
		});

		(function () {
			var s = document.createElement('script'); s.async = true; s.type = 'text/javascript';
			s.src = 'http://jaiunegrosseteu.disqus.com/count.js';
			(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
		}());
	}


	/**
	 * helpers
	 */
	function isCurrentURL(url) {
		return (url.toLowerCase() === (window.location.pathname + window.location.search).toLowerCase()) ||
				(url.toLowerCase() === window.location.href.toLowerCase());
	}
})();