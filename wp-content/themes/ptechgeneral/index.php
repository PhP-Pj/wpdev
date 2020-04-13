<?php
display_welcome();
get_header();


while (have_posts()) :
    the_post(); ?>
    <h2 class="the-title>">Title: <?php the_title()?></h2>
    <?php the_content();
endwhile;
?>
<div><?php dynamic_sidebar('ptech_wdgt_area');?></div>
<?php
get_footer();
