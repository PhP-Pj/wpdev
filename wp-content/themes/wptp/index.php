<?php
get_header();

wp_nav_menu(array('theme_location' => 'main_menu'));

while (have_posts()) :
    the_post(); ?>
    <h2 class="the-title>">Title: <?php the_title()?></h2>
    <?php the_content();
endwhile;
?>
<div><?php dynamic_sidebar('wptp_area_id');?></div>
<?php
get_footer();
