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
        echo "Logged in as: " . $_SESSION['username'] ;

        echo '<a href="sessionreset.php"> Log out </a>';

        if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true)
        echo '<br><a href="admin.php">Admin panel </a>';
    }
    else {
        echo "Logged in as a guest ";

        echo '<a href="index.php"> Log in </a>';
    }


?>