<?php
/*
* Template Part Headings
*/
global $wpdb, $sushi;
$pageid = get_id();
$data = get_page( $pageid );
?>
<?php $bgURL = get_field("image", $pageid); #_pr($bgURL);?>
<span id="bgUrl" style="display: none;"><?php echo ($bgURL)? $bgURL : get_bloginfo('template_directory').'/images/default-slider-img.jpg';?></span>
<div id="post-<?php echo $pageid; ?>" class="heading" style="background: url('<?php echo $bgURL; ?>') no-repeat center center; background-size: cover;">
	<div id="heads" class="heading-title">
		<div class="hsContainer">
			<img class="smiley" src="<?php bloginfo('template_url');?>/images/bg_heading-02.png" />
			<div class="main-container">
				<div class="hsContent" data-center="opacity: 1" data-206-top="opacity: 1" data-106-top="opacity: 0" data-anchor-target="#heads .fadeOut">
					<div class="fadeOut caption">
						<h1><?php the_title(); ?></h1>
						<h2><?php the_field('sub_heading'); ?></h2>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
