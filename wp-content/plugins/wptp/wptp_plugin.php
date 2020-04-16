<?php
/*
Plugin Name: wptp title plugin
Plugin URI: http://philippe-plugin.com
Description: Un plugin d'introduction pour le développement sous WordPress
Version: 0.1
Author: Philippe
Author URI: http://votre-site.com
License: GPL2
*/

class WptpPlugin
{
    public function __construct()
    {
        // We declare the plugin to WordPress
        include_once plugin_dir_path( __FILE__ ).'/page_title.php';
        new WptpPageTitle();

        // We declare the widget to WordPress
        include_once plugin_dir_path( __FILE__ ).'/newsletter.php';

        new WptpNewsletter();

        // We install a hook to find out when the plugin is activated
        // It will trigger the "install" static method on the 
        // WptpNewsletter class which will create the table to record
        // the subscriber email
        register_activation_hook(__FILE__, array('WptpNewsletter', 'install'));
        register_deactivation_hook(__FILE__, array('WptpNewsletter', 'nop'));
        register_uninstall_hook(__FILE__, array('WptpNewsletter', 'uninstall'));
    }
}

new WptpPlugin();