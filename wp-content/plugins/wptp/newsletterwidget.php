<?php
/*
  A widget must inherit from WP_Widget and
  - override the constructor
  - call in the constructor the base constructor
  - override the method widget
    In the widget method we can display a title (the one showing in 
    the admin screen by just echoing it
    or because we know wordpress has a "widget_title" filter we can 
    apply the filter to the title in case a user defines function filter
  The widget can receive parameters in this case we can create a dialog
  overriding the method form() where the parameter will be the name the
  user will want to display for the widget in the widget zone.
*/
class WptpNewsletterWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('wptp_newsletter', 'Newsletter', array('description' => 'Un formulaire d\'inscription à la newsletter.'));
    }
    
    public function widget($args, $instance)
    {
        // echo 'widget newsletter';
        echo $args['before_widget'];
        echo $args['before_title'];
        echo apply_filters('widget_title', $instance['title']);
        echo $args['after_title'];
        ?>
        <!-- action is "" to stay on the same page -->
        <form action="" method="post">
            <p>
                <label for="wptp_newsletter_email">Your email address:</label>
                <input id="wptp_newsletter_email" name="wptp_newsletter_email" type="email"/>
            </p>
            <input type="submit" value="Enter"/>
        </form>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>">
                <?php _e( 'Title:' ); ?>
            </label>
            <input class="widefat" 
                id="<?php echo $this->get_field_id( 'title' ); ?>" 
                name="<?php echo $this->get_field_name( 'title' ); ?>" 
                type="text" value="<?php echo  $title; ?>" />
        </p>
        <?php
    }
}