<article calss="post">
    <?php the_post_thumbnail();

        if (is_front_page()) {
            echo "I am in index.php but doing Front Page stuff";
        }
        if (is_category('gerdening')) {
            echo "I am in index.php but doing Category Gardening stuff!";
        }
    ?>
    <h1 class="the-title>"><?php the_title() ?></h2>
    <?php 
        if ( has_category() ) {
            echo "<div>Categories: </div>";
            the_category();
        }
        the_content();
        comments_template();
        comment_form();
    ?>
</article>
<ol>
  <?php wp_list_comments(); ?>
</ol>
