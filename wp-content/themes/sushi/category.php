<?php
/**
 * Sushi Wordpress Starter 3.0 Theme category template.
 *
 * @author Sushi Katana team
 * @copyright 2013 Sushi Digital Pty. Ltd.
 * @since Sashimi 3.0
 * @package WordPress
 * @subpackage Sushi_WP
 */
get_header();
global $wp_query;
$categ = get_the_category();

//get_header(); ?>

	<section id="content-area">
		<div id="inner" class="blog-category">
			<div class="inner-content">
				<div class="main-container">

					<?php echo breadcrumbs(); ?>
					<div class="clr"></div>

					<div class="post-<?php echo $pageid; ?> post-content">
						<div class="main-post">
							<div id="blog-cont" class="left">
								<div id="blog-inner" class="left">

									<?php if ( have_posts() ) : ?>
										<header class="archive-header">
											<h1 class="archive-title"><?php printf( __( 'Category Archives: %s', 'twentytwelve' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>

										<?php if ( category_description() ) : // Show an optional category description ?>
											<div class="archive-meta"><?php echo category_description(); ?></div>
										<?php endif; ?>
										</header><!-- .archive-header -->

										<?php
										/* Start the Loop */
										while ( have_posts() ) : the_post();
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
													<p><?php echo wp_trim_words(get_the_content(), 38);?></p>
												</div> 
												<a class="read-more" href="<?php the_permalink();?>">Read more</a>
											</div>

										<?php endwhile; wp_reset_postdata(); //twentytwelve_content_nav( 'nav-below' ); ?>

									<?php else : ?>
											<article id="post-0" class="post no-results not-found">
												<header class="entry-header">
													<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
												</header>

												<div class="entry-content">
													<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'twentytwelve' ); ?></p>
													<?php get_search_form(); ?>
												</div><!-- .entry-content -->
											</article><!-- #post-0 -->
									<?php endif; ?>
								
								</div>
							</div>
							<?php get_sidebar('blog'); ?>
							<div class="clr"></div>
						</div>	
					</div>
				</div>
			</div>
		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>