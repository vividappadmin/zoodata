<?php
/*
* Template Name: Blog Page
*
* @package WordPress
* @subpackage Sushi
*/

get_header();

global $wpdb;
$pageid = get_id();
$data = get_page( $pageid );
?>
	<section id="content-area">
			
		<?php //echo get_template_part('headings'); ?>
		<div id="inner">
			<div class="inner-content">
				<!--<div class="main-container" data-506-top="opacity: 0" data-256-top="opacity: 1" data-anchor-target="#inner .main-container">-->
				<div class="main-container">
					<?php echo breadcrumbs(); ?>
					<div class="clr"></div>
					<div class="post-<?php echo $pageid; ?> post-content">
						<div class="main-post">
							<div id="blog-cont" class="left">
								<?php 
									$paged = get_query_var('paged') ? get_query_var('paged') : 1;
									$args = array(
												'category_name'=> 'Blog', 
												'post_type' => 'post',
												'paged'	=> $paged,
												'post_status' => 'publish',
												'posts_per_page' => 3,
												'orderby' => 'date',
												'order' => 'DESC'
											);

									$wp_query = new WP_Query($args);
								?>
								<div id="blog-inner" class="left">
									<?php if ($wp_query->have_posts()) :
											while($wp_query->have_posts()): $wp_query->the_post();?>
										<?php 
											$imgsrc = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');
										
											echo _e($sushi->getTimthumbImage( array( 'title' => get_the_title(), 'alt' => get_the_title() ), array('w' => 740, 'h' => 514, 'zc' => 2,  'src' => $imgsrc[0] ) ));
										?>
										<div class="blog-border">
											<div class="date-share"> 
												<span class="date left"> 
													<?php the_time( 'jS F Y' ); ?>
												</span>
												<div class="social-links right">
													<?php
														$args = array(
																	'url' => get_permalink(),
																);
														wpsocialite_markup($args); 
													?>
												</div>
												<div class="clr"></div>	
											</div>
											<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
											<div class="blog-cont">
												<p><?php echo ( get_the_excerpt() )? get_the_excerpt() : wp_trim_words(get_the_content(), 38);?></p>
											</div> 
											<a class="read-more" href="<?php the_permalink();?>">Read more</a>
										</div>
										
									<?php endwhile; 
										endif;
										echo wp_pagenavi();
										wp_reset_postdata();
									?>
									
								</div>
							</div>
							<?php get_sidebar('blog'); ?>
							<div class="clr"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>