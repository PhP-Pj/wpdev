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

        // Adding a menu item on WordPress Admin page to configure the plugin
        add_action('admin_menu', array($this, 'add_admin_menu'));

        // We are register the goup for our admin menu options
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_admin_menu()
    {
        add_menu_page('The WPTP plugin', 'The WPTP plugin', 'manage_options', 'top_menu_WPTP_slug', array($this, 'menu_html'));
        // this sub menu is actually the top menu renamed so WP behaviour of adding the main
        // menu as a sub menu doen't look odd
        add_submenu_page('top_menu_WPTP_slug', 'Overview', 'Overview', 'manage_options', 'top_menu_WPTP_slug', array($this, 'menu_html'));
        $page_hook = add_submenu_page('top_menu_WPTP_slug', 'Newsletter', 'Newsletter', 'manage_options', 'sub_menu_wptp_newsletter_slug', array($this, 'menu_html'));
        // We decided to store the page hook so we can trigger an action when the page is loaded.
        // the event triggered by WP is load-"page hook"
        // This action will allow us to send the newsletter to all the subscribers
        // The end goal is to get the POST when "send_newsletter" submit button is clicked
        // and proceed to the send and therefore the refresh of the form since there is 
        // no form action hooked in.
        add_action('load-'.$page_hook, array($this, 'process_action'));
    }

    public function process_action()
    {
        $post = $_POST;
        if (isset($_POST['send_newsletter'])) {
            $this->send_newsletter();
        }
    }

    public function send_newsletter()
    {
        global $wpdb;
        $recipients = $wpdb->get_results("SELECT email FROM {$wpdb->prefix}wptp_newsletter_email");
        $object = get_option('wptp_newsletter_object', 'Newsletter');
        $content = get_option('wptp_newsletter_body', 'body');
        $sender = get_option('wptp_newsletter_sender', 'no-reply@example.com');
        $header = array('From: '.$sender);

        foreach ($recipients as $_recipient) {
            $result = wp_mail($_recipient->email, $object, $content, $header);
            write_log(("Shipping newsletter: ".$result));
        }
    }

    public function menu_html()
    {
        echo '<h1>'.get_admin_page_title().'</h1>';
        echo '<p>Welcome to WPTP plugin Admin Section</p>';
        ?>
        <!--
            We are adding a form to enter the admin options.
            WP makes it easy to deal with options with the wp_options table.
            When deailing with option a submission for has to call options.php
            in the action.
        -->
        <form method="post" action="options.php">
            <!--
                We need to tell WP what group our option belongs to
                so when updating the option WP can check if it's for the 
                correct group. We register the group and options at init time.
            -->
            <?php settings_fields('wptp_newsletter_settings') ?>
            <!--
                Instead of adding one by one the fields we want the admin to update 
                (Sender address, Object, email body), we add a section where we
                will only needs to define the options and WP will take care of
                displaying them with function add_settings_field().
            <label>Expéditeur de la newsletter</label>
            <input type="text" name="wptp_newsletter_sender" 
                value="<?php echo get_option('wptp_newsletter_sender')?>"/>
            -->
            <?php 
            // add_settings_field(
            //     'wptp_newsletter_sender', 
            //     'Sender', array($this, 'sender_html'), 
            //     'wptp_newsletter_settings', 
            //     'wptp_newsletter_section'
            // );
            do_settings_sections('wptp_newsletter_settings');
            submit_button(); 
            ?>
        </form>
        <form method="post" action="">
            <input type="hidden" name="send_newsletter" value="1"/>
            <?php submit_button('Send the newsletter') ?>
        </form>
        <?php
    }

    public function register_settings()
    {
        register_setting('wptp_newsletter_settings', 'wptp_newsletter_sender');
        register_setting('wptp_newsletter_settings', 'wptp_newsletter_object');
        register_setting('wptp_newsletter_settings', 'wptp_newsletter_body');

        // We need to add fields for the subject and the boy of the email
        // we can use a WP setting section to do that
        add_settings_section(
            'wptp_newsletter_section', 
            'Letter details', 
            array($this, 'section_html'), 
            'wptp_newsletter_settings'
        );
        add_settings_field(
            'wptp_newsletter_sender', 
            'Sender', array($this, 'sender_html'), 
            'wptp_newsletter_settings', 
            'wptp_newsletter_section'
        );
        add_settings_field(
            'wptp_newsletter_obect', 
            'Object', array($this, 'object_html'), 
            'wptp_newsletter_settings', 
            'wptp_newsletter_section'
        );
        add_settings_field(
            'wptp_newsletter_body', 
            'Body', array($this, 'body_html'), 
            'wptp_newsletter_settings', 
            'wptp_newsletter_section'
        );
    }

    public function section_html()
    {
        echo 'Type in the newsletter.';
    }

    public function sender_html()
    { 
        ?>
        <input type="text" name="wptp_newsletter_sender" 
        value="<?php echo get_option('wptp_newsletter_sender')?>"/>
        <?php
    }

    public function object_html()
    { 
        ?>
        <input type="text" name="wptp_newsletter_object" 
        value="<?php echo get_option('wptp_newsletter_object')?>"/>
        <?php
    }

    public function body_html()
    { 
        ?>
        <textarea name="wptp_newsletter_body" 
        value="<?php echo get_option('wptp_newsletter_body')?>"></textarea>
        <?php
    }
}

new WptpPlugin();