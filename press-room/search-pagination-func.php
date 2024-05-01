<?php
/**
 * Filter and display News Custom Postype by Searh or Year
 * 
 *
 * @return mixed
 */
function filter_news_category() {
	$dateYear = $_POST['year'];
	$searchQuery = $_POST['search'];
	$page = $_POST['page'];
	$args = array();

	//Validate date year exists and is an accepted value
	if(!empty($dateYear)) {
		$allowed_dates = array( '2023', '2022', '2021', '2020', '2019');
		$dateYear      = array_map( 'sanitize_text_field', $dateYear );

		if (!(bool) array_intersect($allowed_dates, $dateYear)) {
			wp_die( "Invalid Year" );
		}
	} else {
		$dateYear = array();
	}
	
	//create date_query array for $args
	function year_create($year){
		return ['year' => $year];
	}
	$dateYearArr = array_map('year_create', $dateYear);

	//Validate and sanitze search
	if(!empty($searchQuery)){
		$searchQuery = sanitize_text_field($searchQuery);
	}

	//Validate Pagination Value
	if(!empty($page)){
		$page = sanitize_text_field($page);
		if(!is_numeric($page)){
			wp_die( "Invalid Page" );
		}
	}

	 
	/* Set $arg based on $_POST */
	if(isset($dateYear) || isset($searchQuery)) {
		$args = ['post_type' => 'news',
		'posts_per_page' => 12,
		'order_by' => 'date',
		'order' => 'desc',
		'paged' => $page,
		's' => $searchQuery,
		'date_query' => array(
			'relation' => 'OR', $dateYearArr),];
	} else {
		$args = ['post_type' => 'news',
		'posts_per_page' => 12,
		'order_by' => 'date',
		'order' => 'desc',
		'news-publication' => $catSlug,
		'paged' => $page];
	}

  
	$ajaxposts = new WP_Query($args);
	$numberPages = $ajaxposts->max_num_pages;
	$response = '';
  
	if($ajaxposts->have_posts()) {
	  while($ajaxposts->have_posts()) : $ajaxposts->the_post();
		$response .= get_template_part( '/template-parts/news-list-item' );
	  endwhile;
	  ?>
	  <div class="row an-pagination-row">
	      <?php if ($numberPages > 1):  ?>
	      <ul class="announce_news__pagination" data-current-page="<?php echo $page ? $page : 1; ?>">
	          <?php if($page > 1) { ?>
	          <li><span class="an-pagination" data-page="<?php echo ($page - 1);?>">
	                  << Prev</span>
	          </li>
	          <?php } ?>
	          <?php
	          if($numberPages > 4 && $page <= 2) {
	            for ($i = 1; $i < 4; $i++) {
	              $active_class = $i === 1 ? ' active' : ''; 
	              echo '<li><span class="an-pagination" data-page="' . $i . '">'
	                . $i . '</span></li>';
	            }
	            echo '<li><span>...</span></li>';
	            echo '<li><span class="an-pagination" data-page="' . $numberPages. '">'
	                . $numberPages . '</span></li>';
	          } 
	          else {
	            for ($i = 1; $i <= $numberPages; $i++) {
	              $active_class = $i === $page ? ' active' : 'no'; ?>
	          <li><span class="an-pagination <?php echo $active_class; ?>"
	                  data-page="<?php echo $i; ?>"><?php echo $i; ?></span></li>
	          <?php
	            }
	          }
	          if($page < $numberPages) {
	          ?>
	  
	          <li><span class="an-pagination" data-page="<?php echo ($page + 1);?>">Next >></span></li>
	          <?php } ?>
	      </ul>
	      <?php endif; ?>
	  </div>
  
  <?php } else {
  	$response = 'empty';
  }
?>
  
	echo $response;
	exit;
}
