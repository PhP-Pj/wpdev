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

* a functions.php file that will declare all we need at init time and our own "global functions"

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

For instance the **save_post event** triggers the **save_post action** located in wp-includes/post.php as

```
do_action('save_post', $post->ID, $post);
```

## Fallback mechanism

Even though in theory it is possible to manage the entire site from index.php, it would be very poor practice because the code would look like a bowl of spaghetti.  
To make it easier to decouple WordPress develop this principle of reading a file depending on the context of the current page.  
For instance to display the **list of posts** related to a **category** the file **category.php** will be called. If it doesn't exist WordPress will fallback to index.php.  
Now if the category was **gardening** WordPress would look for the file **category-gardening.php** first before falling back to **category.php**

### Structure of a theme

* assets (dir)
      - css (dir)
      - images (dir)
      - js (dir)
* inc (dir)
* template-parts (dir)
      - footer (dir)
      - header (dir)
      - navigation (dir)
      - page (dir)
      - post (dir)
* 404.php
* archive.php
* comments.php
* footer.php
* front-page.php
* functions.php
* header.php
* index.php
* page.php
* README.txt
* rtl.css
* screenshot.png
* search.php
* searchform.php
* sidebar.php
* single.php
* style.css

If your blog is at http://example.com/blog/ and a visitor clicks on a link to a category page such as http://example.com/blog/category/your-cat/, WordPress looks for a template file in the current theme’s directory that matches the category’s ID to generate the correct page. More specifically, WordPress follows this procedure:

* Looks for a template file in the current theme’s directory that matches the category’s slug. If the category slug is “unicorns,” then WordPress looks for a template file named category-unicorns.php.
* If category-unicorns.php is missing and the category’s ID is 4, WordPress looks for a template file named category-4.php.
* If category-4.php is missing, WordPress will look for a generic category template file, category.php.
* If category.php does not exist, WordPress will look for a generic archive template, archive.php.
* If archive.php is also missing, WordPress will fall back to the main theme template file, index.php.


### Template files

See [common template files](https://developer.wordpress.org/themes/basics/template-files/#common-wordpress-template-files)

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

It is possible to override the parent logic for instance **footer.php** by just redefining it in the child theme.

footer.php:

```
<footer id="colophon" role="contentinfo">
    <div class="site-info">
        New child footer.
    </div>
</footer>
```


## Widgets

It is best to add widget trough the dashboard but to appear in the dashboard 
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


## Template tags

**Template tags** are wordpress functions that can be called in themes to to retrieve content from the DB and:

* display some content in a page
* check conditions
* retrieve global info like the site's title or its address

Such as get_header(), the_title(), bloginfo()

### example: bloginfo()

It can fetch data from the DB and display it (use get_bloginfo for internal use) like

* blog name
* the stylesheet directory URL of the active theme
* info from user profile, admin screen and general settings

### help with site content

Tags are used to display bits of data on numerous pages for instance **get_header()**, **get_footer** help integrate in any page the header and footer.  
Ex: index.php

```
<?php get_header() ?>

<!-- content of the page -->

<?php get_footer() ?>

```

## The loop

The Loop is the default mechanism WordPress uses for outputting posts through a theme’s template files. 

```
&lt;?php<br />
get_header();</p>
<p>if ( have_posts() ) :<br />
    while ( have_posts() ) : the_post();<br />
        the_content();<br />
    endwhile;<br />
else :<br />
    _e( 'Sorry, no posts matched your criteria.', 'textdomain' );<br />
endif;</p>
<p>get_sidebar();<br />
get_footer();<br />
?><br />
```

### Template tags that can be used in a Loop

* next_post_link() – a link to the post published chronologically after the current post
* previous_post_link() – a link to the post published chronologically before the current post
* the_category() – the category or categories associated with the post or page being viewed
* the_author() – the author of the post or page
* the_content() – the main content for a post or page
* the_excerpt() – the first 55 words of a post’s main content followed by an ellipsis (…) or read more link that goes to the full post. You may also use the “Excerpt” field of a post to customize the length of a particular excerpt.
* the_ID() – the ID for the post or page
* the_meta() – the custom fields associated with the post or page
* the_shortlink() – a link to the page or post using the url of the site and the ID of the post or page
* the_tags() – the tag or tags associated with the post
* the_title() – the title of the post or page
* the_time() – the time or date for the post or page. This can be customized using standard php date function formatting.

### Example of conditional tags:

* is_home() – Returns true if the current page is the homepage
* is_admin() – Returns true if inside Administration Screen, false otherwise
* is_single() – Returns true if the page is currently displaying a single post
* is_page() – Returns true if the page is currently displaying a single page
* is_page_template() – Can be used to determine if a page is using a specific * template, for example: is_page_template('about-page.php')
* is_category() – Returns true if page or post has the specified category, for * example: is_category('news')
* is_tag() – Returns true if a page or post has the specified tag
* is_author() – Returns true if inside author’s archive page
* is_search() – Returns true if the current page is a search results page
* is_404() – Returns true if the current page does not exist
* has_excerpt() – Returns true if the post or page has an excerpt

### Examples

#### Displaying a blog archive

```
&lt;?php<br />
if ( have_posts() ) :<br />
    while ( have_posts() ) : the_post();<br />
        the_title( '&lt;h2>', '&lt;/h2>' );<br />
        the_post_thumbnail();<br />
        the_excerpt();<br />
    endwhile;<br />
else:<br />
    _e( 'Sorry, no posts matched your criteria.', 'textdomain' );<br />
endif;<br />
?><br />
```

#### Displaying a post in a post page

```
&lt;?php<br />
if ( have_posts() ) :<br />
    while ( have_posts() ) : the_post();<br />
        the_title( '&lt;h1>', '&lt;/h1>' );<br />
        the_content();<br />
        comments_template();<br />
        comment_form();<br />
    endwhile;<br />
else:<br />
    _e( 'Sorry, no pages matched your criteria.', 'textdomain' );<br />
endif;<br />
?><br />
```

## Filters

It is possible to hook filters to functions.  
**apply_filters()** is used to trigger all the function attached to a filter. It called in lots of wp_....php files.

```
<?php apply_filters( 'filter key, ex:the_title', $args<passed to the functions> );

```

### hooking up a filter

This is done in **functions.php** with **add_filter(filter_name, function_name)**

```
<?php 
add_filter('the_title', 'truncate_long_title');

function truncate_long_title($title)
{
    if (strlen($title) > 50) {
        $title = substr($title, 0, 50).'...';
    }
    return $title;
}

```

## Custom templates

It is possible to integrate to a theme custom templates with the function **get_template_part**

```
<?php function get_template_part( $slug, $name = null )
```

**get_template_part** includes the template file **$slug-$name.php or $slug.php**


## Languages

It’s best practice to internationalize your theme so it can be translated into other languages. Default themes include the languages folder, which contains a .pot file for translation and any translated .mo files. While languages is the default name of this folder, you can change the name. If you do so, you must update load_theme_textdomain().