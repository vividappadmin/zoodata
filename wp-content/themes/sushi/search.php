<?php
/**
* The template for displaying Search Results pages.
*
* @package WordPress
* @subpackage sushi
*/

get_header();

global $wpdb;
$pageid = get_id();
$data = get_page( $pageid );

$cat_id = get_category_by_slug('blog'); 

if( !empty($_REQUEST['s']) ) {
		query_posts(array( 's' => $_REQUEST['s'] , 'cat' => $cat_id->term_id ));
	}
?>


<section id="content-area">
			
	<div id="inner">
		<div class="inner-content">
			<div class="main-container">
				<?php echo breadcrumbs(); ?>
				<div class="clr"></div>
				<div class="post-<?php echo $pageid; ?> post-content">
					<div class="main-post">
						<div id="blog-cont" class="left">
							<div id="blog-inner" class="left">
								<?php if ( have_posts() ) :?>
									<h1 class="search"><?php printf( __( 'Results for %s', 'sushi' ), '<span>"' . get_search_query() . '"</span>' ); ?></h1>
									<?php while ( have_posts() ) : the_post(); 
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
													<p><?php echo wp_trim_words(get_the_content(), 38);?>
														<?php 
															/*echo '<b><a href="'.get_permalink(get_the_ID()).'">';
															the_title();
															echo '</a></b>';
															echo the_content();*/ 
														?>
													</p>
												</div> 
												<a class="read-more" href="<?php the_permalink();?>">Read more</a>
											</div>
								<?php      endwhile; 
									   else: ?>
											<h1 class="search"><?php _e( 'Nothing Found', 'sushi' ); ?></h1>
											<p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.'); ?></p>
								<?php  endif; 
									echo wp_pagenavi();
									wp_reset_postdata();	
								?>

							<?php 
								/*$paged = get_query_var('paged') ? get_query_var('paged') : 1;
								$args = array(
											'cat' => 9,
											'post_type' => 'post',
											'paged'	=> $paged,
											'post_status' => 'publish',
											'posts_per_page' => 3,
											'orderby' => 'date',
											'order' => 'DESC'
										);

								$wp_query = new WP_Query($args);*/
							?>
							<!-- <div id="blog-inner" class="left">
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
										<h3><?php the_title();?></h3>
										<div class="blog-cont">
											<p><?php echo wp_trim_words(get_the_content(), 38);?></p>
										</div> 
										<a class="read-more" href="<?php the_permalink();?>">Read more</a>
									</div>
									
								<?php endwhile; 
									endif;
									echo wp_pagenavi();
									wp_reset_postdata();
								?>
								
							</div> -->
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



	<!-- <div class="main-container">
		<div id="content-area">
			<div class="sidebar left">
				<div id="logo"><a href="<?php _e( get_bloginfo( "url" ) ); ?>"></a></div>
				<div id="main-nav">
					<?php wp_nav_menu( array( container => null ) ); ?>
					<ul>
						<li><a href="<?php bloginfo("url"); ?>/wp-admin/index.php" target="_blank">Dashboard</a></li>
					</ul>
				</div>
			</div>
			<div class="main-content left">
				<div id="header">
					<h1>Sushi Theme <span>Starter</span></h1>
				</div>
				<div class="content">									
					<?php if ( have_posts() ) :?>
						<h1 class="search"><?php printf( __( 'Search Results for: %s', 'sushi' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
						<?php while ( have_posts() ) : the_post(); ?>
						<p>
							<?php 
								echo '<b><a href="'.get_permalink(get_the_ID()).'">';
								the_title();
								echo '</a></b>';
								echo the_content(); 
							?>
						</p>
						<?php endwhile; else: ?>
						<h1 class="search"><?php _e( 'Nothing Found', 'sushi' ); ?></h1>
						<p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.'); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<div class="clr"></div>
		</div>
		<div id="footer">		
			<p class="copyright">Copyright &copy; 2013 Sushi Digital Theme. All Rights Reserved.</p>
			<p class="sushi">Powered by Sushi Digital</p>		
		</div>
	</div> -->
	<!-- /main-container -->

<?php get_footer(); ?>