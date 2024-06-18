<?php

    session_destroy();

    session_start();

    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['selectedBoardId']);
    unset($_SESSION['isAdmin']);
    
    header('Location: index.php');

?>