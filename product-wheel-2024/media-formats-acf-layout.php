<?php
$content = get_sub_field('content');
$sid = count($args['loadedLayouts']);
$section_custom = section_customizer($sid, $args['currentLayout'], $content['section_customization']);
?>
<div id="<?php echo $section_custom['ID']; ?>" class="<?php echo implode(' ', $section_custom['classes']); ?> flexgrid">
    <div class="container">
        <div class="row">
            <div class="col-xs">
                <?php
                if (0 == $sid) { ?>
                    <h1 class="section-title main-title"><?php echo $content['title']; ?></h1>
                <?php
                } else { ?>
                    <h2 class="section-title"><?php echo $content['title']; ?></h2>
                <?php
                }

                if ($content['subtitle']) { ?>
                    <div class="media_formats__subtitle"><?php echo $content['subtitle']; ?></div>
                <?php }
                ?>
            </div>
        </div>
        <?php $selected_products = $content['products'];
        $selected_products_count =  count($selected_products);
        /*used by js to track ids to prevent bug that loads only one format video*/
        $formats_id_array = [];
        ?>
        <?php if ($selected_products) : ?>
            <div class="row">
                <!-- New Product Portfolio Nav -->
                <div class="col-xs-12 col-sm-5 col-md-12">
                    <div class="row mf-desktop-nav">
                        <!-- Format -->
                        <?php $nav_index = 0;
                        foreach ($selected_products as $post) :
                            setup_postdata($post); ?>
                            <div class="col-xs-12 col-sm-12 col-md mformat 
                            <?php if ($nav_index == 0) //echo 'mformat-tab-active '; ?>" data-product-slug="<?php echo get_the_ID(); ?>" data-slide="<?php echo $nav_index; ?>">
                                <div class="mformat-tab ">
                                    <div class="mformat-header" style="background: <?php echo get_field("product_color"); ?>;">
                                        <h6><?php echo get_field("product_type"); ?></h6>
                                        <h5><?php echo get_field("product_name"); ?></h5>
                                    </div>
                                    <div class="mformat-body">
                                        <?php if (have_rows('format_groups')) : ?>
                                            <?php while (have_rows('format_groups')) : the_row(); ?>
                                                <div class="mformat-subheader <?php echo get_sub_field("is_iab_standard") ? 'is-iab' : ''?>" >
                                                    <div class="mformat-title"><?php echo get_sub_field("group_title"); ?></div>
                                                    <div class="mformat-tagline"><?php echo get_sub_field("powered_by"); ?></b></div>
                                                </div>
                                                <div class="mformat-list">
                                                    <ul>
                                                        <?php if (have_rows('product_format')) : ?>
                                                            <?php while (have_rows('product_format')) : the_row(); ?>
                                                                <!-- Secondary Nav Item -->
                                                                <li>
                                                                    <a href="#<?php echo get_sub_field("format_slug"); ?>" 
                                                                    data-format-slug="<?php echo get_sub_field("format_slug"); ?>">
                                                                        <?php echo get_sub_field("format_name"); ?>
                                                                    </a> 
                                                                </li>
                                                                <!-- End Secondary Nav Item -->
                                                            <?php endwhile; ?>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php $nav_index++;
                        endforeach; ?>
                        <?php wp_reset_postdata(); ?>
                        <!-- end format -->
                    </div>
                </div>
                <!-- Product Slides -->
                <div class=" col-xs-12 col-sm-7 col-md-12">
                                                                        <div class="media_formats__container">
                                                                            <!-- Products Loop/Products Container -->
                                                                            <div class="media_formats__products-container media_formats__gradient-nav--<?php echo $selected_products_count; ?>">
                                                                                <!--where loop was before -->
                                                                                <?php
                                                                                $product_index = 0;
                                                                                foreach ($selected_products as $post) :
                                                                                    setup_postdata($post);
                                                                                    $product_title = get_field('product_name');

                                                                                ?>
                                                                                    <div class="media_formats__wrap slick-slide">
                                                                                        <!--Product Template-->

                                                                                        <!--Product-->
                                                                                        <div class="media_formats__product" data-product="<?php echo get_the_ID(); ?>">
                                                                                            <!--Formats Loop -->
                                                                                            <?php $number_of_rows = 0; ?>
                                                                                            <?php if (have_rows('format_groups')) : ?>
                                                                                                <?php while (have_rows('format_groups')) : the_row(); ?>
                                                                                                    <?php $number_of_rows += count(get_sub_field('product_format'));  ?>
                                                                                                    <?php //print_r($number_of_rows); ?>
                                                                                                <?php endwhile; ?>
                                                                                            <?php endif; ?>
                                                                                            
                                                                                            <div class="media_formats__formats-container slider">
                                                                                            <?php //used to place dots
                                                                                            $number_of_formats = 0; ?>
                                                                                            <?php if (have_rows('format_groups')) : ?>
                                                                                            <?php while (have_rows('format_groups')) : the_row(); ?>
                                                                                                <?php $group_title = get_sub_field("group_title");
                                                                                                    $group_tagline = get_sub_field('powered_by');
                                                                                                    $is_iab = get_sub_field('is_iab_standard');
                                                                                                ?>
                                                                                                

                                                                                                <?php if (have_rows('product_format')) : ?>

                                                                                                    <?php while (have_rows('product_format')) : the_row();
                                                                                                        $format_style = get_sub_field("format_style");
                                                                                                        $video_orientation = get_sub_field("video_orientation");
                                                                                                        $format_content_type = get_sub_field("format_content_type");
                                                                                                        $product_format_name = get_sub_field("format_name");
                                                                                                        $format_slug = get_sub_field("format_slug");
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

                                                                                                            if ($format_video) :
                                                                                                                preg_match('/src="(.+?)"/', $format_video, $source_matches);
                                                                                                                $format_video_url = $source_matches[1];
                                                                                                                preg_match('/(video|embed)\/(.+?)\?/', $format_video_url, $video_id_matches);
                                                                                                                $video_id = $video_id_matches[2];
                                                                                                                $format_video_src = $format_video_url . '&background=1&autoplay=1&muted=1&controls=0&rel=0&modestbranding=1&loop=1&dnt=1&api=1&version=3&playlist=' . $video_id;
                                                                                                            endif;
                                                                                                        endif;

                                                                                                        // $formatDivID = $product_title . '##' . $product_format_name;
                                                                                                        // $formatDivID = preg_replace('/\s+/', '', $formatDivID);
                                                                                                        // $formatDivID = strtolower(str_replace('##', '-', $formatDivID));
                                                                                                        //if you do not remove spaces the anchor scroll will not work
                                                                                                        $formatDivID = preg_replace('/\s+/','', $format_slug);
                                                                                                        $formats_id_array[] = $formatDivID;



                                                                                                    ?>

                                                                                                        <!-- Format Template No Accordion -->
                                                                                                        <div id="<?php echo $formatDivID; ?>" class="slick-slide media_formats__format <?php if (get_row_index() == 1) echo ' blah'; ?>" data-format="<?php echo get_sub_field("format_slug"); ?>">
                                                                                                            <div class="row mfgroup-header">
                                                                                                                <!-- <div class="mfgroup-col">
                                                                                                                   <h3><?php //echo $is_iab ? $product_format_name : $group_title; ?></h3>
                                                                                                                   <h6><?php //echo $is_iab ? 'IAB Supported' : $group_tagline; ?></h6>   
                                                                                                                </div>
                                                                                                                <div class="col-xs">
                                                                                                                    <hr>
                                                                                                                </div> -->

                                                                                                                <div class="col-xs">
                                                                                                                    <div class="row">
                                                                                                                        <div class="mfgroup-col">
                                                                                                                            <h3><?php echo $is_iab ? $product_format_name : $group_title; ?></h3>
                                                                                                                        </div>
                                                                                                                        <div class="col-xs">
                                                                                                                            <hr>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                   <div class="row">
                                                                                                                       <div class="col-xs">
                                                                                                                            <h6><?php echo $is_iab ? 'IAB Supported' : $group_tagline; ?></h6>
                                                                                                                       </div>  
                                                                                                                   </div>
                                                                                                                     
                                                                                                                </div>
                                                                                                               
                                                                                                            </div>
                                                                                        
                                                                                                            <div class="media_formats__format-inner">
                                                                                                                <!-- Format Media -->
                                                                                                                <div class="media_formats__format-media media_formats__format-media--<?php echo $format_style; ?>">
                                                                                                                    <div class="media_formats__device">

                                                                                                                        <?php if ($format_style == 'smartphone' && $video_orientation == 'vertical') : ?>
                                                                                                                            <svg class="media_formats__svg media_formats__svg--smartphone" data-name="device-phone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 165.12 355.1">
                                                                                                                                <path d="M140.42,0H24.7C11.12,0,0,11.67,0,25.92V329.17c0,14.27,11.12,25.93,24.7,25.93H140.42c13.59,0,24.7-11.67,24.7-25.93V25.92C165.12,11.67,154,0,140.42,0Zm17.45,331.72a2.17,2.17,0,0,1-2.11,2.22H9.36a2.18,2.18,0,0,1-2.13-2.22h0V23a2.17,2.17,0,0,1,2.13-2.22h146.4A2.17,2.17,0,0,1,157.87,23Z" fill="#DDDDDD"></path>
                                                                                                                            </svg>
                                                                                                                        <?php elseif ($format_style == 'smartphone' && $video_orientation == 'horizontal') : ?>
                                                                                                                            <svg class="svg svg--phone-horizontal" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 311.1 165.1">
                                                                                                                                <defs></defs>
                                                                                                                                <path d="M311.1 140.4V24.7c0-13.6-10.7-24.7-23.8-24.7H23.8C10.7 0 0 11.1 0 24.7v115.7c0 13.6 10.7 24.7 23.8 24.7h263.5c13.1 0 23.8-11.1 23.8-24.7zM21.5 157.9c-1.1 0-2-.9-2-2.1V9.4c0-1.2.9-2.2 2-2.1H290c.5 0 1 .2 1.4.6.4.4.6.9.6 1.5v146.4c0 1.2-.9 2.1-2 2.1H21.5z" fill="#DDDDDD"></path>
                                                                                                                            </svg>
                                                                                                                        <?php elseif ($format_style == 'laptop') : ?>
                                                                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="media_formats__svg media_formats__svg--laptop" viewBox="0 0 456 239.9">
                                                                                                                                <defs />
                                                                                                                                <path d="M414.6 35.9c-.1-7.9.1-15.8-.5-23.7-.2-3.3-1.4-6.2-3.8-8.6-2.4-2.7-5.6-3.7-9.1-3.6H55.9c-.4 0-3.8.1-4.2.1-2.2.1-3.9 1-5.5 2.4-2.2 2-3.6 4.5-3.7 7.6v213.8c0 2.6 0 2.6 2.5 2.6h146.1c.6.1 1.3.1 1.9.1h69.8c.6 0 1.3 0 1.9-.1s1.3 0 1.9 0h145.8c.5 0 .9 0 1.2-.4.4-.5.3-1.1.3-1.6.1-10 0-20.1.2-30.1.3-12 0-16 .2-28 .3-15.7.1-25.5.2-41.2.4-31.2.6-58.2.1-89.3zM403.1 210c0 1.5.1 1.3-1.4 1.3h-45.6c-.4 0-.8.1-1.2-.1-4.8 0-9.6.1-14.5.1-10.1 0-22.2 0-32.3-.1H307c-.4-.2-.9-.1-1.3-.1h-74.6c-.5 0-1 .1-1.5-.1-.3 0-.7.1-1 .1-19.8 0-39.7-.1-59.5-.1-.3 0-.5 0-.8-.1-.4-.2-.9-.1-1.3-.1H88.6c-.4 0-.9.1-1.3-.1-4.9 0-9.7.1-14.6.1H54.4c-.9 0-1.2-.1-1.2-1.1V16c0-1 .3-1.2 1.2-1.2h347.7c.3 0 .7 0 1 .1.2.4.1.8.1 1.2-.1 70.6-.1 123.2-.1 193.9z" fill="#D3D3D3" />
                                                                                                                                <path d="M194.7 230.6c-2.4-.9-3.4-2.1-3.5-4.5H265c-.6 3.1-2.2 4.7-5.3 5.2-3.9.1-12.5.1-13 .1h-37.6c-4.8 0-9.7.3-14.4-.8z" fill="#d3d3d3" />
                                                                                                                                <path d="M454.6 226.1H264.9c-.3.2-.5.4-.6.8-.7 2.4-2.4 3.6-4.7 4-.2.1-.3 0-.5.1-.8.2-11.8.4-12.4.4h-41.9c-.8 0-4.4-.1-6.3-.3-1.2-.1-2.5-.3-3.6-.8-1.7-.8-3-1.8-3.4-3.8 0-.2-.2-.3-.4-.4H1.5c-1.5 0-1.4 0-1.5 1.5 0 1.2 1.5 5.3 2.8 5.6 4.2 2.5 20.8 6.7 28.3 6.7h393.7c7.6 0 24.1-4.2 28.3-6.7 1.3-.3 2.8-4.4 2.8-5.6.1-1.5.2-1.5-1.3-1.5z" fill="#dddddd" />
                                                                                                                            </svg>
                                                                                                                        <?php else : ?>
                                                                                                                            <svg class="media_formats__svg media_formats__svg--tv" viewBox="0 0 691 425" xmlns="http://www.w3.org/2000/svg">
                                                                                                                                <defs />
                                                                                                                                <path d="M690.991 397.927V0H0v397.927h245.417v4.345l-7.958 12.781V425h216.064v-9.947l-7.958-12.759v-4.345l245.426-.022zm-440.75 17.126l7.95-12.781v-4.345h174.6v4.345l7.945 12.781H250.241zm-240.1-27.71V10.588h670.631v376.753H10.142z" fill="#dddddd" fill-rule="nonzero" />
                                                                                                                            </svg>
                                                                                                                        <?php endif; ?>

                                                                                                                        <div class="media_formats__media-embed" data-video-src="<?php echo $format_video_src; ?>" data-image-src="<?php echo $format_image; ?>">
                                                                                                                            <?php
                                                                                                                            if ($format_content_type == 'image') {
                                                                                                                                $image_content = '<img src="' . $format_image . '">';
                                                                                                                                echo apply_filters('a3_lazy_load_images', $image_content, null);
                                                                                                                            } elseif ($format_content_type == 'video') {
                                                                                                                                $iframe_content = '<iframe src="" class="iframe-embed" allow="autoplay; fullscreen" allowfullscreen="" width="640" height="360" frameborder="0"></iframe>';
                                                                                                                                echo apply_filters('a3_lazy_load_videos', $iframe_content, null);
                                                                                                                            } ?>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <!-- END Format Media -->

                                                                                                                <div class="media_formats__details media_formats__details--<?php echo $format_style; ?>">

                                                                                                                   

                                                                                                                    <div class="media_formats__product-title">
                                                                                                                        <h3><?php echo get_sub_field("format_name"); ?></h3>
                                                                                                                    </div>
                                                                                                                    <?php if (get_sub_field("format_subtitle")) { ?>
                                                                                                                        <div class="media_formats__format-subtitle">
                                                                                                                            <?php echo get_sub_field("format_subtitle"); ?>
                                                                                                                        </div>
                                                                                                                    <?php } ?>
                                                                                                                    <div class="media_formats__divider"></div>
                                                                                                                    <div class="media_formats__product-description">
                                                                                                                        <div class="media_formats__best-for">
                                                                                                                            <?php esc_html(the_sub_field("format_best_for")); ?><span class="media_formats_read-more"> <span class="media_formats_read-more--text">Show More</span> <span class="media_formats__down-arrow media_formats__down-arrow--black"></span></span>

                                                                                                                        </div>
                                                                                                                        <div class="media_formats__long-desc">

                                                                                                                            <?php esc_html(the_sub_field("format_description")); ?>

                                                                                                                        </div>
                                                                                                                        <?php
                                                                                                                        $format_slug = get_sub_field("format_slug");
                                                                                                                        if (strpos($format_slug, 'content-dial') !== false) { ?>
                                                                                                                            <a class="acf-element-btn" href="/products/contentdial/"><span class="btn-link-title">Learn More</span><span class="btn-icon btn-icon-arrow"></span></a>
                                                                                                                        <?php }
                                                                                                                        ?>

                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <?php if ($number_of_rows > 1) { ?>
                                                                                                                    <div class="media_formats__mobile-arrows">
                                                                                                                        <div class="media_formats__slide-arrow media_formats__slide-arrow--prev">
                                                                                                                            <span class="media_formats__down-arrow media_formats__down-arrow--black"></span>
                                                                                                                        </div>
                                                                                                                        <div class="media_formats__dots">
                                                                                                                        <ul class="slick-dots" style="" role="tablist">
                                                                                                                                <?php
                                                                                                                               
                                                                                                                                //placing dots reference for $number_of_formats
                                                                                                                                for($x = 0; $x < $number_of_rows; $x++){
                                                                                                                                    if($x === $number_of_formats){
                                                                                                                                        echo '<li role="presentation" class="media_formats__dot-slick-active"><button type="button" tabindex="0" role="tab">' . $x . '</button></li>';
                                                                                                                                    } else {
                                                                                                                                        echo '<li role="presentation"><button type="button" tabindex="0" role="tab">' . $x . '</button></li>';
                                                                                                                                    }
                                                                                                                                    
                                                                                                                                }
                                                                                                                             
                                                                                                                                ?>


                                                                                                                            </ul>
                                                                                                                        </div>
                                                                                                                        <div class="media_formats__slide-arrow media_formats__slide-arrow--next">
                                                                                                                            <span class="media_formats__down-arrow media_formats__down-arrow--black"></span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                <?php } ?>

                                                                                                            </div>

                                                                                                        </div>
                                                                                                        <!--End Format Template -->

                                                                                                    <?php
                                                                                                    $number_of_formats++;
                                                                                                    
                                                                                                    endwhile; ?>
                                                                                                <?php endif; ?>
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
                                                                        <div class="media_formats__refresh-notice">
                                                                            Please refresh your browser to view the best Desktop Experience.
                                                                        </div>


                                                </div>

                                    </div>
                                    <?php ?>
                                    <div id="formatsArray" class="media_formats__formats-ids-array" data-formatsids='["<?php echo implode('","', $formats_id_array); ?>"]'></div>
                                </div>
                            </div>
