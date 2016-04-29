<?php
/*
* Theme's footer area.
*
* @package WordPress
* @subpackage sushi
*/
global $sushi;
?>
	
	<footer id="footer">
		<div class="back-to-top"><a href="#">Back to Top</a></div>		
		<div class="main-container">
			<p class="copyright fL">&copy; <?php echo date('Y'); ?> <a href="<?php echo get_bloginfo('url'); ?>">Zoodata</a>  &nbsp;<span style="margin: 0px 5px;border-left: 1px solid #a2a2a2;">&nbsp;</span>  ABN: 45 120 487 078</p>
			<div id="footer-nav" class="fL">
				<?php wp_nav_menu(array( 'menu' => 'footer')); ?>	
			</div>
			<div class="clr"></div>
		</div>
	</footer>
</div>
<!-- /main-wrapper -->
	<?php if( is_front_page() ) :?>
		<?php 
			$id = get_pageid_by_slug( 'home' );
			
			if( get_field( 'slider', $id ) ) :
				$index = 0;
				foreach( get_field( 'slider', $id ) as $gal ) {
					$imgSlide = $gal['image'];							
					$arrImagesData = $imgSlide['url'];
					$arrCaption = $gal['caption'];
					$height = 1200;
					$width = 1920;
					$arrImages[] = "{img: '" . $arrImagesData . "', caption: '" . htmlspecialchars_decode($arrCaption) . "'}";
					echo '<input type="hidden" id="'.$index.'" data-height="'.$height.'" data-width="'.$width.'"/>';
					$index++;
				}
				$images = implode(', ', $arrImages);
				
			endif;					
		?>	
		
		<script type="text/javascript">
			$(document).ready(function(){
				if($('body').hasClass('home')){
					var items = [
						<?php echo $images; ?>
					];	
					jQuery( function($) {		
						var options = {fade: 750, duration: 6000};
						var images = $.map(items, function(i) { return i.img; });
						var $navs = $("#banner .pagination ul li");
						var instance = $("body").data("backstretch");
						$.backstretch(images,options);
						$(window).on("backstretch.show", function(e, instance) {
							
							var path = items[instance.index].img;
							var ht = $(".backstretch").find('img').height();
							var wt = $(".backstretch").find('img').width();
							var newCaption = items[instance.index].caption;
							var imgpath = '<?php bloginfo('template_directory');?>/library/timthumb/timthumb.php?src=' + path + '&h='+ ht + '&w=' + wt;
							$(".backstretch").find('img').attr({'src' : imgpath, 'height' : ht, 'width' : wt});
							$(".backstretch-caption").html(newCaption);
							//console.log(imgpath);
						});
						$('#banner .pagination ul li').first().addClass('active');

						$(window).on("backstretch.before", function (e, instance, index) {
							$('#banner .pagination ul li').removeClass('active').eq(index).addClass('active');
						});

						$navs.click(function () {
							// console.log('test');
							// console.log($(this).val());
							//var index = $navs.index( $(this) );
							//e.preventDefault();
							//$(this).removeClass('active');
							//$('#banner .pagination ul li.active').removeClass('active');
							//$(this).addClass('active');
							//$("body").data("backstretch").show($(this).value);

							//return false;
							$("body").data("backstretch").show($(this).val());
						});
					});
				}
			});	
		</script>
	<?php endif; ?>

<script type="text/javascript" src="<?php _e( "{$sushi->templateURL}/js/global.js" . $sushi->getTimeSuffix() ); ?>"></script>
<?php $sushi->getGACode(); ?>

<script>
         (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
         m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
         })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        
        ga('create', 'UA-54094537-1', 'auto');
          ga('send', 'pageview');
        
        </script>

</body>
</html>
