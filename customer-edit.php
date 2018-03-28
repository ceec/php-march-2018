<?php

require_once('../dbconnect.php');


// echo '<pre>';
// print_r($_GET);
// echo '</pre>';




if(isset($_POST['update_customer'])) {

    $update = "UPDATE customers SET `name`='".$_POST['name']."',`email`='".$_POST['email']."',`message`='".$_POST['message']."' WHERE id='".$_POST['id']."'";
    //echo $update;
    $update_customer = $mysqli->query($update);

    header('Location:customer-display.php');
    exit;
}


$customer_id  = $_GET['customer'];

$select = "SELECT * FROM customers WHERE id='".$customer_id."'";
$result = $mysqli->query($select);
$customer = $result->fetch_assoc();


?>
<form method="POST" action="customer-edit.php?customer=<?php echo $customer_id; ?>">

Name: <input type="text" name="name" value="<?php if(isset($customer['name'])) { echo $customer['name']; } ?>"><br>
Email: <input type="text" name="email" value="<?php if(isset($customer['email'])) { echo $customer['email']; } ?>"><br>
Message: <input type="text" name="message" value="<?php if(isset($customer['message'])) { echo $customer['message']; } ?>"><br>
<input type="hidden" name="id" value="<?php if(isset($customer['id'])) { echo $customer['id']; } ?>">
<input type="submit" name="update_customer" value="Edit">

</form>