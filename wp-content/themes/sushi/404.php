<?php
/*
* 404
*
* @package WordPress
* @subpackage sushi
*/
get_header();

global $wpdb;
$pageid = get_id();
$data = get_page( $pageid );
?>
	<section id="content-area" class="error-page">
		<div class="heading">
			<div class="heading-title">
				<h1>Error 404, Page Not Found!</h1>
				<h2>Sorry, the page you're trying to open does not exist.</h2>
			</div>	
		</div>
	</section>

<?php get_footer(); ?>