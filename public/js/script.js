//méthode rache mothafucka
(function() {


	/**
	 * GLOBAL
	 */
	window.disqus_shortname = 'jaiunegrosseteu';

	var $html = $('html');

	//transformation de toutes les "teubs" en "teu.bes" au survol de la souris
	$('.teu').each(function(key, item) {
		item.innerHTML = item.innerHTML.replace(/teub(s|)/, 'teu<span class="pointbe">.</span>b<span class="pointbe">e</span>$1');
	});

	//momentjs : transformation de toutes les dates en indication relative à aujourd'hui ("il y a 3 jours")
	moment.lang('fr');
	$('[data-timestamp]').each(function(key, item) {
		var $item = $(item);
		$item.html( moment(($item.attr('data-timestamp'))*1).fromNow() );
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
			dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
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
		teuboard = new DrawingBoard.Board('teuboard', teubopts);
		if (!Modernizr.canvas) {
			teuboard.$el.css('height', 'auto');
		}
	}



	/**
	 * PAGE DE CREATION/EDITION
	 */

	if ($html.hasClass('page--draw')) {
		$drawing = $('.teube-drawing');
		if ($drawing.attr('data-url'))
			teuboard.setImg( $drawing.attr('data-url') );
		$drawing.on('submit', function(e) {
			var img = teuboard.getImg();
			var imgInput = (teuboard.blankCanvas == img) ? '' : img;
			$(this).find('input[name=image]').val( imgInput );
			teuboard.clearWebStorage();
		});
	}



	/**
	 * PAGE DE VUE
	 */

	if ($html.hasClass('page--view')) {
		window.disqus_identifier = $('.teube-view') ? 'teube-' + $('.teube-view').attr('data-id') : null;
		var teubeId = $('.teube-view').attr('data-id');

		$('.teube-view__delete-link').on('click', function(e) {
			if (confirm("T'es sûr ?"))
				teuboard.clearWebStorage();
			else
				e.preventDefault();
		});

		$('.teube-view__report-form').on('submit', function(e) {
			if (!confirm(["En validant ceci, tu vas notifier l'administrateur que cette teub a un problème.\n" +
			"Le \"problème\" étant qu'elle peut être vraiment dégueulasse, atteinte d'un gros bug, etc.\n\nEs-tu sûr de vouloir continuer ?"].join('')))
				e.preventDefault();
		});

		$('input[name="teube-vote"][value="' + $('.teube-view').attr('data-rating') +'"]').attr('checked', 'checked');

		$('.teube-view__vote input[name="teube-vote"]').on('change', function(e) {
			$.ajax({
				url: '/a-voter/' + teubeId,
				method: 'POST',
				data: {
					value: $(this).val(),
					fingerprint: new Fingerprint().get()
				}
			});
		});

		$.ajax({
			url: '/ancien-vote/' + teubeId,
			method: 'GET',
			data: {
				fingerprint: new Fingerprint().get()
			},
			success: function(data, status) {
				if (status === "success" && data && data.vote) {
					$('.teube-view__user-vote > span').text(data.vote);
				}
			}
		});

		$.ajax({ url: '/update-pageviews/' + teubeId, method: 'GET' });
	}



	/**
	 * PAGE DE LISTE
	 */

	if ($html.hasClass('page--list')) {
		$('.teube-list__item img').on('error', function(e) {
			$(this).closest('.teube-list__item').addClass('hidden');
		});

		$('.teubes-list').on('focus', '.teube-preview__link, .teube-preview__comment-count', function(e) {
			$(this).closest('.teube-preview').addClass('teube-preview--active');
		});
		$('.teubes-list').on('blur', '.teube-preview__link, .teube-preview__comment-count', function(e) {
			$(this).closest('.teube-preview').removeClass('teube-preview--active');
		});

		(function () {
			var s = document.createElement('script'); s.async = true; s.type = 'text/javascript';
			s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
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