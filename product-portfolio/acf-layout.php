<?php 
$content = get_sub_field('content');
$sid = count($args['loadedLayouts']);
$section_custom = section_customizer($sid, $args['currentLayout'], $content['section_customization']);
?>
<div 
  id="<?php echo $section_custom['ID']; ?>" 
  class="<?php echo implode(' ', $section_custom['classes']); ?>" >
  <div class="container slightly-wider">
    
  <?php 
    if ( 0 == $sid ) { ?>
    <h1 class="section-title main-title"><?php echo $content['title']; ?></h1>
    <?php     
    } else { ?>
    <h2 class="section-title"><?php echo $content['title']; ?></h2>
    <?php    
    }

    if($content['subtitle']) { ?>
        <div class="product_portfolio__subtitle"><?php echo $content['subtitle']; ?></div>
    <?php }
    ?>

    <?php $selected_products = $content['products'];
     $selected_products_count =  count($selected_products);
     /*used by js to track ids to prevent bug that loads only one format video*/
     $formats_id_array = [];
    ?>
    <?php if ( $selected_products ) : ?>
    
    <div class="product_portfolio__container">
        
  
  

                 <!-- Gradient Nav -->
                <div class="product_portfolio__gradient-nav product_portfolio__gradient-nav--<?php echo $selected_products_count; ?>">
                <?php $nav_index = 0;
                    foreach ( $selected_products as $post ) : 
                        setup_postdata($post); ?>
                    <div class="product_portfolio__nav-item pp-nav-item-<?php echo $nav_index; ?> <?php if ($nav_index == 0) echo 'product_portfolio__nav-item--active ';?>" data-product-slug="<?php echo get_the_ID(); ?>" data-slide="<?php echo $nav_index; ?>"> 
                        <?php if (get_field("product_icon")) : ?>
                            <img class="pp-nav-item-<?php echo $nav_index; ?> " src="<?php echo get_field("product_icon") ?>">
                        <?php endif; ?>
                        <span class="pp-nav-item-<?php echo $nav_index; ?> "><?php echo get_field("product_name"); ?></span> 
                        <!--<span class="product_portfolio__down-triangle">
                           <img src="<?php //echo get_stylesheet_directory_uri(); ?>/images/product_portfolio/triangle-<?php  ?>.svg" alt="">
                        </span>-->
                    </div>
                <?php $nav_index++;
                    endforeach; ?>
                 <?php wp_reset_postdata(); ?> 
                </div>
                <!-- End Gradient Nav -->



                <!-- Products Loop/Products Container -->
                <div class="product_portfolio__products-container product_portfolio__gradient-nav--<?php echo $selected_products_count; ?>">
                

                <!--where loop was before -->

                

                    <?php 
                    $product_index = 0;
                    foreach ( $selected_products as $post ) : 
                        setup_postdata($post);  
                    $product_title = get_field('product_name');
                    
                    ?>
                    <div class="product_portfolio__wrap slick-slide">
                        <!--Product Template-->

                        <!--Product Tab MOBILE -->
                        <div class="product_portfolio__tab pp-nav-item-<?php echo $product_index; ?> ">
                            <?php if (get_field("product_icon")) : ?>
                                <img class="pp-nav-item-<?php echo $product_index; ?>" src="<?php echo get_field("product_icon") ?>">
                            <?php endif; ?>
                            <span class="pp-nav-item-<?php echo $product_index; ?>"><?php echo $product_title; ?></span> 
                           
                        </div>
                        <!-- END Product Tab MOBILE -->
                        
                        <!--Product-->
                        <div class="product_portfolio__product"
                        data-product="<?php echo get_the_ID(); ?>">
                        
                        

                            <!-- Secondary Nav-->
                            <div class="product_portfolio__secondary-nav">
                                <div class="product_portfolio__secondary-items">
                                    <?php if( have_rows('product_format') ): ?>
                                        <?php while( have_rows('product_format') ): the_row();?>
                                            <!-- Secondary Nav Item -->
                                            <div class="product_portfolio__secondary-item slick-slide" data-format-slug="<?php echo get_sub_field("format_slug");?>">
                                                <?php echo get_sub_field("format_name");?>
                                            </div>
                                            <!-- End Secondary Nav Item -->
                                        <?php endwhile; ?>
                                    <?php endif; ?>                            
                                </div>
                            </div>
                            <!-- End Secondary Nav-->
                            
                            
                            
                            <!--Formats Loop -->
                            <?php $number_of_rows = count(get_field('product_format'));  ?>
                            <div class="product_portfolio__formats-container slider">
                                <?php if( have_rows('product_format') ):?>
                                  
                                    <?php while( have_rows('product_format') ): the_row(); 
                                        $format_style = get_sub_field("format_style");
                                        $video_orientation = get_sub_field("video_orientation");
                                        $format_content_type = get_sub_field("format_content_type");
                                        $product_format_name = get_sub_field("format_name");
                                        
                                        switch ($format_style) {
                                            case 'laptop':
                                              $format_image = get_sub_field("format_image_laptop");
                                              break;
                                            case 'tv':
                                              $format_image = get_sub_field("format_image_tv");
                                              break;
                                            case 'smartphone':
                                              $format_image = get_sub_field("format_image_phone");
                                              break;
                                        }

                                        $format_video_src = '';
                                        if ($format_content_type == 'video') :
                                            $format_video = get_sub_field("format_video");

                                            if ( $format_video ) :
                                                preg_match('/src="(.+?)"/', $format_video, $source_matches);
                                                $format_video_url = $source_matches[1];
                                                preg_match('/(video|embed)\/(.+?)\?/', $format_video_url, $video_id_matches);
                                                $video_id = $video_id_matches[2];
                                                $format_video_src = $format_video_url.'&background=1&autoplay=1&muted=1&controls=0&rel=0&modestbranding=1&loop=1&dnt=1&version=3&playlist='.$video_id;
                                            endif;
                                        endif;

                                        $formatDivID = $product_title. '##' .$product_format_name;
                                        $formatDivID = preg_replace('/\s+/','',$formatDivID);
                                        $formatDivID = strtolower(str_replace('##', '-', $formatDivID));
                                        $formats_id_array[] = $formatDivID;

                                        
                                        
                                        ?>
                                       

                                        
                                        <!-- Format Template No Accordion -->
                                        
                                        <div id="<?php echo $formatDivID; ?>" 
                                        class="slick-slide product_portfolio__format <?php if (get_row_index() == 1) echo 'product_portfolio__format--active ';?>" 
                                        data-format="<?php echo get_sub_field("format_slug");?>">
                                     
                                            <div class="product_portfolio__format-inner">
                                            <!-- Format Media -->
                                            <div class="product_portfolio__format-media product_portfolio__format-media--<?php echo $format_style;?>" >
                                                <div class="product_portfolio__device">
                                                   
                                                <?php if ( $format_style == 'smartphone' && $video_orientation == 'vertical' ) : ?>
                                                                <svg class="product_portfolio__svg product_portfolio__svg--smartphone" data-name="device-phone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 165.12 355.1">
                                                                <path d="M140.42,0H24.7C11.12,0,0,11.67,0,25.92V329.17c0,14.27,11.12,25.93,24.7,25.93H140.42c13.59,0,24.7-11.67,24.7-25.93V25.92C165.12,11.67,154,0,140.42,0Zm17.45,331.72a2.17,2.17,0,0,1-2.11,2.22H9.36a2.18,2.18,0,0,1-2.13-2.22h0V23a2.17,2.17,0,0,1,2.13-2.22h146.4A2.17,2.17,0,0,1,157.87,23Z" fill="#DDDDDD"></path></svg>
                                                            <?php elseif ( $format_style == 'smartphone' && $video_orientation == 'horizontal' ) : ?>
                                                                <svg class="svg svg--phone-horizontal" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 311.1 165.1"><defs></defs><path d="M311.1 140.4V24.7c0-13.6-10.7-24.7-23.8-24.7H23.8C10.7 0 0 11.1 0 24.7v115.7c0 13.6 10.7 24.7 23.8 24.7h263.5c13.1 0 23.8-11.1 23.8-24.7zM21.5 157.9c-1.1 0-2-.9-2-2.1V9.4c0-1.2.9-2.2 2-2.1H290c.5 0 1 .2 1.4.6.4.4.6.9.6 1.5v146.4c0 1.2-.9 2.1-2 2.1H21.5z" fill="#DDDDDD"></path></svg>
                                                            <?php elseif ( $format_style == 'laptop' ) : ?>
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="product_portfolio__svg product_portfolio__svg--laptop" viewBox="0 0 456 239.9"><defs/><path d="M414.6 35.9c-.1-7.9.1-15.8-.5-23.7-.2-3.3-1.4-6.2-3.8-8.6-2.4-2.7-5.6-3.7-9.1-3.6H55.9c-.4 0-3.8.1-4.2.1-2.2.1-3.9 1-5.5 2.4-2.2 2-3.6 4.5-3.7 7.6v213.8c0 2.6 0 2.6 2.5 2.6h146.1c.6.1 1.3.1 1.9.1h69.8c.6 0 1.3 0 1.9-.1s1.3 0 1.9 0h145.8c.5 0 .9 0 1.2-.4.4-.5.3-1.1.3-1.6.1-10 0-20.1.2-30.1.3-12 0-16 .2-28 .3-15.7.1-25.5.2-41.2.4-31.2.6-58.2.1-89.3zM403.1 210c0 1.5.1 1.3-1.4 1.3h-45.6c-.4 0-.8.1-1.2-.1-4.8 0-9.6.1-14.5.1-10.1 0-22.2 0-32.3-.1H307c-.4-.2-.9-.1-1.3-.1h-74.6c-.5 0-1 .1-1.5-.1-.3 0-.7.1-1 .1-19.8 0-39.7-.1-59.5-.1-.3 0-.5 0-.8-.1-.4-.2-.9-.1-1.3-.1H88.6c-.4 0-.9.1-1.3-.1-4.9 0-9.7.1-14.6.1H54.4c-.9 0-1.2-.1-1.2-1.1V16c0-1 .3-1.2 1.2-1.2h347.7c.3 0 .7 0 1 .1.2.4.1.8.1 1.2-.1 70.6-.1 123.2-.1 193.9z" fill="#D3D3D3"/><path d="M194.7 230.6c-2.4-.9-3.4-2.1-3.5-4.5H265c-.6 3.1-2.2 4.7-5.3 5.2-3.9.1-12.5.1-13 .1h-37.6c-4.8 0-9.7.3-14.4-.8z" fill="#d3d3d3"/><path d="M454.6 226.1H264.9c-.3.2-.5.4-.6.8-.7 2.4-2.4 3.6-4.7 4-.2.1-.3 0-.5.1-.8.2-11.8.4-12.4.4h-41.9c-.8 0-4.4-.1-6.3-.3-1.2-.1-2.5-.3-3.6-.8-1.7-.8-3-1.8-3.4-3.8 0-.2-.2-.3-.4-.4H1.5c-1.5 0-1.4 0-1.5 1.5 0 1.2 1.5 5.3 2.8 5.6 4.2 2.5 20.8 6.7 28.3 6.7h393.7c7.6 0 24.1-4.2 28.3-6.7 1.3-.3 2.8-4.4 2.8-5.6.1-1.5.2-1.5-1.3-1.5z" fill="#dddddd"/></svg>
                                                            <?php else : ?>
                                                                <svg class="product_portfolio__svg product_portfolio__svg--tv" viewBox="0 0 691 425" xmlns="http://www.w3.org/2000/svg"><defs/><path d="M690.991 397.927V0H0v397.927h245.417v4.345l-7.958 12.781V425h216.064v-9.947l-7.958-12.759v-4.345l245.426-.022zm-440.75 17.126l7.95-12.781v-4.345h174.6v4.345l7.945 12.781H250.241zm-240.1-27.71V10.588h670.631v376.753H10.142z" fill="#dddddd" fill-rule="nonzero"/></svg>
                                                            <?php endif; ?>

                                                    <div class="product_portfolio__media-embed" data-video-src="<?php echo $format_video_src; ?>" data-image-src="<?php echo $format_image; ?>">
                                                        <?php 
                                                            if ( $format_content_type == 'image' ) {
                                                                $image_content = '<img src="' . $format_image . '">';
                                                                echo apply_filters( 'a3_lazy_load_images', $image_content, null );
                                                            } elseif ( $format_content_type == 'video' ) {
                                                                $iframe_content = '<iframe src="" class="iframe-embed" allow="autoplay; fullscreen" allowfullscreen="" width="640" height="360" frameborder="0"></iframe>';
                                                                echo apply_filters( 'a3_lazy_load_videos', $iframe_content, null );
                                                            } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END Format Media -->

                                            <div class="product_portfolio__details product_portfolio__details--<?php echo $format_style;?>">
                                                
                                                <?php if(get_sub_field("format_label")) { ?>
                                                    <div class="product_portfolio__format-label" style="background: <?php echo get_sub_field('format_label_bg') ?>">
                                                        <?php echo get_sub_field("format_label");?>
                                                    </div>
                                                <?php } ?>

                                                <div class="product_portfolio__product-title">
                                                    <h3><?php echo get_sub_field("format_name");?></h3>
                                                </div>
                                                <?php if(get_sub_field("format_subtitle")) { ?>
                                                    <div class="product_portfolio__format-subtitle">
                                                        <?php echo get_sub_field("format_subtitle");?>
                                                    </div>
                                                <?php } ?>
                                                <div class="product_portfolio__divider product_portfolio__divider--<?php echo 'gradient' ?>"></div>
                                                <div class="product_portfolio__product-description">
                                                    <div class="product_portfolio__best-for">
                                                        <?php esc_html(the_sub_field("format_best_for")); ?><span class="product_portfolio_read-more"> <span class="product_portfolio_read-more--text">Show More</span> <span class="product_portfolio__down-arrow product_portfolio__down-arrow--black"></span></span>
                                                            
                                                    </div>
                                                    <div class="product_portfolio__long-desc">
                                                        
                                                            <?php esc_html(the_sub_field("format_description")); ?>
                                                        
                                                    </div>
                                                    <?php
                                                        $format_slug = get_sub_field("format_slug");
                                                        if (strpos($format_slug, 'content-dial') !== false) {?>
                                                            <a class="acf-element-btn" href="/products/contentdial/"><span class="btn-link-title">Learn More</span><span class="btn-icon btn-icon-arrow"></span></a>
                                                        <?php }
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                            <?php if($number_of_rows > 1) {?>
                                            <div class="product_portfolio__mobile-arrows">
                                                <div class="product_portfolio__slide-arrow product_portfolio__slide-arrow--prev">
                                                    <span class="product_portfolio__down-arrow product_portfolio__down-arrow--black"></span>
                                                </div>
                                                <div class="product_portfolio__dots">
                                                <ul class="slick-dots" style="" role="tablist">
                                                    <?php 
                                                    
                                                    for ($x = 0; $x < $number_of_rows; $x++) {
                                                        if (($x + 1 ) == get_row_index()){
                                                            echo '<li role="presentation" class="product_portfolio__dot-slick-active"><button type="button" tabindex="0" role="tab">'.$x.'</button></li>';
                                                        } else {
                                                            echo '<li role="presentation"><button type="button" tabindex="0" role="tab">'.$x.'</button></li>';
                                                        }
                                                        
                                                      }
                                                    
                                                    ?>
                                                    
                                                    
                                                 </ul>
                                                </div>
                                                <div class="product_portfolio__slide-arrow product_portfolio__slide-arrow--next">
                                                    <span class="product_portfolio__down-arrow product_portfolio__down-arrow--black"></span>
                                                </div>
                                            </div>
                                            <?php }?>
                                            
                                            </div>

                                        </div>
                                        <!--End Format Template -->
                                
                                    <?php
                                        endwhile; ?>
                                <?php endif; ?>
                                
                            </div>
                            <!--End Formats Loop -->


                        </div>
                        <!--  End Product Template -->
                    </div>
                        
                    <?php 
                    $product_index++;
                    endforeach; ?>

                    <?php wp_reset_postdata(); ?>

                <?php endif; ?>
                </div>
                <!--  End Products Loop/Products Container -->
            </div>
            <div class="product_portfolio__refresh-notice">
                Please refresh your browser to view the best Desktop Experience.
            </div>
            <?php ?>
            <div id="formatsArray" class="product_portfolio__formats-ids-array" data-formatsids='["<?php echo implode('","', $formats_id_array); ?>"]'></div>

        </div>
    
  
</div>
