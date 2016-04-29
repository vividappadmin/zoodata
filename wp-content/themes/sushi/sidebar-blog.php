<div id="blog-sidebarNav" class="fR">
	<div class="searchBox">
		<!-- <form action="">
			<input type="text" name="search">
			<input type="submit" value="search">
		</form> -->

		<?php get_search_form(); ?>
		<div class="clr"></div>
	</div>	
	<div id="recent-post">
		<h3>Recent posts</h3>
		<?php 
			$args = array(
					'posts_per_page' 	=> 4,
					'category_name' => 'Blog',
					'post_type' => 'post',
					'post_status' => 'publish',
					'orderby'=> 'date', 
					'order' => 'DESC');
				
				$wp_query = new WP_Query($args);
				if ($wp_query->have_posts()) :
					while($wp_query->have_posts()): $wp_query->the_post();
						?>
							<div class="list">
								<h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
								<span class="dates"><?php the_time('F j, Y'); ?></span>
							</div>	
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
			?>
	</div>
	<div id="newsletter">
		<?php add_filter( 'mc4wp_form_css_classes', function( $classes ) {  $classes[] = 'form-inline'; return $classes; }); ?>
        <?php echo do_shortcode('[mailchimpsf_form]'); ?>
	</div>
	<div id="categories">
		<h3>Categories</h3>
		<?php 			
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '10',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 1,
				'hierarchical'             => 1,
				'exclude'                  => '5,6,7,8',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false 
			);
			$categories = get_categories( $args ); #_pr($categories);
			
			foreach($categories as $cat) :
		?>
			<div class="list">
				<h4>
					<?php
						if( $cat->cat_ID == 5 || $cat->cat_ID == 6 || $cat->cat_ID == 7 ) :
					?>
						<a href="<?php echo home_url(); ?>/sectors/<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></a>
					<?php else : ?>
						<a href="<?php echo home_url(); ?>/<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></a>
					<?php endif; ?>
				</h4>
			</div>
		<?php endforeach;
			wp_reset_query();
		?>
	</div>
	<div id="tags">
		<h3>Tags</h3>
		<?php
			$tags = get_tags();
			$html = '<div class="post_tags">';
			foreach ( $tags as $tag ) {
				$tag_link = get_tag_link( $tag->term_id );
						
				$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
				$html .= "{$tag->name}</a>";
			}
			$html .= '</div>'; 
			echo $html;
		?>
	</div>
</div>