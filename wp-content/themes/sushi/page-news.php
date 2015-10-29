<?php
/*
* Theme's Default Template
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
		<?php if(have_posts()):?>
			<?php while(have_posts()): the_post();?>
			
				<?php echo get_template_part('headings'); ?>
				
				<div id="inner">
					<div class="inner-content">
						<!--<div class="main-container" data-506-top="opacity: 0" data-256-top="opacity: 1" data-anchor-target="#inner .main-container">-->
						<div class="main-container">
							<?php echo breadcrumbs(); ?>
							<div class="clr"></div>
							<div class="post-<?php echo $pageid; ?> post-content">
								<div class="main-post">
									<?php 
										$args = array( 
											'post_type'		 => 'post',
											'category_name'  => 'news', 
											'posts_per_page' => -1, 
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
														<p>
															<?php echo limit_words( get_the_content(), 43 )?>
															...<a href="<?php the_permalink(); ?>" class="readmore">Read more</a>
														</p>							
													</div>
												<?php 
												endwhile;		
											endif;								
										wp_reset_postdata();
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
	</section>

<?php get_footer(); ?>