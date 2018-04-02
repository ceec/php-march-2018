<?php

function customer_list() {
?>
    <div class="wrap">
        <h2>Customers</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=customer_create'); ?>">Add New</a>
            </div>
            <br class="clear">
        </div>
<?php
		global $wpdb;
		$table_name = $wpdb->prefix.'customers';
		$rows = $wpdb->get_results("SELECT * FROM ".$table_name);
?>        
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">ID</th>
                <th class="manage-column ss-list-width">Name</th>
                <th class="manage-column ss-list-width">Email</th>
                <th class="manage-column ss-list-width">Message</th>
                <th class="manage-column ss-list-width">Created At</th>                
                <th>&nbsp;</th>
            </tr>
<?php 		
			foreach ($rows as $row) { 
?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->id; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->name; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->email; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->message; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->created_at; ?></td>                
                    <td><a href="<?php echo admin_url('admin.php?page=customer_update&id=' . $row->id); ?>">Update</a></td>
                </tr>
<?php 
				} 

?>
        </table>		



<?php
}