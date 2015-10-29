<?php
/*
* Template Name: Home
*
* @package WordPress
* @subpackage Sushi
*/

get_header();

global $wpdb, $sushi, $post;
$pageid = get_id();
$data = get_page( $pageid );
?>
	<section id="banner" class="homeSlide">
		<div class="hsContainer">			
			<div class="hsContent" data-center="opacity: 1" data-106-top="opacity: 0" data-anchor-target="#banner .fadeOut">
			<div class="main-container">
				<div class="fadeOut">
					<div class="backstretch-caption"></div>
					<div class="pagination">
						<ul>
							<li value="0"></li>
							<li value="1"></li>
							<li value="2"></li>
							<li value="3"></li>
						</ul>
					</div>							
				</div>
				
			</div>
			<a href="#who-we-are" id="home-arrow" class="arrow animated bounce"></a>
			</div>			
		</div>	
	</section>
	<section id="who-we-are">
		<div class="main-container">
			<div class="post-content fL" data-center="opacity: 1" data-200-bottom="opacity: 0" data-206-top="opacity: 1" data-106-top="opacity: 0" data-anchor-target="#who-we-are .post-content">
				<?php 
					$pid = 30;
					$content_post = get_post($pid);
					$title = $content_post->post_title;
					$excerpt = $content_post->post_excerpt;
					$excerpt = apply_filters('the_content', $excerpt);
					echo '<h2>'. $title .'</h2>';
					echo $excerpt;
				?>
				<a href="<?php echo home_url(); ?>/who-we-are" class="btn-more-bg">More about Zoodata</a>
			</div>
			<div class="img-holder fR" data-center="opacity: 1" data--0-bottom="opacity: 0" data-206-top="opacity: 1" data-106-top="opacity: 0" data-anchor-target="#who-we-are .post-content">
				<?php 
					$feat_img = get_field('featured_image', 30);
					echo _e($sushi->getTimthumbImage( array( 'title' => $feat_img['title'], 'alt' => $feat_img['alt'], 'height' => 258, 'width' => 371 ), array('h' => 258, 'w' => 371, 'src' => $feat_img['url'] ) ));
				?>
			</div>
			<div class="clr"></div>
		</div>
	</section>
	<section id="customer-success">
		<div class="case-slides">
			<ul class="slides" data-center="opacity: 1" data--50-bottom="opacity: 0" data-206-top="opacity: 1" data-106-top="opacity: 0" data-anchor-target="#customer-success ul">
				<?php 
					$args = array(
						'type'      => 'post',
						'exclude'   => 8,
						'include'   => '5,7,6'
					);
					$categories = get_categories( $args );
					foreach($categories as $cat) : ?>
							<?php 
								$p = array(
										'posts_per_page'   => 1,
										'category'         => $cat->cat_ID,
										'orderby'          => 'post_date',
										'order'            => 'DESC',
										'post_type'        => 'post'
									);
									$case_post = get_posts($p);	
									$rows = get_field('testimonials', $case_post[0]->ID);
									$first_row = $rows[0];
									$f_img = $first_row['image'];
									$f_content = $first_row['content'];
									$f_info = $first_row['info'];
								?>
									<li>
										<div class="img-holder fL">
											<img src="<?php echo $f_img['url']; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="350" width="337">
										</div>
										<div class="post-content fR">
											<h2>Customer success stories</h2>
											<?php echo $f_content; ?>
											<div class="info"><?php echo $f_info; ?></div>
											<a href="<?php echo home_url(); ?>/sectors/<?php echo $cat->slug; ?>" class="view-more">View more <?php echo $cat->cat_name; ?> success stories</a>
										</div>
									</li>
								<?php  
								wp_reset_query(); 
							?>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>	
	<section id="latest-news">
		<div class="main-container">
			<h2 class="fadeOut" data-center="opacity: 1" data--10-bottom="opacity: 0" data-206-top="opacity: 1" data-10-top="opacity: 0" data-anchor-target="#latest-news .fadeOut">Latest Zoodata news</h2>
			<div class="news-post-content" data-center="opacity: 1" data--10-bottom="opacity: 0" data-206-top="opacity: 1" data-10-top="opacity: 0" data-anchor-target="#latest-news .fadeOut">
				<?php 
					$args = array( 
						'post_type'		 => 'post',
						'category_name'  => 'news', 
						'posts_per_page' => 3, 
						'order' 		 => 'DESC',
						'orderby'		=> 'date'
					); 
					$loop = new WP_Query( $args );
						if( $loop->have_posts() ) :	
							while( $loop->have_posts() ) : $loop->the_post(); 
							?>
								<div class="list">
									<h3><?php the_title(); ?></h3>
									<span class="date"><?php echo get_the_date('jS F Y'); ?></span>									
									<?php the_excerpt(); ?>
									<a href="<?php the_permalink(); ?>" class="readmore">Read more...</a>
									<span class="postlink" style="display: none;"><?php the_permalink(); ?></span>
									<span class="posttitle" style="display: none;"><?php the_title(); ?></span>
									<div class="social-links">
										<?php
											$args = array(
														'url' => get_permalink(),
													);
											wpsocialite_markup($args); 
										?>
									</div>								
								</div>
							<?php 
							endwhile;		
						endif;								
					wp_reset_postdata();
				?>
			</div>
			<div class="clr"></div>
		</div>
	</section>
	<section id="home-contact">
		<div class="main-container">
			<div class="box" data-center="opacity: 1" data-600-bottom="opacity: 0" data-300-top="opacity: 1" data-10-top="opacity: 0" data-anchor-target="#home-contact .box">				
				<h2>Contact us</h2>
				<?php 
					$contact_id = 42;
					$content_post = get_post($contact_id);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);
					echo $content;
				?>
			</div>
		</div>
		<div id="map-canvas"></div>
	</section>

<?php get_footer(); ?>