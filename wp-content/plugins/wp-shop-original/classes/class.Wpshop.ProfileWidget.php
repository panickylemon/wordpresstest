<?php 
class Wpshop_ProfileWidget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'wpb_widget', 

// Widget name will appear in UI
__('WPShop profile widget', 'wp-shop'), 

// Widget description
array( 'description' => __( 'This show profile information', 'wp-shop' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
//echo __( 'Hello, World!', 'wp-shop' );
//echo $args['after_widget'];


				if (is_user_logged_in()){
					$user_info = get_userdata(get_current_user_id());
					$current_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					?>
					<p><?php  _e('You authorized as', 'wp-shop'); ?> <?php  echo $user_info->display_name ?>. <a href="<?php  echo wp_logout_url($current_url); ?>" title="Logout"><?php  _e('logout', 'wp-shop'); ?></a></p>
					<p><?php  _e('Your profile data:', 'wp-shop'); ?> <a href="<?php  echo get_edit_user_link(); ?>" target="_blank"><?php  _e('edit', 'wp-shop'); ?></a></p>
					<table class="wpshop_profile_table" cellpadding="0" cellspacing="0" border="0">
						<tr><td><?php  _e('Login:', 'wp-shop'); ?></td><td><?php  echo $user_info->user_login ?></td></tr>
						<tr><td><?php  _e('First Name:', 'wp-shop'); ?></td><td><?php  echo $user_info->first_name ?></td></tr>
						<tr><td><?php  _e('Last Name:', 'wp-shop'); ?></td><td><?php  echo $user_info->last_name ?></td></tr>
						<tr><td><?php  _e('Nick-name:', 'wp-shop'); ?> </td><td><?php  echo $user_info->nickname ?></td></tr>
						<tr><td><?php  _e('E-mail', 'wp-shop'); ?></td><td><?php  echo $user_info->user_email ?></td></tr>
						<tr><td><?php  _e('Site', 'wp-shop'); ?></td><td><?php  echo $user_info->user_url ?></td></tr>
						<tr><td><?php  _e('Phone', 'wp-shop'); ?></td><td><?php  echo $user_info->phone ?></td></tr>
						<tr><td><?php  _e('Address', 'wp-shop'); ?></td><td><?php  echo $user_info->address ?></td></tr>
						<tr><td><?php  _e('Company name', 'wp-shop'); ?></td><td><?php  echo $user_info->company_name ?></td></tr>
						<tr><td><?php  _e('Description', 'wp-shop'); ?></td><td><?php  echo nl2br($user_info->description) ?></td></tr>
					</table>
					<?php 
} else {?>
<?php  _e('Hello', 'wp-shop'); ?>, <a href='/wp-login.php'><?php  _e('Guest', 'wp-shop'); ?></a>


<?php 	

}

}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'wp-shop' );
}
// Widget admin form
?>
<p>
<label for="<?php  echo $this->get_field_id( 'title' ); ?>"><?php  _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php  echo $this->get_field_id( 'title' ); ?>" name="<?php  echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php  echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
}



