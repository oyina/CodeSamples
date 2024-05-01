<?php 

$content = get_sub_field('announce_news');
$sid = count($args['loadedLayouts']);
$section_custom = section_customizer($sid, $args['currentLayout'], $content['section_customization']); 

?>
<div id="<?php echo $section_custom['ID']; ?>" class="flexgrid <?php echo implode(' ', $section_custom['classes']); ?>">
    <div class="container">
        <?php if ($content['headline']) { ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <?php echo $content['headline']; ?>
            </div>
        </div>
        <?php  }?>
        <!-- Gradient Nav -->
        <div class="row announce_news__gradient-nav announce_news__gradient-nav--2">
            <div class="col-xs-6 announce_news__nav-item announce_news__nav-item--1 announce_news__nav-item--active"
                data-nav-slide="0">
                <img src="/wp-content/themes/genesis-triplelift/images/press/announcement_white_icon-1.svg">
                <span>Announcements</span>
            </div>

            <div class="col-xs-6 announce_news__nav-item announce_news__nav-item--2" data-nav-slide="1">
                <img src="/wp-content/themes/genesis-triplelift/images/press/news_icon_white-1.svg">
                <span>In The News</span>
            </div>
        </div>
        <!-- End Gradient Nav -->
        

        <!--Tab MOBILE -->
        <div class="announce_news__mobile-tabs">
            <div class="announce_news__tab announce_news__tab--1 announce_news__tab--active" data-tab-slide="0">
                <img src="/wp-content/themes/genesis-triplelift/images/press/announcement_white_icon-1.svg">
                <span>Announcements</span>
            </div>

            <div class="announce_news__tab announce_news__tab--2" data-tab-slide="1">
                <img src="/wp-content/themes/genesis-triplelift/images/press/news_icon_white-1.svg">
                <span>In the News</span>
            </div>
        </div>
        <!-- END Tab MOBILE -->
        <?php if ($content['subheadline']) {  ?>
        <div class="row an__subheadline">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <?php echo $content['subheadline'];?>
            </div>
        </div>
        <?php }?>
        <div class="row an-slider">
            <div id="announcements">
                <div class="row announce_news__facet-shortcodes">
                    <div class="col-xs-12 col-sm-3 col-md-4 hide-for-small">&nbsp;<?php //echo do_shortcode( '[facetwp facet="clear"]'); ?></div>
                    <div class="col-xs-6 col-sm-3 col-md-4 hide-for-small">&nbsp;<?php //echo do_shortcode('[facetwp facet="sort_announcements"]' );?>
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-2"><?php echo do_shortcode(  '[facetwp facet="date_as_year"]'); ?></div>
                    <div class="col-xs-8 col-sm-3 col-md-2"><?php echo do_shortcode('[facetwp facet="search"]'); ?></div>
                </div>

                <div class="row" style="margin-left:auto;margin-right:auto;">
                    <div class="col-xs-12">
                        <?php echo do_shortcode( '[facetwp template="announcements_9"]'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <?php echo do_shortcode( '[facetwp facet="pager_global"]' );?>
                    </div>
                </div>

            </div>
            <div id="news" class="height-zero">
                <div class="row announce_news__custom-filters">
                    <div class="col-xs-12 col-sm-3 col-md-4 hide-for-small">
                    &nbsp;
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-4 hide-for-small">
                        &nbsp;
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-2">
                    <?php 
                        $dates = ['2023','2022','2021','2020','2019']; ?>
                        <div class="select-list">
                            <div class="title">Year</div>
                            <div class="select-options">
                         
                                <?php foreach($dates as $date) : ?>
                       
                                <div class="option"> 
                                    <input class="select-checkboxes" type="checkbox" name="<?php echo $date; ?>" id="option<?php echo $date; ?>" value="<?php echo $date; ?>" />
                                    <label for="option<?php echo $date; ?>"><?php echo $date; ?></label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-xs-8 col-sm-3 col-md-2">
                        
                        <div id="news-search" class="facetwp-facet facetwp-type-search">
                            <span class="facetwp-input-wrap">
                                <i class="facetwp-icon"></i>
                             
                                <input id="an-search" type="text" class="an-search facetwp-search" value="" placeholder="Search News" tabindex="0">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">

                        <?php 
                        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                        $news = new WP_Query([
                            'post_type' => 'news',
                            'posts_per_page' => 12,
                            'order_by' => 'date',
                            'order' => 'desc',
                            'paged' => $paged
                        ]);
                        $numberPages = $news->max_num_pages;
                        ?>

                        <?php if($news->have_posts()): ?>
                        <div class="row an-news-list">

                            <?php
                            while($news->have_posts()) : $news->the_post();
                                //include(get_template_directory_uri().'/template-parts/news-list-item.php');
                                get_template_part( '/template-parts/news-list-item' );
                            endwhile;
                            ?>
                            <div class="row an-pagination-row">
                                <?php if ($numberPages > 1): ?>
                                <ul class="announce_news__pagination">
                                    <?php
                                    if($numberPages > 3) {
                                        for ($i = 1; $i < 4; $i++) {
                                            $active_class = $i === 1 ? ' active' : ''; 
                                            echo '<li><span class="an-pagination'.$active_class.'" data-page="' . $i . '">'
                                                . $i . '</span></li>';
                                        }
                                        echo '<li><span>...</span></li>';
                                        echo '<li><span class="an-pagination" data-page="' . $numberPages. '">'
                                                . $numberPages . '</span></li>';
                                    } else {
                                        for ($i = 1; $i <= $numberPages; $i++) {
                                            $active_class = $i === 1 ? ' active' : ''; 
                                            echo '<li><span class="an-pagination'.$active_class.'" data-page="' . $i . '">'
                                                . $i . '</span></li>';
                                        }
                                    }
                                    
                                    ?>
                                    <li><span class="an-pagination" data-page="2">Next >></span></li>
                                </ul>
                                <?php endif; ?>
                            </div>
                        </div>


                        <?php endif; ?>

                        <?php wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
