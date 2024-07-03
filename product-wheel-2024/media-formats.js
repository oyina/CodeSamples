(function($) {
	const MF = {
		onReady: function() {
      const mediaFormats = $('.media_formats');
      if(mediaFormats.length > 0){
        
        //prevent unintended default clicks 
        $('.mf-desktop-nav a').on('click', function(e){
          e.preventDefault;
        });

        const windowSize = $(window).width();

        //creates the sliders
        MF.initSliders();
        
        //Mouseover eventlistener for Active Class on nav menu. Creates whi
        if (windowSize > 1024) {
          $('.mf-desktop-nav .mformat').on('mouseover', MF.formatTabHover);
        } else {
          //mobile eventlistener header click
          $('.mformat-header').on('click', MF.clickToOpenMobileTab);
        }
        
        //attach and detach
        $(window).resize(MF.responsive);

        //click listener that navigates through slides/formats on desktop and mobile
        $('.mf-desktop-nav .mformat .mformat-list li a').on('click', MF.clickToNavSlides);

        //on ready load the first format of each group
        MF.loadFirstOfEachFormat();
        
        //when page is loaded navigate to the format based on url hash
        MF.useURLToNavFormat();

        //on click handler for the show more sections on mobile
        $('.media_formats__best-for').on('click', MF.bestForClick);

        //when user mouseouts the nav revert to the current format tab
        $('.mf-desktop-nav').on('mouseout', MF.mouseOutNav);
      } 
		},
		//Add and remove active class to the highest level column on desktop
		formatTabHover: function(event) {
			//this refers mformat columns
			const allFormatTabs = $('.mf-desktop-nav .mformat');

			if (!$(this).hasClass('mformat-tab-active')) {
				allFormatTabs.removeClass('mformat-tab-active');
				$(this).addClass('mformat-tab-active');
			}
		},//toggles the NAV open and closed on mobile
		clickToOpenMobileTab: function() {
			//this refers mformat-header columns
			const parentTab = $(this).parents('.mformat');
			const allParentTabs = $('.mformat');
			const siblingBody = $(this).siblings('.mformat-body');
			const allFormatBodies = $('.mformat-body');

			if (!parentTab.hasClass('mformat-open')) {
				allFormatBodies.slideUp();
				allParentTabs.removeClass('mformat-open');
				parentTab.addClass('mformat-open');
				siblingBody.slideDown();
			} else {
				allParentTabs.removeClass('mformat-open');
				siblingBody.slideUp();
			}
		},//based on window size attach and detach event listeners for mobile and desktop
		responsive: function(w) {
			const windowSize = $(window).width();
			const allParentTabs = $('.mformat');
			const allFormatBodies = $('.mformat-body');

			//open all formats on desktop with slidedown
			//transfer active from 'mformat-open' to 'mformat-tab-active'
			if (windowSize > 1024) {
				//mobile tab click off -
				$('.mformat-header').off('click', MF.clickToOpenMobileTab);
				//remove mouseover event listener -  prevent duplication - circle back for better solution
				$('.mf-desktop-nav .mformat').off(
					'mouseover',
					MF.formatTabHover
				);
				//Mouseover eventlistener for Active Class
				$('.mf-desktop-nav .mformat').on(
					'mouseover',
					MF.formatTabHover
				);

				allFormatBodies.slideDown();

				allParentTabs.each(function(index, value) {
					if (
						$(this).hasClass('mformat-open') &&
						!$(this).hasClass('mformat-tab-active')
					) {
						$(this).removeClass('mformat-open');
						$(this).addClass('mformat-tab-active');
					}
				});
			}
			//close all formats on mobile with slideup
			//transfer active from 'mformat-tab-active' on desktop to 'mformat-open' on mobile
			else {
				//remove mouseover event listener
				$('.mf-desktop-nav .mformat').off(
					'mouseover',
					MF.formatTabHover
				);

				//mobile tab click off - first to prevent duplication
				$('.mformat-header').off('click', MF.clickToOpenMobileTab);
				//mobile tab click
				$('.mformat-header').on('click', MF.clickToOpenMobileTab);

				//hide all tabs except the active one
				allParentTabs.each(function(index, value) {
					if (
						$(this).hasClass('mformat-tab-active') &&
						!$(this).hasClass('mformat-open')
					) {
						allFormatBodies.slideUp();
						$(this).removeClass('mformat-tab-active');
						$(this).addClass('mformat-open ');
						$(this)
							.find('.mformat-body')
							.slideDown();
					}
				});
			}
		},//event listener for the links in nav modules
    clickToNavSlides: function(e){
      e.preventDefault();
      const parentSlideIndex = $(this).parents('.mformat').data('slide');
      const formatSlideIndex = $(".media_formats__formats-container [data-format='" + $(this).data('format-slug') +"']").data('slick-index');

     
      //load new video
      const format = $(".media_formats__formats-container [data-format='" + $(this).data('format-slug') +"']");
      const formatSiblings = format.siblings('.media_formats__format');

      //load first
      let videoSrc = format
        .find('.media_formats__media-embed')
        .data('video-src');

      if (videoSrc && videoSrc !== '') {
        MF.loadFormatVideo(format);
      }
      //then load siblings
      formatSiblings.each(function(){
        let videoSrc = $(this)
        .find('.media_formats__media-embed')
        .data('video-src');

        if (videoSrc && videoSrc !== '') {
          MF.loadFormatVideo($(this));
  
        }
      }).delay(1000);

     //nvatigate to slides
      $('.media_formats__products-container').slick(
        'slickGoTo',
        parentSlideIndex
      );

      $('.media_formats__formats-container').slick(
        'slickGoTo',
        formatSlideIndex
      );

      
      //remove video from formats that are not visible on mobile
      if($(window).width() < 1024){
        $(".media_formats__wrap:not(.slick-active)").find('.media_formats__media-embed iframe').each(function(){
          
            if($(this).attr('src')){
              $(this).attr('src', '');
            }
        });
      }

      $('.mformat-list li').removeClass('mformat-clicked');
      $(this).parents('li').addClass('mformat-clicked');
      
      //set url to id
      if (history.pushState) {
        history.pushState(null, null, '#' + $(this).data('format-slug'));
      } else {
        window.location.hash = $(this).data('format-slug');
      }


    },//loads an individual video for a format
    loadFormatVideo: (format) => {

			let preview = format.find('.media_formats__media-embed');
			let iframe = preview.find('.iframe-embed');
			let source = preview.data('video-src');
		

			if (iframe) {
				// if (
				// 	iframe
				// 		.contents()
				// 		.find('body')
				// 		.is(':empty')
				// ) 
        if(!iframe.attr('src'))
        {
          //console.log(format.attr('id') + 'this is being loaded ' + source);
					iframe.attr('src', source);
				}
			}
      //testing
			// if (iframe.attr('src') === source) {
			// 	console.log(format.attr('id') + ' url match');
			// } else {
			// 	console.log(format.attr('id') + ' url match fail');
			// }
		},//load first of each formats
    loadFirstOfEachFormat: function(){
      const activeProduct = $(
        '.media_formats__wrap.slick-current.slick-active'
      );
      const firstFormat = activeProduct.find('.media_formats__format').first();
      const activeProductFormats = firstFormat.siblings('.media_formats__format');

      //if format isnt in url
      if(!window.location.hash){
        //load the formats of whatever slide is active starting with the first visible
        let videoSrc = firstFormat
        .find('.media_formats__media-embed')
        .data('video-src');

        if (videoSrc && videoSrc !== '') {
         MF.loadFormatVideo(firstFormat);
        }
       
        activeProductFormats.each(function(){
            let videoSrc = $(this)
            .find('.media_formats__media-embed')
            .data('video-src');
  
            if (videoSrc && videoSrc !== '') {
              MF.loadFormatVideo($(this));
            }
        }).delay(2000);
    
      } else {
        const format = $(window.location.hash);
        const formatSiblings = $(window.location.hash).siblings('.media_formats__format');
        //load first
        let videoSrc = format
          .find('.media_formats__media-embed')
          .data('video-src');

        if (videoSrc && videoSrc !== '') {
          MF.loadFormatVideo(format);
        }
        //then siblings
        formatSiblings.each(function(){
          let videoSrc = $(this)
          .find('.media_formats__media-embed')
          .data('video-src');

          if (videoSrc && videoSrc !== '') {
            MF.loadFormatVideo($(this));
          }
        }).delay(1000);
      }
    },
    //load rest of format
    //loads the visible formats video or all formats videos
    loadAllVideos: function(){
      //load all videos
		  let formatActive = $(
        '.media_formats__format'
      );
   
      
      formatActive.each(function() {
        let videoSrc = $(this)
          .find('.media_formats__media-embed')
          .data('video-src');
    
        if (videoSrc) {
          MF.loadFormatVideo($(this));
        }
      });
    },
    useURLToNavFormat: function(){
      //on page load navigate to format and set hover states
      let currentFormatID = window.location.hash;
      const formatsArray = $('#formatsArray').data('formatsids');
      const currentFormatIdString = currentFormatID.replace('#', '');

      //check against format array and then navigate to format
      if (formatsArray.includes(currentFormatIdString)) {
        /*currentFormatID && !'#product-portfolio'*/
			const format = $(currentFormatID);
			const formatIndex = $(currentFormatID).attr('data-slick-index');
			const formatListItemA = $("[data-format-slug='" + currentFormatIdString +"']");
			const formatParentIndex = format
				.closest('.media_formats__wrap')
				.attr('data-slick-index');

        $('.media_formats__products-container').slick(
					'slickGoTo',
					formatParentIndex
				);
				$('.media_formats__formats-container').slick(
					'slickGoTo',
					formatIndex
				);

        //add hover state to format's li tag and format's tab
        formatListItemA.parent('li').addClass('mformat-clicked');
        
        if($(window).width() > 1024) {
          formatListItemA.parents('.mformat').addClass('mformat-tab-active');
        } else {
          formatListItemA.parents('.mformat').addClass('mformat-open');
          formatListItemA.parents('.mformat-body').slideDown();
        }
      }
    },
    initSliders: function() {
      const productSlider = $('.media_formats__products-container');
			//Product Desktop Slider
			const settings = {
				arrows: false,
				dots: false,
				infinite: false,
				speed: 500,
				fade: true,
				//slide: '.media_formats__product',
				slidesToShow: 1,
				slidesToScroll: 1,
				autoplaySpeed: 5000,
				cssEase: 'cubic-bezier(0.87, 0.03, 0.41, 0.9)',
				mobileFirst: false,
				draggable: false,
				swipe: false,
				//asNavFor: gradientNav
				responsive: [
					{
						breakpoint: 1024,
						settings: {
							draggable: false,
							swipe: false,
						},
					},
				],
			};

			//Formats Slider
			$('.media_formats__formats-container').each(function() {
				const items = $(this)
					.siblings('.media_formats__secondary-nav')
					.find('.media_formats__secondary-items');
				const idFormat = $(this).attr('id');
				$(this).slick({
					arrows: true,
          dots: false,
          appendDots: $(this).find(
            '.media_formats__dots'
          ),
          nextArrow:
          $(this).find('.media_formats__slide-arrow--next'),
          prevArrow:
          $(this).find('.media_formats__slide-arrow--prev'),
					infinite: false,
					fade: true,
					speed: 500,
					//slide: '.media_formats__format',
					slidesToShow: 1,
					slidesToScroll: 1,
					autoplay: false,
					cssEase: 'cubic-bezier(0.87, 0.03, 0.41, 0.9)',
					//asNavFor: items,
					initialSlide: 0,
					responsive: [
						{
							breakpoint: 1024,
							settings: {
								fade: true,
								arrows: true,
								dots: false,
								appendDots: $(this).find(
									'.media_formats__dots'
								),
								nextArrow:
                $(this).find('.media_formats__slide-arrow--next'),
								prevArrow:
                $(this).find('.media_formats__slide-arrow--prev'),
							},
						},
					],
				});
			});
      productSlider.slick(settings);
    },
    bestForClick: function() {
			if ($(window).width() < 1024) {
				$(this).toggleClass('media_formats__best-for--opened');

				if ($(this).hasClass('media_formats__best-for--opened')) {
					$(this)
						.find('.media_formats_read-more--text')
						.html('Show Less');
				} else {
					$(this)
						.find('.media_formats_read-more--text')
						.html('Show More');
				}
				$(this)
					.siblings('.media_formats__long-desc')
					.animate({ height: 'toggle', opacity: 'toggle' }, 'fast');
			}
		},//mouseout of nav, reset tab to active format
    mouseOutNav: function() {
      if($(window).width() > 1024) {
        const currentFormat = $('.mformat-clicked').parents('.mformat');
        const allProducts = $('.mformat');
        allProducts.removeClass('mformat-tab-active');
        currentFormat.addClass('mformat-tab-active');
      }
    }
	};

	$(document).ready(MF.onReady);
})(jQuery);
