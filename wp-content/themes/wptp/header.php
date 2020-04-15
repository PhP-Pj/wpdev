<!doctype html>
<html>
  <head>
    <title><?php echo wp_title() ?></title>
    <link rel="stylesheet" href="wp-content/themes/wptp/style.css" type="text/css"/>
  </head>
<body>
<header class="header">
  <div class="container">
  <h1>This is our header</h1>
    <h1><?php bloginfo() ?></h1>
    <h2><?php bloginfo( 'description' ); ?></h2>
    <?php wp_nav_menu(array('theme_location' => 'WpTP Main Menu ')); ?>
  </div>
  </header>