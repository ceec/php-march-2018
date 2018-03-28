<?php

require_once('../dbconnect.php');

if(isset($_POST['delete_customer'])) {
    $delete = "DELETE FROM customers WHERE id='".$_POST['id']."' LIMIT 1";
    //echo $delete;
    $mysqli->query($delete);

    //print_r($_POST);
    header('Location:customer-display.php');
    exit;

}