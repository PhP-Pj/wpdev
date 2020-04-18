<!doctype html>
<html>

<head>
  <title><?php echo wp_title() ?></title>
  <link rel="stylesheet" href="wp-content/themes/wptp/style.css" type="text/css" />
</head>

<body>
  <header class="header">
    <div class="container">
      <div>Header</div>
      <div>Site info <?php bloginfo() ?></div>
      <div>Site description <?php bloginfo('description'); ?></div>
      <?php wp_nav_menu(array('theme_location' => 'WpTP Main Menu ')); ?>
      <div>End of Header</div>
    </div>
  </header>