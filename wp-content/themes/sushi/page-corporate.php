<?php
/*
* Template Name: Corporate
*
* @package WordPress
* @subpackage Sushi
*/

get_header();

global $wpdb, $sushi;
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
									<?php the_content(); ?>	
								</div>
								<div class="clr"></div>
								<div class="single-post">
									<h2>Customer success stories</h2>
									<?php 
										$args = array( 
											'post_type'		 => 'post',
											'category_name'  => 'corporate', 
											'posts_per_page' => -1, 
											'order' 		 => 'ASC',
											'orderby'		=> 'date'
										); 
										$loop = new WP_Query( $args );
										if( $loop->have_posts() ) :	
										$ctr = 0;
											while( $loop->have_posts() ) : $loop->the_post(); 
											?>
											<div class="list corporate-<?php echo $ctr; ?>">
												<?php if ( has_post_thumbnail() ) :
													  $image_id =	get_post_thumbnail_id( $post->ID );
													  $image = wp_get_attachment_image_src( $image_id, 'full' );
												?>	
												<div class="img-wrap fL"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="176" width="168"></div>
												<?php endif; ?>
												<div class="blurb-section left">
													<h3><?php the_title(); ?> - <?php the_field('sub_heading'); ?></h3>
													<?php the_excerpt(); ?>
													<a href="<?php the_permalink(); ?>" class="view-more">Read more about this project</a>
												</div>
												<div class="clr"></div>
											</div>
											<?php 
											$ctr++;
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