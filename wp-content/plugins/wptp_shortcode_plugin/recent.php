<?php
/*
    Shortcode usage:
    [sortcode att1=val1 att2=val2] or
    [sortcode att1=val1 att2=val2]some content[/shortcode]
*/
class RecentPost {
    public function __construct()
    {
        add_shortcode('recent_articles', array($this, 'recent_html'));
    }

    /*
        $atts: shortcode attributes, 
        $content: shortcode content if any, 
        $name: shortcode name
        The function should never produce output of any kind. 
        Shortcode functions should return the text that is to be used to replace the shortcode.
    */
    public function recent_html($atts, $content, $name) {
        write_log("aading shortcode: ".$name);
        // With the WP function sortcode_atts we can default attributes in case
        // there were not supllied when used in the post
        // If any other parameters were supplied shortcode_atts would delete them
        $atts = shortcode_atts(array('postsnumber' => 1), $atts);
        // WP function get_posts returns a list of latest posts
        $posts = get_posts($atts);

        // to return the html we will use the PHP implode( string $glue , array $pieces)
        // function which returns a string containing a string representation of all 
        // the array elements in the same order, with the glue string between each element.
        // It's a python "".join()
        $html = array();
        $html[] = $content;
        $html[] = '<ul>';
        $max = min($atts['postsnumber'], count($posts));
        for ($i = 0; $i < $max; $i++) {
            $html[] = '<li><a href="'.get_permalink($posts[$i]).'">'.$posts[$i]->post_title.'</a></li>';
        }
        $html[] = '</ul>';

        echo implode('', $html);
    }
}