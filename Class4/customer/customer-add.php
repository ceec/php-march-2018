<?php
    include_once('../../../wp-load.php' );

    global $wpdb;
    $table_name = $wpdb->prefix.'customers';

        var_dump($_POST);

		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		$created_at = date('Y-m-d H:i:s');

    
    $wpdb->insert(
            $table_name, //table
            array('name'=>$name,'email'=>$email,'message'=>$message,'created_at'=>$created_at), //data,
            array('%s','%s') //data format
    );

    echo 'Customer Added';