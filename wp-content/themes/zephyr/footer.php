<?php
global $zephyr_main_layout;
global $zephyr_page_layout;
?>
<div id="ajaxload"><img src="<?php echo get_template_directory_uri(); ?>/img/loader.gif" alt="Loading..." /></div>
</section>
	<footer>
		<div class="row">
			<div class="col-md-12 credits">			
				<?php echo get_theme_mod('zephyr_footertext'); ?>
			</div>
		</div>
	</footer>
<?php
if ( $zephyr_main_layout == 'boxed' ) {
	echo '</div>';
}
zephyr_get_optin();
wp_footer(); 
if ( get_theme_mod('zephyr_scrolltop') ) {
?>
	<a href="#" id="scrolltotop"></a>
<?php } ?>
</body>
</html>