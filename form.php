<?php


    if(isset($_POST['contact'])) {
        $form_data = $_POST;

        print_r($form_data);

        echo $form_data['name'];
    
        if ($form_data['name'] == '') {
            $error_message = 'Please Enter a Name';
        }

        if ($form_data['email'] == '') {
            $error_message = 'Please Enter an Email';
        }

        if ($form_data['message'] == '') {
            $error_message = 'Please Enter a Message';
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
            mail($to,$subject,$message);
?>

            <h1>Your messasge has been sent!</h1>
<?php

            exit();
        }

    }





?>


<h2>Contact Form</h2>
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
