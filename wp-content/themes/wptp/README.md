# Creating a new theme

## Base

* Add a new folder to wp-content/themes
* add an index.php an style.css files to the folder
* in style.css add as a comment the declaration of the theme

```
/*
Theme Name: Long theme name
Theme URI: http://my.wpdev.com:88/
Author: 
Author URI: http://my.wpdev.com:88/
Description: Our General theme is designed to cater for all the general feature a modern web site would need.
Requires at least: 4.9.6
Requires PHP: 5.2.4
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ptechgeneral
Tags: one-column, flexible-header, accessibility-ready, custom-colors, custom-menu, custom-logo, editor-style, featured-images, footer-widgets, rtl-language-support, sticky-post, threaded-comments, translation-ready

This theme, like WordPress, is licensed under the GPL.
Use it to make something even cooler, have fun, and share what you've learned with others.

Ptech General is based on Underscores https://underscores.me/, (C) 2012-2019 Automattic, Inc.
Underscores is distributed under the terms of the GNU GPL v2 or later.
*/
```

* a funcstions.php file that will declare all we need at init time and our own "gloabl functions"

### add_action

An action is a function called upon an event, for instance when a post is saved.  
The save action will trigger an "save_post" event that other functions will listen to (Observer pattern) and run some code.
To register the function for an event we use **add_action**.

```
add_action('event_name', 'function name', priority=10);
```

### do_action

An action is actually called with **do_action**

```
do_action('event name', arg1...arg1); //args been the aguments passed to the action
```

For instance the **save_post event** triggers the **save_post acction** located in wp-includes/post.php as

```
do_action('save_post', $post->ID, $post);
```

## Child Themes

It is possible to inherit from a theme by creating a child theme.  
To create a child theme just ad to the style.css child theme the templates in inherits from.  

style.css

```
/*
Theme Name: Mon template hérité
Template: twentythirteen
*/
```

### Parent style

To inherits the parent style as well and tweak it the add to style.css:  

```
@import url("../twentythirteen/style.css");
.site-header h1 {
    color:green;
}
```

### Parent logic

It is possible to override the parent logic for instance **footer.php** by just redining it the child theme.

footer.php:

```
<footer id="colophon" role="contentinfo">
    <div class="site-info">
        New child footer.
    </div>
</footer>
```


## Widgets

It is best to add widget trough the dashboard but to appear in the dasboard 
we need to define at least one zone for the widget and register it in functions.php.

```
<?php
add_action('widgets_init','zero_add_sidebar');
function zero_add_sidebar()
{
    register_sidebar(array(
        'id' => 'my_custom_zone',
        'name' => 'Zone supérieure',
        'description' => 'Apparait en haut du site',
        'before_widget' => '<aside>',
        'after_widget' => '</aside>',
        'before_title' => '<h1>',
        'after_title' => '</h1>'
    ));
}
```

## Menus

Just like widgets a zone must be defined and registered for menus with
**register_nav_menu('menu_id', 'Menu name")**.  

```
<?php
add_action('init', 'zero_add_menu');
function zero_add_menu()
{
    register_nav_menu('main_menu', 'Menu principal');
}
```
