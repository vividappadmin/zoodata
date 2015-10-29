<?php
/*
* Theme's Front Page.
*
* @package WordPress
* @subpackage Sushi
*/

get_header();

global $wpdb;
$pageid = get_id();
$data = get_page( $pageid );
?>
	<section id="banner">
		<div id="slider">
			<ul class="slides">
				<li>
					<img src="<?php echo get_template_directory_uri(); ?>/images/img-slides.jpg" alt="">
					<div class="caption">
						<h1>We love difficult data</h1>
						<p><a href="#">Database support</a> and <a href="#">system development</a></p>
					</div>
				</li>
				<li>
					<img src="<?php echo get_template_directory_uri(); ?>/images/img-slides.jpg" alt="">
					<div class="caption">
						<h1>We love difficult data 1</h1>
						<p><a href="#">Database support</a> and <a href="#">system development</a></p>
					</div>
				</li>
				<li>
					<img src="<?php echo get_template_directory_uri(); ?>/images/img-slides.jpg" alt="">
					<div class="caption">
						<h1>We love difficult data 2</h1>
						<p><a href="#">Database support</a> and <a href="#">system development</a></p>
					</div>
				</li>
				<li>
					<img src="<?php echo get_template_directory_uri(); ?>/images/img-slides.jpg" alt="">
					<div class="caption">
						<h1>We love difficult data 3</h1>
						<p><a href="#">Database support</a> and <a href="#">system development</a></p>
					</div>
				</li>
			</ul>
		</div>
		<div id="home-arrow"></div>
	</section>
	<section id="who-we-are">
		<div class="main-container">
			<div class="post-content fL">
				<h2>Who we are</h2>
				<p>We are an IT company specialising in on-site database support  and system development for health, local government and corporate sectors. Our services and products make your service delivery system stable, fast and friendly.</p>
				<a href="#" class="btn-more-bg">More about Zoodata</a>
			</div>
			<div class="img-holder fR">
				<img src="<?php echo get_template_directory_uri(); ?>/images/who-we-are.jpg" alt="">
			</div>
			<div class="clr"></div>
		</div>
	</section>
	<section id="customer-success">
		<div class="main-container">
			<div class="img-holder fL">
				<img src="<?php echo get_template_directory_uri(); ?>/images/customer-success.png" alt="">
			</div>
			<div class="post-content fR">
				<h2>Customer success stories</h2>
				<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla tincidunt turpis lorem. Donec nec conv allis risus. In et congue dolor sit amet adipiscing ."</p>
				<span class="person-info">Firstname Lastname, Job Title</span>
				<span class="company-info">Company, Project name</span>
				<a href="#" class="view-more">View more Health sucess stories</a>
			</div>
			<div class="clr"></div>
		</div>
	</section>
	<section id="latest-news">
		<div class="main-container">
			<h2>Latest Zoodata News</h2>
			<div class="news-post-content">
				<div class="list">
					<h3>News subheading lipsum.</h3>
					<span class="date">16th April 2014</span>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla tincidunt turpis lorem. Donec nec con vallis risus, ac pulvinar est congue risus id orci id risus...
						<a href="#" class="readmore">Read more</a>
					</p>
					<div class="social-links">
						<a href="#" class="facebook">Facebook</a>
						<a href="#" class="linkedin">Linkedin</a>
						<a href="#" class="tweet">Tweet</a>
					</div>
				</div>
				<div class="list">
					<h3>News subheading lipsum.</h3>
					<span class="date">16th April 2014</span>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla tincidunt turpis lorem. Donec nec con vallis risus, ac pulvinar est congue risus id orci id risus...
						<a href="#" class="readmore">Read more</a>
					</p>
					<div class="social-links">
						<a href="#" class="facebook">Facebook</a>
						<a href="#" class="linkedin">Linkedin</a>
						<a href="#" class="tweet">Tweet</a>
					</div>
				</div>
				<div class="list">
					<h3>News subheading lipsum.</h3>
					<span class="date">16th April 2014</span>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla tincidunt turpis lorem. Donec nec con vallis risus, ac pulvinar est congue risus id orci id risus...
						<a href="#" class="readmore">Read more</a>
					</p>
					<div class="social-links">
						<a href="#" class="facebook">Facebook</a>
						<a href="#" class="linkedin">Linkedin</a>
						<a href="#" class="tweet">Tweet</a>
					</div>
				</div>
			</div>
			<div class="clr"></div>
		</div>
	</section>
	<section id="home-contact">
		<div class="main-container">
			<div class="box">
				<h2>Contact us</h2>
				<span class="address">Level 3, 68 St Georges Tce, Perth, Western Australia, 6000 <a href="#">Get directions</a></span>
				<span>Phone	+61 (08) 9485 0725</span>
				<span>Fax +61 (08) 9485 0728</span>
				<a href="#" class="send-email">Send us an email</a>
			</div>
		</div>
	</section>

<?php get_footer(); ?>