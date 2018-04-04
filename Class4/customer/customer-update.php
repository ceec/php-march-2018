<?php

function customer_update() {
    global $wpdb;
    $table_name = $wpdb->prefix."customers";
    //selecting the inital data to update
    $id = $_GET['id'];

    //updating data
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
    }
    
    $email = $_POST['email'];
    $message = $_POST['message'];

    //update
    if(isset($_POST['update'])) {
        $wpdb->update(
                $table_name, //table
                array('name'=>$name,'email'=>$email,'message'=>$message), //data
                array('ID'=>$id), //where
                array('%s'), //data format
                array('%s') //where format
        );
    } else if (isset($_POST['delete'])) {
        //delete
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
    } else {
        //select data to display
        $messages = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s",$id));

        //TODO take object out of array

        $messages = $messages[0];
    }




?>
    <div class="wrap">
        <h2>Customers</h2>

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Customer deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=customer_list') ?>">&laquo; Back to customers list</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Customer updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=customer_list') ?>">&laquo; Back to customers list</a>

        <?php } else { ?>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr><th>Name</th><td><input type="text" name="name" value="<?php echo $messages->name; ?>"/></td></tr>
                    <tr><th>Email</th><td><input type="text" name="email" value="<?php echo $messages->email; ?>"/></td></tr>
                    <tr><th>Message</th><td><input type="text" name="message" value="<?php echo $messages->message; ?>"/></td></tr>                    
                </table>
                <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('Are you sure you want to delete this?')">
            </form>
        <?php } ?>

    </div>
<?php
}
