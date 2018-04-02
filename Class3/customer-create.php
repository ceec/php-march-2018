<?php

function customer_create() {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		$created_at = date('Y-m-d H:i:s');

		if (isset($_POST['insert'])) {
			global $wpdb;
			$table_name = $wpdb->prefix.'customers';

			$wpdb->insert(
					$table_name, //table
					array('name'=>$name,'email'=>$email,'message'=>$message,'created_at'=>$created_at), //data,
					array('%s','%s') //data format
			);

			$success = 'Customer Added';
		}

	?>
	    <div class="wrap">
	    	<a href="<?php echo admin_url('admin.php?page=customer_list'); ?>">Customer List</a>
	        <h2>Add New Customer</h2>
	        <?php if (isset($success)): ?><div class="updated"><p><?php echo $success; ?></p></div><?php endif; ?>
	        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
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
}