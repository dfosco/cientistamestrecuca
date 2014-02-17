<?php
// adding support for thumbnails 
add_theme_support( 'post-thumbnails' ); 
// add zephyr specific thuumbnail sizes
add_image_size('zephyr-postlist', 1920, 662, true);
add_image_size('zephyr-related', 300, 150, true);
add_image_size('zephyr-galllery-2col', 580, 580, true);
add_image_size('zephyr-galllery-3col', 450, 450, true);
add_image_size('zephyr-galllery-4col', 300, 300, true);
?>