<?php          
          
           //connect to the database
           define('DB_NAME', 'wednesday');

           /** MySQL database username */
           define('DB_USER', 'root');
           
           /** MySQL database password */
           define('DB_PASSWORD', '');
           
           /** MySQL hostname */
           define('DB_HOST', 'localhost');
           

        //object orientated
           $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

           /* return name of current default database */
            // if ($result = $mysqli->query("SELECT * FROM `names`")) {
            //     $row = $result->fetch_assoc();
            //     print '<pre>';
            //     print_r($row);
            //     echo '</pre>';
            //     $result->close();
            // }

            // echo '<hr>';

            // //procedural
            // $link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
            // /* return name of current default database */
            // if ($result = mysqli_query($link, "SELECT * FROM `names`")) {
            //     $row = mysqli_fetch_assoc($result);
            //     print '<pre>';
            //     print_r($row);
            //     echo '</pre>';
            //     mysqli_free_result($result);
            // }            