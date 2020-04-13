<?php
/* 
This functions.php file is included at the very begining of the WordPress 
starting process and executes every line of the file.
Therefore things like:
    - add_action
    - add_filter
    - ... 
are executed a init time.
/*
Can be called from anywhere in the theme.
We chose to call it from index.php
*/
function display_welcome() {
    echo 'From functions: Welcome To The PTech Theme';
}

/*
All themes must have a zone where widgets can be added.
We are are registering a sidebar 'child2017_sb' for our widgets
*/

add_action('widgets_init', 'ptech_add_sidebar');

function ptech_add_sidebar() {
    register_sidebar(array(
        'id' => 'ptech_wdgt_area',
        'name' => 'Upper area',
        'description'  => 'Will show up at the top of the screen',
        'before_widget'  => '<asside',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1>',
        'after_title'  => '</h1',
    ));
}

/*
filters: we are creating a filter and applying it to title
*/
function crazy_casing($some_text) {
    $to_crazy = "";
    for ($i = 0; $i < strlen($some_text); $i++) {
        if ( $i % 2 ) {
            $to_crazy = $to_crazy . strtolower($some_text[$i]);
        }
        else {
            $to_crazy = $to_crazy . strtoupper($some_text[$i]);
        }
    }
    return $to_crazy;
}

add_filter('the_title', 'crazy_casing');