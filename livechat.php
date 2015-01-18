<?php
/**
 * Plugin Name: Live Chat With SocketIo distant server !
 * Plugin URI: http://www.pour-le-web.com/
 * Description: Ce plugin vous permet de communiquer en live
 * Version: 1.0.1
 * Author: joachim
 * Author URI:  http://www.pour-le-web.com
 * License: GPL2 license
 */

/**
 * Example Widget Class
 */
class livechat_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function livechat_widget() {
        parent::WP_Widget(false, $name = 'Example Text Widget');	
    }
 
    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {	
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $message 	= $instance['message'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul>
								<li><?php echo $message; ?></li>
							</ul>
              <?php echo $after_widget; ?>
        <?php
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['message'] = strip_tags($new_instance['message']);
        return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {	
 
        $title 		= esc_attr($instance['title']);
        $message	= esc_attr($instance['message']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('message'); ?>"><?php _e('Simple Message'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>" type="text" value="<?php echo $message; ?>" />
        </p>
        <?php 
    }
 
 
} // end class example_widget
add_action('widgets_init', create_function('', 'return register_widget("livechat_widget");'));

function chatter_shortcode( $atts, $content = null)	{
 
	extract( shortcode_atts( array(
				'serveur' => ''
			), $atts 
		) 
	);
	if($content==null || $content==''){
    $content='
    <div id="messagerie">
    <input id="messinput" type="text" value="votre message ici"/>
    <button id="envoie_mess" type="button">Envoyer</button>
    </div>
    <h4>Messages en direct</h4>
    <div id="retimer"></div>
    <div id="live_messages"></div>';
  }
	// this will display our message before the content of the shortcode
	include_once('functions.php');
	if(is_online($serveur."/socket.io/socket.io.js")){
		include_once('socketmouse.js');
		return 'le chat est opérationnel !<br/>'.$content;
	}else{
		return 'le Serveur est inaccessible pour le moment.';
	}
	
 
}
add_shortcode('livechat', 'chatter_shortcode');
?>
