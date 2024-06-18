<?php
    require_once "baza.php";
    require_once "session.php";

    if(
        isset(
            $_SESSION['username'] 
        )
        &&
        isset(
            $_SESSION['password'] 
        )
    ) 
    {
        $username = $_SESSION['username'];
        $pasw = $_SESSION['password'];

        $sql = "SELECT * FROM users WHERE username='$username' AND pasw='$pasw'";
        $result = mysqli_query($link, $sql);

       

        if ($result) {
            $num=mysqli_num_rows($result);
            if ($num > 0) {
                // User exists with the provided username and password
                // echo "Logged in";
                //echo "User found";
            } else {
                // No user exists with the provided username and password
                // echo "Not logged in";
                //echo "User not found";
                sleep(1);
                header("Location: index.php");
            }
        } else {
            // Query failed
            // echo "Query failed: " . mysqli_error($conn);
            //echo "query failed";
            sleep(1);
            header("Location: index.php");
        }
    } else {
        ////echo "session vars not set";
        sleep(1);
        header("Location: index.php");
    }

    //echo "reqlogin ran";


?>