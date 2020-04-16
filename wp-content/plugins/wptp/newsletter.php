<?php
include_once plugin_dir_path( __FILE__ ).'/newsletterwidget.php';

class WptpNewsletter
{
    public function __construct()
    {
        // We add an action so the Widget is registered at init time
        add_action('widgets_init', function(){register_widget('WptpNewsletterWidget');});
    }

    public static function install()
    {
        global $wpdb;  // is a WordPress global variable to enable DB access
    
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wptp_newsletter_email (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) NOT NULL);");
    }

    public static function nop () {

    }

    public static function uninstall()
    {
        global $wpdb;

        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wptp_newsletter_email;");
    }
}