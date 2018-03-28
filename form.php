<?php
  require_once('../dbconnect.php');

    if(isset($_POST['contact'])) {
        $form_data = $_POST;

        print_r($form_data);

       // echo $form_data['name'];
    
        if ($form_data['name'] == '') {
            $error_message = 'Please Enter a Name';
        }

        if ($form_data['email'] == '') {
            $error_message = 'Please Enter an Email';
        }

        if ($form_data['message'] == '') {
            $error_message = 'Please Enter a Message';
        }       
        
        
        //check if data is already there
        //check email address
        $email_query = "SELECT email FROM customers WHERE email='".$form_data['email']."'";
        $email_check = $mysqli->query($email_query);
        $email_test = $email_check->num_rows;

        if ($email_test == 1) {
            $error_message = 'Duplicate email';
        }


        if (!isset($error_message)) {
            //error message was never set, send the email
            $to = 'cc@battab.com';
            $subject = 'Contact form from Test Site';
            $message = $form_data['message'];
            $headers = array(
                'From' => $form_data['email'],
                'Reply-To' => 'cc@battab.com'
            );
           // mail($to,$subject,$message)


           //insert the data into `names` (`name`,`email`,`message`) VALUES ('Christine','cc@cc.com','sf fdklj klsjdfklsdfj');
           $insert = "INSERT INTO `customers` (`name`,`email`,`message`,`created_at`) VALUES ('".$form_data['name']."','".$form_data['email']."','".$form_data['message']."',now())";

           $mysqli->query($insert);

         

           echo $insert;
           echo '<hr>';
           echo $mysqli->insert_id;

           $select = "SELECT * FROM `customers`";

           $results = $mysqli->query($select);


            while($result = $results->fetch_assoc()) {
                echo $result['name'];
                echo '<hr>';
            }


           
           

           


?>

            <h1>Your messasge has been sent!</h1>
<?php

            exit();
        }

    }





?>


<h2>Contact Form test</h2>
<form method="POST" action="form.php">

    Name: <input type="text" name="name" value="<?php if(isset($form_data['name'])) { echo $form_data['name']; } ?>"><br>
    Email: <input type="text" name="email" value="<?php if(isset($form_data['email'])) { echo $form_data['email']; } ?>"><br>
    Message: <input type="text" name="message" value="<?php if(isset($form_data['message'])) { echo $form_data['message']; } ?>"><br>
    <input type="submit" name="contact" value="Submit!">

</form>

<?php

    if(isset($error_message)) {
        echo $error_message;
    }

?>