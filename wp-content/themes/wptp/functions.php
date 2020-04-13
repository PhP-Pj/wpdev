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
        'before_widget'  => '<asside',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1>',
        'after_title'  => '</h1>',
    ));
}


add_action('init', 'wptp_add_menu');
function wptp_add_menu()
{
    register_nav_menu('main_menu', 'WpTP Main Menu');
}