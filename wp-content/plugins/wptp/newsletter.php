<?php
include_once plugin_dir_path( __FILE__ ).'/newsletterwidget.php';

class WptpNewsletter
{
    public function __construct()
    {
        // We add an action so the Widget is registered at init time
        add_action('widgets_init', function(){register_widget('WptpNewsletterWidget');});
        // wp_loaded This hook is fired once WP, all plugins, 
        // and the theme are fully loaded and instantiated, which should happen when
        // saving the email address even though we are staying on the same page
        add_action('wp_loaded', array($this, 'save_email'));
    }

    public static function install()
    {
        global $wpdb;  // is a WordPress global variable to enable DB access
    
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wptp_newsletter_email (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) NOT NULL);");
    }

    public static function nop () {
        write_log('Deactivatin WptpNewsletterWidget');
    }

    public static function uninstall()
    {
        global $wpdb;

        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wptp_newsletter_email;");
    }

    public function save_email()
    {
        if (isset($_POST['wptp_newsletter_email']) && !empty($_POST['wptp_newsletter_email'])) {
            global $wpdb;
            $email = $_POST['wptp_newsletter_email'];
    
            $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}wptp_newsletter_email WHERE email = '$email'");
            if (is_null($row)) {
                $wpdb->insert("{$wpdb->prefix}wptp_newsletter_email", array('email' => $email));
            }
        }
    }
}