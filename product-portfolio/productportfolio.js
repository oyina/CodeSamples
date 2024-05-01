/* eslint-disable */
(function($) {

    const productPorfolio = $('.product_portfolio');

    const ProductPortfolioInit = () => {

    let currentFormatID = window.location.hash;
    const intialWindowSize = $(window).width();

    const gradientNav = $('.product_portfolio__gradient-nav');
    const productSlider = $('.product_portfolio__products-container');
    const formatsArray = $('#formatsArray').data('formatsids');
    
    
    //Product Desktop Slider
    const settings = {
        arrows: false,
        dots: false,
        infinite: false,
        speed: 500,
        fade: true,
        //slide: '.product_portfolio__product',
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplaySpeed: 5000,
        cssEase:"cubic-bezier(0.87, 0.03, 0.41, 0.9)",
        mobileFirst: false,
        draggable: false,
        swipe: false,
        //asNavFor: gradientNav
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                  draggable: false,
                  swipe: false
              }
            }]
    };


    //Initalize desktop slider if not mobile
    if ($(window).width() > 1024) {
        productSlider.slick(settings);
    }

    //Formats Slider
    $('.product_portfolio__formats-container').each(function(){
        const items = $(this).siblings('.product_portfolio__secondary-nav').find('.product_portfolio__secondary-items');
        const idFormat = $(this).attr("id");
        $(this).slick({
          arrows: false,
          dots: false,
          infinite: false,
          fade: true,
          speed: 500,
          //slide: '.product_portfolio__format',
          slidesToShow: 1,
          slidesToScroll: 1,
          autoplay: false,
          cssEase:"cubic-bezier(0.87, 0.03, 0.41, 0.9)",
          asNavFor: items,
          initialSlide: 0, 
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                fade: true,
                arrows: true,
                dots: false,
                appendDots: $(this).find('.product_portfolio__dots'),
                nextArrow: '.product_portfolio__slide-arrow--next',
                prevArrow: '.product_portfolio__slide-arrow--prev'
              }
            }]
          
    });
        
        const itemsToShow = items.children().length > 3 ? (.571) * items.children().length : items.children().length;
        //const itemsToShow = (.571) * items.children().length;
        const itemsToScroll = items.children().length > 3 ? 1 : items.children().length;
        //const itemsToScroll = 1;


    //Secondary Nav Slider    
    items.slick({
            slidesToShow: items.children().length,
            slidesToScroll: items.children().length,
            speed: 500,
            asNavFor: $(this),
            arrows: false,
            dots: false,
            centerMode: false,
            focusOnSelect: true,
            infinite: false,
            initialSlide: 0, 
            responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: itemsToShow,
                    slidesToScroll: itemsToScroll,
                    infinite: false,
                    //centerMode: true,
                    swipeToSlide: true,
                    variableWidth: true
                  }
                }]
      
    });

    });
    
    //function to load video for format
    const loadFormatVideo = (format) => {
        $('.iframe-embed').each( iframe => {
            //$(this).attr('src', '');
        });
        let preview = format.find('.product_portfolio__media-embed');
        let iframe = preview.find('.iframe-embed');
        let source = preview.data('video-src');
        console.log(format.attr('id') + ' loading url: ' + source);
        if ( iframe ) {
            if(iframe.contents().find("body").is(':empty')){
                iframe.attr('src',source);
            }
            
        }

        if(iframe.attr('src') === source){
            console.log(format.attr('id') + ' url match');
        } else {
            console.log(format.attr('id') + ' url match fail');
        }
    
    }

    

    //load for first fromat
    let formatActive = $('.product_portfolio__wrap.slick-current.slick-active .product_portfolio__format.slick-current.slick-active');
    let videoSrc = formatActive.find('.product_portfolio__media-embed').data('video-src');

    
    //if mobile loop through firsts and load those else load only first
    if ($(window).width() < 1024) {
        formatActive = $('.product_portfolio__wrap .product_portfolio__format.slick-current.slick-active');
        
        formatActive.each(function(){
            videoSrc = $(this).find('.product_portfolio__media-embed').data('video-src');
            if (videoSrc) {
                loadFormatVideo($(this));
            }
            
        });

    } else {
        if (videoSrc) loadFormatVideo(formatActive);
    }

    //navigate to slide if id exists but not if the page id is not a format id 
    const currentFormatIdString = currentFormatID.replace('#','');
    if(formatsArray.includes(currentFormatIdString)) {
        /*currentFormatID && !'#product-portfolio'*/
        const format = $(currentFormatID);
        const formatIndex =  $(currentFormatID).attr("data-slick-index");
        const formatParent = format.closest('.product_portfolio__wrap');
        const formatParentIndex = format.closest('.product_portfolio__wrap').attr("data-slick-index");

   
        if ($(window).width() < 1024) {
            $('.product_portfolio__product').slideUp();
            $('.product_portfolio__product').removeClass('product_portfolio__tab-active');
           
            $('.product_portfolio__tab').removeClass('product_portfolio__tab-is-active');
            formatParent.children('.product_portfolio__tab').addClass('product_portfolio__tab-is-active');
            $('.product_portfolio__formats-container').slick('slickGoTo', formatIndex);
            formatParent.children('.product_portfolio__product').children('.product_portfolio__formats-container').slick('refresh');
            
            // $(this).toggleClass('active');
            formatParent.children('.product_portfolio__product').toggleClass('product_portfolio__tab-active');
            
            formatParent.children('product_portfolio__tab-is-active');

            formatParent.children('.product_portfolio__product').animate({ height: 'toggle', opacity: 'toggle' }, 'fast');

            

        } else {
            //navigate to the slide
            $('[data-slide]').removeClass('product_portfolio__nav-item--active');
            $('[data-slide="'+formatParentIndex+'"]').addClass('product_portfolio__nav-item--active');
            $('.product_portfolio__products-container').slick('slickGoTo', formatParentIndex);
            $('.product_portfolio__formats-container').slick('slickGoTo', formatIndex);
            
        }
       

        //load video
        loadFormatVideo(format);
         
    } else {
        //auto close accordions
        if ($(window).width() < 1024) {
            //$('.product_portfolio__product').eq(0).animate({ height: 'toggle', opacity: 'toggle' }, 'fast');
                
            
            }
    }

    //gradient nav load format
    $('[data-slide]').on('click', function(e) {
        e.preventDefault();
        let currentProduct, currentFormats, formatsLength, secondary = '';
        const slideno = $(this).data('slide');

        
        $('.product_portfolio__nav-item').removeClass('product_portfolio__nav-item--active');
        $(this).addClass('product_portfolio__nav-item--active');

        $('.product_portfolio__products-container').slick('slickGoTo', slideno);

        currentProduct = $('.product_portfolio__wrap.slick-current.slick-active');
        currentFormats = currentProduct.find('.product_portfolio__formats-container');

        currentFormats.find('.product_portfolio__format').each(function(){
            videoSrc = $(this).find('.product_portfolio__media-embed').data('video-src');
            if (videoSrc) {
                loadFormatVideo($(this));
            }
            
        });

        secondary = currentProduct.find('.product_portfolio__secondary-nav').find('.slick-slide').eq(0);
        formatsLength = currentFormats.find('.slick-slide').length;
 
        if(formatsLength > 1) {
            currentFormats.slick('slickGoTo', 0);
            secondary.addClass('slick-current');
        } else {
            currentFormats.slick('slickGoTo', 1);
            secondary.addClass('slick-current');
        }


        
        
        
        //set url to id
        const firstFormat = currentFormats.find('.product_portfolio__format').eq(0);
  
        if(history.pushState) {
            history.pushState(null, null, '#' + firstFormat.attr('id'));
        }
        else {
            window.location.hash = firstFormat.attr('id');
        }
    });
    
    

    //accordion tabs click
    $('.product_portfolio__tab').on('click', function() {
        if($(this).hasClass('product_portfolio__tab-is-active')) {
           
            $(this).toggleClass('product_portfolio__tab-is-active');
            $('.product_portfolio__product').slideUp();
    
        }
        else {
        //inactive tab ations    
        //close all tabs clear active
        $('.product_portfolio__product').slideUp();
        $('.product_portfolio__tab').removeClass('product_portfolio__tab-is-active');

        //open clicked tab
        $(this).siblings('.product_portfolio__product').children('.product_portfolio__formats-container').slick('refresh');
        $(this).siblings('.product_portfolio__product').children('.product_portfolio__formats-container').slick('slickGoTo',0);
        $(this).siblings('.product_portfolio__product').slideDown();
  

        //refresh
        $(this).siblings('.product_portfolio__product').children('.product_portfolio__formats-container').slick('refresh');
        $(this).addClass('product_portfolio__tab-is-active');

        }
    });
    
    
    // on secondary nav click load format 
    $('.product_portfolio__secondary-item').on('click', function(){
        const secondarySlug =  $(this).data('format-slug');
        const format = $('[data-format="'+secondarySlug+'"]');

        let formatIframeSrc = '';

            if(format.find('iframe')){
                formatIframeSrc = format.find('iframe').attr('src');
            }

            if(!formatIframeSrc) {
                loadFormatVideo(format);

                //load the rest
                format.siblings('.product_portfolio__format').each(function(){
                    loadFormatVideo($(this));
                })
            }


        //set url to id
        
  
        if(history.pushState) {
            history.pushState(null, null, '#' + format.attr('id'));
        }
        else {
            window.location.hash = format.attr('id');
        }
    });

    $('.product_portfolio__best-for').on('click', function(){
        if($(window).width() < 1024) {
            $(this).toggleClass('product_portfolio__best-for--opened');
        

        if($(this).hasClass('product_portfolio__best-for--opened')){
            $(this).find('.product_portfolio_read-more--text').html('Show Less');
        } else {
            $(this).find('.product_portfolio_read-more--text').html('Show More');
        }
        $(this).siblings('.product_portfolio__long-desc').animate({ height: 'toggle', opacity: 'toggle' }, 'fast');
        }  
    });

    //afterslide change
    // On before slide change
    $('.product_portfolio__formats-container').on('afterChange', function(event, cs){
        //load current
        loadFormatVideo($(this).find('.product_portfolio__format.slick-current.slick-active'));

        //load the rest
        $(this).find('.product_portfolio__format').each(function(){
            loadFormatVideo($(this));
        })

    
    });
    let fired = false;
    let thresholdPassed = false;
    $(window).on('resize', function() {
        
        if(intialWindowSize > 1024) {
            if($(window).width() < 1024) {
                if(fired !== true) {
                    $('.product_portfolio__refresh-notice').text('Please refresh your browser to view the best Mobile Experience.');
                    $('.product_portfolio__container').hide();
                    $('.product_portfolio__refresh-notice').show();
                   
                    thresholdPassed = true;
                    fired = true;
                }
                
            } else if($(window).width() > 1024) {
                if(thresholdPassed == true){
                    $('.product_portfolio__refresh-notice').hide();
                    $('.product_portfolio__container').show();
                    thresholdPassed = true;
                    fired = true;
                    
                }
            }
        }

        if(intialWindowSize < 1024) {
            if($(window).width() > 1024) {
                if(fired !== true) {
                    
                    
                    $('.product_portfolio__refresh-notice').text('Please refresh your browser to view the best Desktop Experience.');
                    $('.product_portfolio__container').hide();
                    $('.product_portfolio__refresh-notice').show();
                   
                    thresholdPassed = true;
                    fired = true;
                }
                
            } else if($(window).width() < 1024) {
                if(thresholdPassed == true){
        
                    $('.product_portfolio__refresh-notice').hide();
                    $('.product_portfolio__container').show();
                    fired = true;
                    thresholdPassed = true;
                    
                }
            }
        }
    });


    const productsPage = $('.page-template-2021-products');
    if(productsPage) {
        $('.menu-item-27821 .menu-item a').on('click', function(){
            console.log($(this).attr('href'));
            console.log($(this).attr('href').replace('/products/',''));


            const targetID = $(this).attr('href').replace('/products/','');



            const format = $(targetID);
            const formatIndex =  $(targetID).attr("data-slick-index");
            const formatParent = format.closest('.product_portfolio__wrap');
            const formatParentIndex = format.closest('.product_portfolio__wrap').attr("data-slick-index");
            loadFormatVideo(format);

            //navigate to the slide
            $('[data-slide]').removeClass('product_portfolio__nav-item--active');
            $('[data-slide="'+formatParentIndex+'"]').addClass('product_portfolio__nav-item--active');
            
            format.closest('.product_portfolio__product').find('.product_portfolio__secondary-item').eq(formatIndex).addClass('slick-current');
            $('.product_portfolio__products-container').slick('slickGoTo', formatParentIndex);
            $('.product_portfolio__formats-container').slick('slickGoTo', formatIndex);
            
        });
    }

    }
  
    if(productPorfolio.length) {
        ProductPortfolioInit();
    }
    

})(jQuery);


