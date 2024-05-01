/* eslint-disable */
(function($) {
	if($('.page-template-2023-press-section')){

	
	/*intialize announce/news slider */
	$('.an-slider').slick({
		nextArrow: $('.announce_news__nav-item--2'),
		prevArrow: $('.announce_news__nav-item--1'),
		infinite: false,
		mobileFirst: false,
		draggable: false,
		swipe: false,
		fade: true,
		cssEase: 'linear',
		responsive: [
			{
				breakpoint: 768,
				settings: {
					draggable: false,
					swipe: false,
					nextArrow: $('.announce_news__tab--2'),
					prevArrow: $('.announce_news__tab--1'),
				},
			},
		],
	});

	/* Navigates Announce/News Slide based on url anchor */
	if (
		window.location.hash === '#news' ||
		window.location.hash === '#announcements'
	) {
		if (window.location.hash === '#announcements') {
			$('.an-slider').slick('slickGoTo', 0);
		}
		if (window.location.hash === '#news') {
			$('.an-slider').slick('slickGoTo', 1);
			$('.slick-slide').toggleClass('height-zero');
		}

		$('.announce_news__nav-item').removeClass(
			'announce_news__nav-item--active'
		);
		$('.announce_news__nav-item[data-nav-slide=1]').addClass(
			'announce_news__nav-item--active'
		);

		$('.announce_news__tab').removeClass('announce_news__tab--active');
		$('.announce_news__tab[data-tab-slide=1]').addClass(
			'announce_news__tab--active'
		);
	}

	/** Mobile Gradient Tab - Click to change slide */
	$('.announce_news__tab').on('click', function(e) {
		let slide = $(this).data('tab-slide');
		$('.slick-slide').toggleClass('height-zero');

		$('.announce_news__tab').removeClass('announce_news__tab--active');
		$(this).addClass('announce_news__tab--active');

		$('.announce_news__nav-item').removeClass(
			'announce_news__nav-item--active'
		);
		$('.announce_news__nav-item[data-nav-slide=' + slide + ']').addClass(
			'announce_news__nav-item--active'
		);
	});

	/** Gradient Nav - Click to change slide */
	$('.announce_news__nav-item').on('click', function(e) {
		let slide = $(this).data('nav-slide');
		$('.slick-slide').toggleClass('height-zero');

		$('.announce_news__nav-item').removeClass(
			'announce_news__nav-item--active'
		);
		$(this).addClass('announce_news__nav-item--active');

		$('.announce_news__tab').removeClass('announce_news__tab--active');
		$('.announce_news__tab[data-nav-slide=' + slide + ']').addClass(
			'announce_news__tab--active'
		);
	});

	/* Clear URL and Reset FacetWP */
	function clearUrlParams() {
		//FWP.reset();
		//clear url
		let uri = window.location.href;

		if (uri.indexOf('?') > 0) {
			var clean_uri = uri.substring(0, uri.indexOf('?'));
			window.history.replaceState({}, document.title, clean_uri);
		}
	}
	/** Gradient Nav - Reset facet filters on click */
	$('.announce_news__nav-item').on('click', clearUrlParams);

	/** Gradient Tab - Reset facet filters on click */
	$('.announce_news__tab').on('click', clearUrlParams);

	/* News - Toggle Year Filter Drop Down*/
	$('.select-list .title').on('click', function(e) {
		$('.select-options').toggle();
		$(this).toggleClass('open');
	});

	/* News - Year Filter checkboxes*/
	$('.select-checkboxes').on('change', function() {
		let myCheckboxes = new Array();
		$('.option input:checked').each(function() {
			myCheckboxes.push($(this).val());
		});


		$('#an-search').val('');

		$.ajax({
			type: 'POST',
			url: '/wp-admin/admin-ajax.php',
			dataType: 'html',
			data: {
				action: 'filter_news_category',
				year: myCheckboxes,
			},
			success: function(res) {
				$('.an-news-list').html(res);
			},
		});
	});

	/* News - Search Enter Keypress*/
	$('#an-search').keypress(function(e) {
		if (e.which == 13) {
			$('.select-checkboxes').prop('checked', false);

			$.ajax({
				type: 'POST',
				url: '/wp-admin/admin-ajax.php',
				dataType: 'html',
				data: {
					action: 'filter_news_category',
					search: $('#an-search').val(),
				},
				success: function(res) {
					$('.an-news-list').html(res);
				},
			});
		}
	});

	/* News - Search Icon Click*/
	$('#news-search .facetwp-icon').on('click', function() {
		
		if ($('#an-search').val()) {
			$('.select-checkboxes').prop('checked', false);
			$.ajax({
				type: 'POST',
				url: '/wp-admin/admin-ajax.php',
				dataType: 'html',
				data: {
					action: 'filter_news_category',
					search: $('#an-search').val(),
				},
				success: function(res) {
					$('.an-news-list').html(res);
				},
			});
		}
	});

	/* News - Pagination - Click to navigate results pages for Years or Search*/
	$('.an-news-list').on('click', '.an-pagination', function(e) {
		//FWP.reset();
		//clear url
		e.preventDefault();
		let myCheckboxes = new Array();
		$('.option input:checked').each(function() {
			myCheckboxes.push($(this).val());
		});
		console.log($(this).data('page'));
		$.ajax({
			type: 'POST',
			url: '/wp-admin/admin-ajax.php',
			dataType: 'html',
			data: {
				action: 'filter_news_category',
				year: myCheckboxes,
				search: $('#an-search').val(),
				page: $(this).data('page'),
			},
			success: function(res) {
				$('.an-news-list').html(res);
				let page = $('.announce_news__pagination').data('current-page');
				$('.an-news-list [data-page="' + page + '"]').addClass(
					'active'
				);
			},
		});
	});

	/* Upcoming Event - Slider */
	$('.upcoming_events__slider').slick({
		arrows: true,
		dots: true,
		infinite: false,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 769,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	/* Timeline - Slider */
	$('.timeline__slider').slick({
		arrows: true,
		dots: true,
		infinite: false,
		slidesToShow: 1,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});
	$('.timeline__navigation').on('click', '.timeline__dot', function(e) {
		$('.timeline__slider').slick('slickGoTo', $(this).data('target-slide'));
		$('.timeline__dot').removeClass('timeline__dot--active');
		$(this).addClass('timeline__dot--active');
	});

	$('.slick-arrow ').on('click', function() {
		let index = $('.timeline__slider').slick('slickCurrentSlide');
		$('.timeline__dot').removeClass('timeline__dot--active');
		$('.timeline__dot[data-target-slide="' + index + '"]').addClass(
			'timeline__dot--active'
		);
	});
}
})(jQuery);
