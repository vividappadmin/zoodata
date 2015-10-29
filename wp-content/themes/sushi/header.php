<?php
/*
* The header of the theme.
*
* @package WordPress
* @subpackage sushi
*/
global $sushi;
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title><?php wp_title( "|", true, 'right' ); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=1300"  />

<?php wp_head(); ?>
<?php $sushi->getSiteVerificationMeta(); ?>

<link rel="stylesheet" type="text/css" media="screen" href="<?php _e( "{$sushi->templateURL}/css/global.css" . $sushi->getTimeSuffix() ); ?>" />
<link rel="shortcut icon" type="image/x-icon" href="<?php _e( $sushi->templateURL ); ?>/Zoodata-favicon.ico" />
<script type="text/javascript" src="<?php _e( $sushi->templateURL ); ?>/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php _e( $sushi->templateURL ); ?>/js/jquery-plugins/jquery.sushi.min.js"></script>
<script type="text/javascript" src="<?php _e( $sushi->templateURL ); ?>/js/jquery-plugins/skrollr.js"></script>
<script type="text/javascript" src="<?php _e( $sushi->templateURL ); ?>/js/jquery-plugins/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="<?php _e( $sushi->templateURL ); ?>/js/jquery-plugins/jquery.backstretch.min.js"></script>
<script type="text/javascript" src="<?php _e( $sushi->templateURL ); ?>/js/jquery-plugins/imagesloaded.js"></script>

<!--[if lt IE 9]>
<script src="<?php _e( $sushi->templateURL ); ?>/js/html5shiv.js"></script>
<script src="<?php _e( $sushi->templateURL ); ?>/js/jquery-plugins/jquery.ie-media-queries.js"></script>
<style type="text/css">
	* {	*behavior: url( "<?php _e( $sushi->templateURL ); ?>/css/boxsizing.htc" ); }
</style>
<![endif]-->

<?php if( is_front_page() ) :?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSl_b1CeGWvL43P94VlsWdb20d2YSJ_9A"></script>
	<script type="text/javascript">
		function initialize() {
			var myLatlng = new google.maps.LatLng(-31.955228,115.858244)
			var mapOptions = {			
				zoom: 15,
				center: myLatlng,
				scrollwheel: false
			};
			var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
			
			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map
			});
		}
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
<?php endif; ?>
</head>
<?php flush(); ?>
<body <?php body_class(); ?>>
<div id="main-wrapper">
	<header id="header" class="header-top">
		<div class="main-container">			
			<div id="logo" class="fL">
				<a href="<?php echo bloginfo('url'); ?>">
					<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Zoodata" title="Zoodata" width="245" height="78">
				</a>
			</div>	
			<?php $home = get_pageid_by_slug( 'home' )?>
			<p id="phone" class="fR">Ph. <?php the_field('phone_number', $home); ?></p>
			<div class="clr"></div>	
			<div id="main-nav" class="fL">
				<?php wp_nav_menu( array( 'menu' => 'main' ) ); ?>	
			</div>
			<div id="social-icons" class="right">
				<a target="_blank" title="Facebook" rel="nofollow" href="<?php the_field('facebook_link', $home); ?>" class="facebook">Facebook</a>
				<a target="_blank" title="Twitter" rel="nofollow" href="<?php the_field('twitter_link', $home); ?>" class="twitter">Twitter</a>
				<a target="_blank" title="Google Plus" rel="nofollow" href="<?php the_field('google_plus_link', $home); ?>" class="googleplus">Google Plus</a>
				<a target="_blank" title="LinkedIn" rel="nofollow" href="<?php the_field('linkedin_link', $home); ?>" class="linkedin">LinkedIn</a>
				<a target="_blank" title="Youtube" rel="nofollow" href="<?php the_field('youtube_link', $home); ?>" class="youtube">Youtube</a>
			</div>
		</div>
	</header>
