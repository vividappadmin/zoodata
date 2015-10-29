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
									<?php the_content(); ?>	
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
	</section>

<?php get_footer(); ?>