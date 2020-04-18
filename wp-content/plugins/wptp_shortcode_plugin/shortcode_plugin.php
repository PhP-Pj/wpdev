<?php
/*
Plugin Name: Last Post Plugin
Plugin URI: http://philippe-plugin.com
Description: This plugin shoe the last posts on a static page
Version: 0.1
Author: Philippe
Author URI: http://votre-site.com
License: GPL2
*/

class ShortcodePlugin
{
    public function __construct()
    {
        // We declare the plugin to WordPress
        include_once plugin_dir_path( __FILE__ ).'/recent.php';
        new RecentPost();
    }
}

new ShortcodePlugin();