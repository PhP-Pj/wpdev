# Developing the site

## Setting up a front page (not the default one with all the posts from the blog)

See [Custom front page](https://developer.wordpress.org/themes/functionality/custom-front-page-templates/)  

Adding a front-page.php in the theme will make the site display this page when getting to the site's root independently from what is specified in the Admin menu:  
Settings > Reading > FrontPage  

If in Settings > Reading > FrontPage we specify static and then select a page.  
This selected page will be dsiplayed through index.php, the context being "front-page" the Loop in index.php will find only one post i.e. the page we designed as a front page.  

Each page has a slug (see in Dashdoard > Pages > quick edit for the page), if we create a page with this slug (page_slugname.php), this page_slugname.php page will be displayed when accessing the site. In this conext **the_post();** and
**the_content();** will display the content of the page we created in the dashboard.  

By using the "index.php" option we no loger need to specify the header, footer, widgets, nav bar ...  

## Setting up a Blog page

See [a separate custom blobg page](https://www.dreamhost.com/wordpress/guide-to-wp-posts-page/)  

