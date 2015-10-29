<?php
/*
* Sidebar section.
*
* @package WordPress
* @subpackage sushi
*/
?>
<div id="sidebar" class="fL">	
	<div class="testimonial">
		<ul class="slides">
		<?php if(get_field('testimonials')) : 
				while(has_sub_field('testimonials')) : 
				$img = get_sub_field('image');
				$icon = get_sub_field('icon');			
				?>	
				<li>
					<?php if($img['url']) :  ?>
					<img src="<?php bloginfo('template_directory');?>/library/timthumb/timthumb.php?src=<?php echo $img['url']; ?>&h=358&w=337" alt="<?php echo $img['alt']; ?>" title="<?php echo $img['alt']; ?>" width="337" height="358">
					<?php 
					endif; ?>
					<?php the_sub_field('content'); ?>
					<div class="info">
						<?php if($icon['url']) : ?>
						<img class="left" src="<?php bloginfo('template_directory');?>/library/timthumb/timthumb.php?src=<?php echo $icon['url']; ?>&h=78&w=78" alt="<?php echo $icon['alt']; ?>" title="<?php echo $icon['title']; ?>" height="78" width="78">
						<?php 
						endif; ?>
						<?php the_sub_field('info'); ?>
					</div>
					<div class="clr"></div>
				</li>
			<?php endwhile;
			endif;
		?>
		</ul>
		<div class="clr"></div>
	</div>
</div>