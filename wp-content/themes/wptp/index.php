<h3>Set in index
    <?php get_header(); ?>
</h3>

<div class="container">
    <div class="content">
        <?php
        while (have_posts()) :
            the_post();
            // include the template core-content.php that fleshes out the body 
            // of the page instead of keeping the code in index.php
            get_template_part('core-content');


        endwhile;
        ?>
    </div>
    <!--div><?php dynamic_sidebar('wptp_area_id'); ?></div-->
    <!-- get_sidebar() calls sidebar.php -->
    <div><?php get_sidebar('wptp_area_id'); ?></div>
</div>
<?php
get_footer();
