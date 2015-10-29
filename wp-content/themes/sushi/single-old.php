<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage sushi
 */

get_header();

global $wpdb;
$pageid = get_id();
$data = get_page( $pageid );
?>
	<section id="content-area">	
	
		<?php echo get_template_part('headings'); ?>		
		
		<?php if(in_category('news')) : ?>
		<div id="inner">
			<div class="inner-content">
				<!--<div class="main-container" data-506-top="opacity: 0" data-256-top="opacity: 1" data-anchor-target="#inner .main-container">--->			
				<div class="main-container">						
					<?php echo breadcrumbs(); ?>
					<div class="clr"></div>
					<?php if(have_posts()) :
							while(have_posts()): the_post();?>
								<div class="post-<?php echo $pageid; ?> post-content">								
										<div class="main-post">
											<h2><?php the_title(); ?>	</h2>
											<?php the_content(); ?>	
										</div>								
									<?php echo get_sidebar('testimonial'); ?>
									<div class="clr"></div>
								</div>
						<?php endwhile;
						endif;
					?>						
				</div>
			</div>
		</div>
		<?php else: ?>
			<div class="inner-content slide">				
				<div class="main-container has-ajax">
					<?php echo breadcrumbs(); ?>
					<div class="single-nav">
						<?php previous_post_link('%link', 'Previous case study', FALSE, 8); ?>
						<?php next_post_link('%link', 'Next case study', FALSE, 8); ?>
					</div>
					<div class="clr"></div>
					<?php if(have_posts()) :
							while(have_posts()): the_post();?>
								<div class="post-<?php echo $pageid; ?> post-content">
									<div class="content-slide">
										<div class="main-post fl-post">
											<?php the_content(); ?>	
										</div>								
										<?php echo get_sidebar('testimonial'); ?>
										<div class="clr"></div>
									</div>
								</div>
						<?php endwhile;
						endif;
					?>
				</div>				
			</div>
		<?php endif; ?>
	</section>

<?php get_footer(); ?>