<?php
global $zephyr_page_slider;
$ids = explode(',',$zephyr_page_slider);
?>
	<section id="bigslider" class="row">
		<div id="carousel-bigslider" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
			<?php 
			$i = 0;
			foreach ( $ids as $id ) {
				$class = '';
				if ( $i == 0 ) {
					$class = 'active';
				}	
				echo '<li data-target="#carousel-bigslider" data-slide-to="'.$i.'" class="'.$class.'"></li>';
				$i++;
			} ?>
			</ol>
			<div class="carousel-inner">
			<?php
			$i = 0;
			foreach ( $ids as $id ) {
				$class = '';
				if ( $i == 0 ) {
					$class = 'active';
				}
				$img = wp_get_attachment_image( $id, 'zephyr-postlist' );
				echo '<div class="item '.$class.'">'.$img.'</div>';
				$i++;
			}
			?>
			</div>
		</div>		
	</section>