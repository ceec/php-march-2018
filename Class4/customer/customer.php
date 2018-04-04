<?php
/**
 * @package Customer
 * @version 1.6
 */
/*
Plugin Name: Customer
Plugin URI: 
Description: 
Author: Christine
Version: 1
Author URI: 
*/

//setup
if (!defined('MYPLUGIN_THEME_DIR'))
    define('MYPLUGIN_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

if (!defined('MYPLUGIN_PLUGIN_NAME'))
    define('MYPLUGIN_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('MYPLUGIN_PLUGIN_DIR'))
    define('MYPLUGIN_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . MYPLUGIN_PLUGIN_NAME);

if (!defined('MYPLUGIN_PLUGIN_URL'))
    define('MYPLUGIN_PLUGIN_URL', WP_PLUGIN_URL . '/' . MYPLUGIN_PLUGIN_NAME);



define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'customer-list.php');
require_once(ROOTDIR.'customer-create.php');
require_once(ROOTDIR.'customer-update.php');



//when you install the plugin, create a customer db table



//when the plugin is installed it makes this db table
register_activation_hook( __FILE__, 'create_customer_table' );

function create_customer_table() {
	global $wpdb;

	//get the database prefix
	$table_name =  $wpdb->prefix.'customers';

	//get the charset
	$charset_collate = $wpdb->get_charset_collate();

	//create the table
	$sql = "CREATE TABLE $table_name (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		name tinytext NOT NULL,
		email varchar(255),
		message TEXT NOT NULL,
		created_at datetime NOT NULL,
		PRIMARY KEY (id)
		) $charset_collate";


	//requrie file to get access to dbDelta
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	//run the sql
	dbDelta( $sql );

}


//create the menu
add_action('admin_menu','create_customer_menu');


function create_customer_menu() {
	//create the main customer menu item
	add_menu_page('Customers', //page title
		'Customers', //menu title
		'manage_options', //capabilites
		'customer_list', //menu slug
		'customer_list', //function ,
		'dashicons-groups',
		90
	);

	//add new customer
	add_submenu_page('customer_list', //parent slug
		'Add New Customer', //page title
		'Add New', //menu title
		'manage_options', //capability
		'customer_create', //menu slug
		'customer_create', //function
		'dashicons-plus'
	);

	//this submenu is HIDDEN but we need to add it anyway
	add_submenu_page(null, //parent slug
		'Update Customer', //page title
		'Update', //menu title
		'manage_options', //capability
		'customer_update', //menu slug
		'customer_update' //function
	);	

}


//shortcode to display the form
add_shortcode('customerform','display_customer_form');

function display_customer_form() {
?>
	    <div class="wrap">
 	        <h2>Add New Customer</h2>
	        <?php if (isset($success)): ?><div class="updated"><p><?php echo $success; ?></p></div><?php endif; ?>
	        <form method="post" action="<?php echo MYPLUGIN_PLUGIN_URL; ?>/customer-add.php">
	            <table class='wp-list-table widefat fixed'>
	                <tr>
	                    <th class="ss-th-width">Name</th>
	                    <td><input type="text" name="name" value="<?php echo $name; ?>" class="ss-field-width" /></td>
	                </tr>
	                <tr>
	                    <th class="ss-th-width">Email</th>
	                    <td><input type="text" name="email" value="<?php echo $email; ?>" class="ss-field-width" /></td>
	                </tr>
	                <tr>
	                    <th class="ss-th-width">Message</th>
	                    <td><input type="text" name="message" value="<?php echo $message; ?>" class="ss-field-width" /></td>
	                </tr>                
	            </table>
	            <input type='submit' name="insert" value='Save' class='button'>
	        </form>
	    </div>

<?php
	//return $content;
}

//widget
//http://www.wpexplorer.com/create-widget-plugin-wordpress/
//https://github.com/wpexplorer/my-widget-plugin

class My_Custom_Widget extends WP_Widget {
	// Main constructor
	public function __construct() {
		parent::__construct(
			'my_custom_widget',
			__( 'My Custom Widget', 'text_domain' ),
			array(
				'customize_selective_refresh' => true,
			)
		);
	}
	// The widget form (for the backend )
	public function form( $instance ) {
		// Set widget defaults
		$defaults = array(
			'title'    => '',
			'text'     => '',
			'textarea' => '',
			'checkbox' => '',
			'select'   => '',
		);
		
		// Parse current settings with defaults
		extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

		<?php // Widget Title ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php // Text Field ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
		</p>

		<?php // Textarea Field ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'textarea' ) ); ?>"><?php _e( 'Textarea:', 'text_domain' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'textarea' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'textarea' ) ); ?>"><?php echo wp_kses_post( $textarea ); ?></textarea>
		</p>

		<?php // Checkbox ?>
		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'checkbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'checkbox' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'checkbox' ) ); ?>"><?php _e( 'Checkbox', 'text_domain' ); ?></label>
		</p>

		<?php // Dropdown ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'select' ); ?>"><?php _e( 'Select', 'text_domain' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'select' ); ?>" id="<?php echo $this->get_field_id( 'select' ); ?>" class="widefat">
			<?php
			// Your options array
			$options = array(
				''        => __( 'Select', 'text_domain' ),
				'option_1' => __( 'Option 1', 'text_domain' ),
				'option_2' => __( 'Option 2', 'text_domain' ),
				'option_3' => __( 'Option 3', 'text_domain' ),
			);
			// Loop through options and add each one to the select dropdown
			foreach ( $options as $key => $name ) {
				echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $select, $key, false ) . '>'. $name . '</option>';
			} ?>
			</select>
		</p>

	<?php }
	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['text']     = isset( $new_instance['text'] ) ? wp_strip_all_tags( $new_instance['text'] ) : '';
		$instance['textarea'] = isset( $new_instance['textarea'] ) ? wp_kses_post( $new_instance['textarea'] ) : '';
		$instance['checkbox'] = isset( $new_instance['checkbox'] ) ? 1 : false;
		$instance['select']   = isset( $new_instance['select'] ) ? wp_strip_all_tags( $new_instance['select'] ) : '';
		return $instance;
	}
	// Display the widget
	public function widget( $args, $instance ) {
		extract( $args );
		// Check the widget options
		$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$text     = isset( $instance['text'] ) ? $instance['text'] : '';
		$textarea = isset( $instance['textarea'] ) ?$instance['textarea'] : '';
		$select   = isset( $instance['select'] ) ? $instance['select'] : '';
		$checkbox = ! empty( $instance['checkbox'] ) ? $instance['checkbox'] : false;
		// WordPress core before_widget hook (always include )
		echo $before_widget;
		// Display the widget

		display_customer_form();
		echo '<div class="widget-text wp_widget_plugin_box">';
			// Display widget title if defined
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			// Display text field
			if ( $text ) {
				echo '<p>' . $text . '</p>';
			}
			// Display textarea field
			if ( $textarea ) {
				echo '<p>' . $textarea . '</p>';
			}
			// Display select field
			if ( $select ) {
				echo '<p>' . $select . '</p>';
			}
			// Display something if checkbox is true
			if ( $checkbox ) {
				echo '<p>Something awesome</p>';
			}
		echo '</div>';
		// WordPress core after_widget hook (always include )
		echo $after_widget;
	}
}
// Register the widget
function my_register_custom_widget() {
	register_widget( 'My_Custom_Widget' );
}
add_action( 'widgets_init', 'my_register_custom_widget' );




?>