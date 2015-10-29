<?php
/**
 * Sushi WordPress Starter System
 * Copyright (C) 2013-2014, Sushi Digital Pty. Ltd. - http://sushidigital.com.au
 * 
 * This program is not a free software; this program is an intellectual
 * property of Sushi Digital Pty. Ltd. and CANNOT be REDISTRIBUTED, COPIED, 
 * MODIFIED or USED by ANY MEANS outside and/or unrelated to the company.
 * Disregarding this copyright notice is an act of copyright infringement, 
 * and is subject to civil and criminal penalties.
 */

/***
 * The function name is determined by the option name prefixed by "tips_".
 */

function tips_footer_sig()
{
	return '<p>Call <code>swp_footer_sig()</code> function to output the signature.<br /><br /></p>			
			<p>Filters:<br />
			<code>swp_footer_sig</code> &#8212; HTML output.<br />
			<code>sig_permalink_webdesign</code> &#8212; Permalink for web design service.<br />
			<code>sig_permalink_ecommerce</code> &#8212; Permalink for e-commerce service.<br /><br /></p>
			<p>Ex. <code>&lt;p class="site-by"&gt;&lt;?php echo swp_footer_sig(); ?&gt;&lt;/p&gt;</code></p>';
}

function tips_enable_css3_pie()
{
	return '<p>See <a target="_blank" href="http://css3pie.com/">http://css3pie.com/</a>.</p>';
}

function tips_google_ad_code_footer()
{
	return '<p>The script will be placed at the bottom before the closing body tag <code>&lt;/body&gt;</code>.</p>';
}

function tips_enable_swp_icons()
{
	$icons = swp_assets_url( '/styles/icons/SWP Icons Guide.html' );
	return '<p>Font Icons are scalable vector icons that can be easily customized &#8212; size, color, shadow, and pretty much anything that can be done using the power of CSS. 
	Checking this option will load the necessary assets at front-end. Font Icons are accessible through classes. See <a target="_blank" href="' . $icons . '">SWP Icons Guide</a> to view all the available icons. This is turned off by default.<br /><br /></p>
			<p>Ex. <span class="swp-icon-facebook2" style="color: #46629E;"></span> &#8212; &lt;span class="swp-icon-facebook2" style="color: #46629E;"&gt;&lt;/span&gt;<br /></p>';
}

function tips_force_wordpress_admin_skin()
{
	return '<p>If checked, the Dashboard will revert to Vanilla styles without disabling the system. Built-in functions and features will still run and execute.</p>';
}

/*
* END OF FILE
* admin/includes/tips-and-guides.php
*/
?>