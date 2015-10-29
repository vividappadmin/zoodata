<?php
/*
* Archive.
*
* @package WordPress
* @subpackage sushi
*/
	get_header();

	global $wpdb;
	$pageid = get_id();
	$data = get_page( $pageid );


	if( !empty($_REQUEST['s']) ) { echo 'test';
		query_posts(array( 's' => $_REQUEST['s'] , 'cat' => 9,-5,-7,-6,-8 ));
	}
?>
	<div id="content-area" class="row">
		<div class="main-container">
			<div class="main-content left">
				<h1><?php _e( $data->post_title ); ?></h1>
					<?php 
						if ( have_posts() ) : 
							while ( have_posts() ) : the_post();
					?>
							<div class="post">
								<div class="date left">
									<div class="date-content">
										<div class="day left">
											<?php echo get_the_date( 'd' ); ?>
										</div>
										<div class="month-year right">
											<?php echo get_the_date( 'M Y' ); ?>
										</div>
										<div class="clr"></div>
									</div>
								</div>
								<div class="post-content left">
									<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
									<div class="comments right"><a href="<?php echo get_permalink(); ?>"><?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></a></div>
									<div class="clr"></div>
									<?php 
										if( has_post_thumbnail() ) :
											$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full');
									?>
										<div class="img-holder">
											<img src="<?php bloginfo( "home" ); ?>/timthumb.php?q=95&zc=1&w=704&h=282&src=<?php echo $image_url[0]; ?>" alt="<?php echo $post->post_title; ?>" title="<?php echo $post->post_title; ?>" />
										</div>
									<?php endif; ?>
									<div class="clr"></div>
									<?php echo apply_filters( 'the_content', shorten_string( get_the_content(), 40 ) ); ?>
									<a class="read-more" href="<?php the_permalink(); ?>">Read more</a>
								</div>
								<div class="clr"></div>
							</div>
					<?php 
							endwhile; 
						endif;  
						
						$total = $post->max_num_pages;						
						if ( $total > 1 )  {
							
							if ( !$current_page = get_query_var('paged') )
								$current_page = 1;
							
							$ps = get_option('permalink_structure');
							$format = empty( $ps ) ? '&page=%#%' : '?paged=%#%';
							 
							echo sprintf( '<div id="pagination">%s</div>', 
								paginate_links(array(
									'base'		=> @add_query_arg('paged','%#%'),
									'format'	=> $format,
									'current'	=> $current_page,
									'total'		=> $total,
									'prev_text'	=> __('&larr;'),
									'next_text'	=> __('&rarr;'),
									'show_all'	=> true
								))
							);
						}
					?>
				
			</div>
			<div class="sidebar left">
				<?php get_sidebar( 'blog' ); ?>
			</div>
			<div class="clr"></div>
		</div>
	</div>
<?php get_footer(); ?>