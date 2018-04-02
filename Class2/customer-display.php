<?php

require_once('../dbconnect.php');

?>
    <h1>Customers</h1>
<?php

$select = "SELECT * FROM `customers`";

$results = $mysqli->query($select);


 while($customer = $results->fetch_assoc()) {
    echo $customer['id'].'<br>';
     echo $customer['name'];
 ?>
    <a href="customer-edit.php?customer=<?php echo $customer['id']; ?>"><button>Edit</button></a>
    <form method="POST" action="customer-delete.php">
    <input type="submit" name="delete_customer" value="Delete">
    <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
    </form>
 <?php    
     echo '<hr>';
 }