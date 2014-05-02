<footer>
		<div class="grid_10 push_1 omega clearfix">
			<div class="grid_4 footer_left">
				<?php if( dynamic_sidebar( 'footer_left' ) ): ?>

				<?php else: ?>
				
					<h5>Twitter</h5>
					<p>Install the TwiGet plugin</p>
					
				<?php endif; ?>
			</div>
			<div class="grid_4 footer_middle">

				<?php if( dynamic_sidebar( 'footer_middle' ) ): ?>

				<?php else: ?>

					<h5>Dribbble</h5>
					<p>Install the Dribble Wordpress plugin</p>
				<?php endif; ?>
			</div>
			<div class="grid_4 footer_right omega">

				<?php if( dynamic_sidebar( 'footer_right' ) ): ?>

				<?php else: ?>

				<h5>Treehouse</h5>
				<p>Install the Treehouse Badges plugin</p>
				<?php endif; ?>
				
			</div>
		</div>
					<div id="copyright" class="grid_10 push_1">
				<p>&copy; Copyright <?php echo date('Y'); ?> <a href="#">Treehouse</a>. All Rights Reserved.</p>
			<div class="grid_12 ss-icon omega">
					<a href="#">&#xF610;</a>
					<a href="#">&#xF611;</a>
					<a href="#">&#xF612;</a>
					<a href="#">&#xF613;</a>
					<a href="#">&#xF660;</a>
					<a href="#">&#x2709;</a>
			</div>
			</div>
		</footer>

<?php wp_footer(); ?>

</body>
</html>