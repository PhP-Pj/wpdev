<?php
/*
All themes must have a zone where widgets can be added.
We are are registering a sidebar 'child2017_sb' for our widgets
*/

add_action('widgets_init', 'child_2017_add_sidebar');

function child_2017_add_sidebar() {
    register_sidebar(array(
        'id' => 'child2017_wdgt_area',
        'name' => 'Upper area',
        'description'  => 'Will show up at the top of the screen',
        'before_widget'  => '<asside',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1>',
        'after_title'  => '</h1',
    ));
}