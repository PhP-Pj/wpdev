<?php
get_header();

wp_nav_menu(array('theme_location' => 'main_menu'));
?>
<h3>Front Page</h3>
<div><?php dynamic_sidebar('wptp_area_id');?></div>
<?php
get_footer();
