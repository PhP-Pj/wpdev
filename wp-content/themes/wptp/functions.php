<?php


/*
All themes must have a zone where widgets can be added.
We are are registering a sidebar 'child2017_sb' for our widgets
*/

add_action('widgets_init', 'wptp_sidebar');

function wptp_sidebar() {
    register_sidebar(array(
        'id' => 'wptp_area_id',
        'name' => 'Widget area',
        'description'  => 'Show widgets added from the Dashboard',
        'before_widget'  => '<aside',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1>',
        'after_title'  => '</h1>',
    ));
}


add_action('init', 'wptp_add_menu');
function wptp_add_menu()
{
    register_nav_menu('WpTP Main Menu ', 'Location of wptpmenu');
}

if (!function_exists('write_log')) {

    // To log data or objects
    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}

