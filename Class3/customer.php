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

define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'customer-list.php');
require_once(ROOTDIR.'customer-create.php');
require_once(ROOTDIR.'customer-update.php');
?>