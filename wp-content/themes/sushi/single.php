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
$categ_name = get_the_category( $data->ID );

$terms = get_the_terms( $pageid, 'category' );
foreach ( $terms as $term ) :
	$categ_ID = $term->cat_ID;
endforeach;

?>
	<section id="content-area" class="<?php echo ( in_category('blog') || is_child_of_category(10, $categ_ID) )? 'blog-single':''; ?>">	
	
		<?php
			if( !in_category('blog') && !is_child_of_category(10, $categ_ID) ) : 
				echo get_template_part('headings'); 
		    endif;
		?>		
		
		<?php if(in_category('news')) : ?>
		<div id="inner">
			<div class="inner-content">
				<!-- <div class="main-container" data-506-top="opacity: 0" data-256-top="opacity: 1" data-anchor-target="#inner .main-container">-->
				<!-- <div class="main-container"> -->
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
										<?php $auth_id = get_the_author_meta('ID');
											  $author_details = get_field( 'author_info', $post->ID );
											  $def_image      = get_bloginfo('template_directory').'/images/default-gravatar-placeholder.png';

											  if( $author_details ):		
												  foreach ( $author_details as $author_detail ) : ?>
											<div class="author-cont">
												<?php
													//$author_name = get_the_author_meta('first_name',$auth_id).", ".get_the_author_meta('last_name',$auth_id);
													$avatar = get_author_image_url($auth_id); // The function uses get_the_ID() to grab the appropirate user ID for the author image.
													//echo _e($sushi->getTimthumbImage( array( 'title' => $author_name, 'alt' => $author_name ), array('w' => 200, 'h' => 200, 'zc' => 1,  'src' => $avatar ) ));

													//$author_details = get_field( 'author_info', $post->ID );

													$author_fname     = $author_detail['author_first_name'];
													$author_lname     = $author_detail['author_last_name'];
													$author_img       = $author_detail['author_image']['url'];
													$author_img_alt   = $author_detail['author_image']['alt'];
													$author_img_title = $author_detail['author_image']['title'];
													$author_bio       = $author_detail['author_biography'];
													$author_fb        = $author_detail['author_fb_link'];
													$author_twit      = $author_detail['author_twitter_link'];
													$author_gplus     = $author_detail['author_google_plus_link'];
													$author_linkedin  = $author_detail['author_linkedin'];
													$author_ytlink    = $author_detail['author_youtube_link'];
													$author_position  = $author_detail['author_position'];

													if( !empty( $author_detail['author_image'] ) ):	
														echo _e($sushi->getTimthumbImage( array( 'title' => $author_fname.' '.$author_fname, 'alt' => $author_fname.' '.$author_fname ), array('w' => 200, 'h' => 200, 'zc' => 1,  'src' => $author_img ) ));
													else:
														echo _e($sushi->getTimthumbImage( array( 'title' => $author_fname.' '.$author_fname, 'alt' => $author_fname.' '.$author_fname ), array('w' => 200, 'h' => 200, 'zc' => 1,  'src' => $def_image ) ));	
													endif;
												?>
												<div class="author-dets right">
													<h4><?php  
													            if( $author_fname != '' ):
													            	echo $author_fname;
													            endif;	

													            if( $author_lname != '' ):
													            	echo ' '.$author_lname;
													            endif; ?>
													</h4>
													<?php echo ( $author_bio ) ? '<div class="description">'.$author_bio.'</div>' : ''; ?>
													<div id="social-icons"> 
														<?php echo ( $author_fb )?       '<a target="_blank" title="Facebook" rel="nofollow" href="'.$author_fb.'" class="facebook">Facebook</a>':''; ?>
														<?php echo ( $author_twit )?     '<a target="_blank" title="Twitter" rel="nofollow" href="'.$author_twit.'" class="twitter">Twitter</a>':''; ?>
														<?php echo ( $author_gplus )?    '<a target="_blank" title="Google Plus" rel="nofollow" href="'.$author_gplus.'" class="googleplus">Google Plus</a>':''; ?>
														<?php echo ( $author_linkedin )? '<a target="_blank" title="LinkedIn" rel="nofollow" href="'.$author_linkedin.'" class="linkedin">LinkedIn</a>':''; ?>
														<?php echo ( $author_ytlink )?   '<a target="_blank" title="Youtube" rel="nofollow" href="'.$author_ytlink.'" class="youtube">Youtube</a>':''; ?>
													</div>
												</div>
												<div class="clr"></div>
											</div>
										    <?php endforeach; 
										    	endif; ?>								
									<?php echo get_sidebar('testimonial'); ?>
									<div class="clr"></div>
								</div>
						<?php endwhile;
						endif;
					?>						
				</div>
			</div>
		</div>
		<?php elseif(in_category('blog') || is_child_of_category(10, $categ_ID) ) : ?>
			<div class="inner-content slide">				
				<div class="main-container has-ajax">
					<?php echo breadcrumbs(); ?>
					<?php /*<div class="single-nav">
						<?php previous_post_link('%link', 'Previous case study', FALSE, 8); ?>
						<?php next_post_link('%link', 'Next case study', FALSE, 8); ?>
					</div>*/ ?>

					<div class="clr"></div>
					<?php if(have_posts()) :?>
							<div class="blog post-<?php echo $pageid; ?> post-content">
							<?php while(have_posts()): the_post();?>
									<div class="content-slide">
										<div class="main-post fl-post">
											<?php 
												$imgsrc = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');
											
												echo _e($sushi->getTimthumbImage( array( 'title' => get_the_title(), 'alt' => get_the_title() ), array('w' => 740, 'h' => 514, 'zc' => 2,  'src' => $imgsrc[0] ) ));
											?>
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
											<div class="single-content">
												<?php the_content(); ?>
											</div>
											
											<?php $auth_id = get_the_author_meta('ID');
												  $author_details = get_field( 'author_info', $post->ID );
												  $def_image      = get_bloginfo('template_directory').'/images/default-gravatar-placeholder.png';

												  if( $author_details ):	
												  	foreach ( $author_details as $author_detail ) :
											?>
											<div class="author-cont">
												<?php
													//$author_name = get_the_author_meta('first_name',$auth_id).", ".get_the_author_meta('last_name',$auth_id);
													$avatar = get_author_image_url($auth_id); // The function uses get_the_ID() to grab the appropirate user ID for the author image.
													//echo _e($sushi->getTimthumbImage( array( 'title' => $author_name, 'alt' => $author_name ), array('w' => 200, 'h' => 200, 'zc' => 1,  'src' => $avatar ) ));

													//$author_details = get_field( 'author_info', $post->ID );

													$author_fname     = $author_detail['author_first_name'];
													$author_lname     = $author_detail['author_last_name'];
													$author_img       = $author_detail['author_image']['url'];
													$author_img_alt   = $author_detail['author_image']['alt'];
													$author_img_title = $author_detail['author_image']['title'];
													$author_bio       = $author_detail['author_biography'];
													$author_fb        = $author_detail['author_fb_link'];
													$author_twit      = $author_detail['author_twitter_link'];
													$author_gplus     = $author_detail['author_google_plus_link'];
													$author_linkedin  = $author_detail['author_linkedin'];
													$author_ytlink    = $author_detail['author_youtube_link'];
													$author_position  = $author_detail['author_position'];

													if( !empty( $author_detail['author_image'] ) ):	
														echo _e($sushi->getTimthumbImage( array( 'title' => $author_fname.' '.$author_fname, 'alt' => $author_fname.' '.$author_fname ), array('w' => 200, 'h' => 200, 'zc' => 1,  'src' => $author_img ) ));
													else:
														echo _e($sushi->getTimthumbImage( array( 'title' => $author_fname.' '.$author_fname, 'alt' => $author_fname.' '.$author_fname ), array('w' => 200, 'h' => 200, 'zc' => 1,  'src' => $def_image ) ));	
													endif;
												?>
												<?php /*<div class="author-dets right">
													<h4><?php echo get_the_author_meta('first_name',$auth_id).", ".get_the_author_meta('last_name',$auth_id);?></h4>
													<div class="description">
														<p><?php echo get_the_author_meta('description',$auth_id);?></p>
													</div>
													<div id="social-icons"> 
														<a target="_blank" title="Facebook" rel="nofollow" href="<?php echo get_the_author_meta('facebook',$auth_id); ?>" class="facebook">Facebook</a>
														<a target="_blank" title="Twitter" rel="nofollow" href="<?php echo get_the_author_meta('twitter',$auth_id); ?>" class="twitter">Twitter</a>
														<a target="_blank" title="Google Plus" rel="nofollow" href="<?php echo get_the_author_meta('googleplus',$auth_id); ?>" class="googleplus">Google Plus</a>
														<a target="_blank" title="LinkedIn" rel="nofollow" href="<?php echo get_the_author_meta('linkedin',$auth_id); ?>" class="linkedin">LinkedIn</a>
														<a target="_blank" title="Youtube" rel="nofollow" href="<?php echo get_the_author_meta('youtube',$auth_id); ?>" class="youtube">Youtube</a>
													</div>
												</div>*/ ?>
												<div class="author-dets right">
													<h4><?php  
													            if( $author_fname != '' ):
													            	echo $author_fname;
													            endif;	

													            if( $author_lname != '' ):
													            	echo ' '.$author_lname;
													            endif; ?>
													</h4>
													<?php echo ( $author_bio ) ? '<div class="description">'.$author_bio.'</div>' : ''; ?>
													<div id="social-icons"> 
														<?php echo ( $author_fb )?       '<a target="_blank" title="Facebook" rel="nofollow" href="'.$author_fb.'" class="facebook">Facebook</a>':''; ?>
														<?php echo ( $author_twit )?     '<a target="_blank" title="Twitter" rel="nofollow" href="'.$author_twit.'" class="twitter">Twitter</a>':''; ?>
														<?php echo ( $author_gplus )?    '<a target="_blank" title="Google Plus" rel="nofollow" href="'.$author_gplus.'" class="googleplus">Google Plus</a>':''; ?>
														<?php echo ( $author_linkedin )? '<a target="_blank" title="LinkedIn" rel="nofollow" href="'.$author_linkedin.'" class="linkedin">LinkedIn</a>':''; ?>
														<?php echo ( $author_ytlink )?   '<a target="_blank" title="Youtube" rel="nofollow" href="'.$author_ytlink.'" class="youtube">Youtube</a>':''; ?>
													</div>
												</div>
												<div class="clr"></div>
											</div>
										    <?php 	endforeach;
										          endif; ?>
										
											<div class="single-nav">
												<?php //previous_post_link('%link', 'Previous case study', TRUE, 9); ?>
												<?php //next_post_link('%link', 'Next case study', TRUE, 9); ?>
												
												<?php previous_post_link('%link', '<span class="prev-arr">&#x2190;</span> Previous article', TRUE); ?>
												<?php next_post_link('%link', 'Next article <span class="next-arr">&#x2192;</span>', TRUE); ?>
												<?php //previous_post_link('%link', '<span class="prev-arr">&#x2190;</span> Previous article', TRUE, 10); ?>
												<?php //next_post_link('%link', 'Next article <span class="next-arr">&#x2192;</span>', TRUE, 10); ?>
											</div>

											<?php comments_template(); ?> 

										</div>								
										<?php get_sidebar('blog'); ?>
										<div class="clr"></div>
									</div>
						<?php endwhile; ?>
						</div>
						<?php /*<!--<div class="single-nav">
							<?php //previous_post_link('%link', 'Previous case study', TRUE, 9); ?>
							<?php //next_post_link('%link', 'Next case study', TRUE, 9); ?>
						</div>-->*/ ?>
					<?php
						endif;
					?>
				</div>				
			</div>
		<?php else: ?>
			<div class="inner-content slide">	<?php //echo $categ_ID; ?>			
				<div class="main-container has-ajax">
					<?php echo breadcrumbs(); ?>
					<div class="single-nav">
						<?php //previous_post_link('%link', 'Previous case study', TRUE, 8); ?>
						<?php //next_post_link('%link', 'Next case study', TRUE, 8); ?>
						<?php //previous_post_link('%link', 'Previous article', TRUE, 8); ?>
						<?php //next_post_link('%link', 'Next article', TRUE, 8); ?>
						<?php previous_post_link('%link', 'Previous article', TRUE); ?>
						<?php next_post_link('%link', 'Next article', TRUE); ?>
						<?php //previous_post_link('%link', 'Previous article', TRUE, $categ_ID, 'category'); ?>
						<?php //next_post_link('%link', 'Next article', TRUE, $categ_ID, 'category'); ?>
					</div>
					<div class="clr"></div>
					<?php if(have_posts()) :
							while(have_posts()): the_post();?>
								<div class="post-<?php echo $pageid; ?> post-content">
									<div class="content-slide">
										<div class="main-post fl-post">
											<?php the_content(); ?>	
										</div>

										<?php $auth_id = get_the_author_meta('ID');
											  $author_details = get_field( 'author_info', $post->ID );
											  $def_image      = get_bloginfo('template_directory').'/images/default-gravatar-placeholder.png';

											  if( $author_details ):		
												  foreach ( $author_details as $author_detail ) : ?>
											<div class="author-cont">
												<?php
													//$author_name = get_the_author_meta('first_name',$auth_id).", ".get_the_author_meta('last_name',$auth_id);
													$avatar = get_author_image_url($auth_id); // The function uses get_the_ID() to grab the appropirate user ID for the author image.
													//echo _e($sushi->getTimthumbImage( array( 'title' => $author_name, 'alt' => $author_name ), array('w' => 200, 'h' => 200, 'zc' => 1,  'src' => $avatar ) ));

													//$author_details = get_field( 'author_info', $post->ID );

													$author_fname     = $author_detail['author_first_name'];
													$author_lname     = $author_detail['author_last_name'];
													$author_img       = $author_detail['author_image']['url'];
													$author_img_alt   = $author_detail['author_image']['alt'];
													$author_img_title = $author_detail['author_image']['title'];
													$author_bio       = $author_detail['author_biography'];
													$author_fb        = $author_detail['author_fb_link'];
													$author_twit      = $author_detail['author_twitter_link'];
													$author_gplus     = $author_detail['author_google_plus_link'];
													$author_linkedin  = $author_detail['author_linkedin'];
													$author_ytlink    = $author_detail['author_youtube_link'];
													$author_position  = $author_detail['author_position'];

													if( !empty( $author_detail['author_image'] ) ):	
														echo _e($sushi->getTimthumbImage( array( 'title' => $author_fname.' '.$author_fname, 'alt' => $author_fname.' '.$author_fname ), array('w' => 200, 'h' => 200, 'zc' => 1,  'src' => $author_img ) ));
													else:
														echo _e($sushi->getTimthumbImage( array( 'title' => $author_fname.' '.$author_fname, 'alt' => $author_fname.' '.$author_fname ), array('w' => 200, 'h' => 200, 'zc' => 1,  'src' => $def_image ) ));	
													endif;
												?>
												<div class="author-dets right">
													<h4><?php  
													            if( $author_fname != '' ):
													            	echo $author_fname;
													            endif;	

													            if( $author_lname != '' ):
													            	echo ' '.$author_lname;
													            endif; ?>
													</h4>
													<?php echo ( $author_bio ) ? '<div class="description">'.$author_bio.'</div>' : ''; ?>
													<div id="social-icons"> 
														<?php echo ( $author_fb )?       '<a target="_blank" title="Facebook" rel="nofollow" href="'.$author_fb.'" class="facebook">Facebook</a>':''; ?>
														<?php echo ( $author_twit )?     '<a target="_blank" title="Twitter" rel="nofollow" href="'.$author_twit.'" class="twitter">Twitter</a>':''; ?>
														<?php echo ( $author_gplus )?    '<a target="_blank" title="Google Plus" rel="nofollow" href="'.$author_gplus.'" class="googleplus">Google Plus</a>':''; ?>
														<?php echo ( $author_linkedin )? '<a target="_blank" title="LinkedIn" rel="nofollow" href="'.$author_linkedin.'" class="linkedin">LinkedIn</a>':''; ?>
														<?php echo ( $author_ytlink )?   '<a target="_blank" title="Youtube" rel="nofollow" href="'.$author_ytlink.'" class="youtube">Youtube</a>':''; ?>
													</div>
												</div>
												<div class="clr"></div>
											</div>
										    <?php endforeach; 
										    	endif; ?>

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