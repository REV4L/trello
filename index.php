

<html>
<?php require_once "baza.php"; ?>
<?php require_once "session.php"; ?>

<?php 
// require "log_in_status.php"; 
?>
    <head>
      <link rel="stylesheet" href="style.css">
      <title>Trello</title>
      <script src="jquery-3.7.1.min.js"></script>
      <script src="jquery-ui/jquery-ui.js"></script>
      <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.css"/>
      <!-- <script src="jquery-sortable.js"></script> -->
      <!-- <script src="board.js" defer></script> -->
    </head>

    <body class="content">
        </div>
            <div class="centered-container unselectable" style="width: 50%; height: 60%; margin-top: 10%;">
                <h1 class="huge-title" style="margin-top: 10%;">
                    Welcome!
                </h1>

                <form method="post" action="index.php">
                    <input class="button-default sized-input shadow-default" name="username" type="text" style="font-size: 130%;" placeholder="username" required>
                    <br>
                    <input class="button-default sized-input shadow-default" name="email" type="email" style="font-size: 130%;" placeholder="email" required>
                    <br>
                    <input class="button-default sized-input shadow-default" name="password" type="password" style="font-size: 130%; " placeholder="password" required>
                    <br>
                    <br>

                    <input value="Register" name="sub" class="button-default button-input  sized-input shadow-default" type="submit" style="font-size: 150%; filter:hue-rotate(111deg);">
                    <input value="Log in" name="sub" class="button-default button-input sized-input shadow-default" type="submit" style="font-size: 150%;">
                    <br>
                    <br>
                    <?php
                        if(isset($_SESSION['username'])) {
                            echo '<a href="board.php" class=" " style="font-size: 150%; filter:hue-rotate(0deg); color: lightblue;">';
    
                            echo "Continue as " . $_SESSION['username'];
                            echo "</a>";
                            
                            echo "<br>";

                            echo '<a href="sessionreset.php" class=" " style="font-size: 150%; filter:hue-rotate(0deg); color: lightblue;">';
    
                            echo "Log out";
                            echo "</a>";

                        } else {
                            echo '<a href="home.php" class=" link" style="font-size: 150%; filter:hue-rotate(0deg); color: lightblue;">';
    
                            echo "Continue as a guest";
                            echo "</a>";
                        }
                    ?>
                </form>
            

            <?php                                              
                if(isset($_POST['sub']) && $_POST['sub'] == "Log in" && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {



                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = sha1($_POST['password']);

                    $sqlCheckUserExists = "SELECT COUNT(*) FROM users u
                    WHERE u.username = ? AND u.email = ? AND u.pasw = ?";

                    $stmtCheckUserExists = $link->prepare($sqlCheckUserExists);
                    $stmtCheckUserExists->bind_param("sss", $username, $email, $password);
                    
                                      
                    if ($stmtCheckUserExists->execute()) {
                        $stmtCheckUserExists->bind_result($userCount);
                        $stmtCheckUserExists->fetch();
                        if ($userCount > 0) {
                            // User exists with the provided username and password
                            // echo "Logged in";
                            echo "User found";
                            $_SESSION['username'] = $_POST['username'];
                            $_SESSION['password'] = sha1($_POST['password']);
                            //sleep(1);
                            $stmtCheckUserExists->close();

                            $sqlIsAdmin = "SELECT COUNT(*) FROM users u INNER JOIN user_types ut ON ut.id = u.user_type_id
                            WHERE u.username = ? AND u.email = ? AND u.pasw = ? AND ut.name = 'admin'";

                            $stmtIsAdmin = $link->prepare($sqlIsAdmin);
                            $stmtIsAdmin->bind_param("sss", $username, $email, $password);

                            if ($stmtIsAdmin->execute()) {
                                $stmtIsAdmin->bind_result($adminCount);
                                $stmtIsAdmin->fetch();

                                if($adminCount > 0) {
                                    $_SESSION['isAdmin'] = true;
                                }
                            }

                            header("Location: dashboard.php");
                        } else {
                            // No user exists with the provided username and password
                            // echo "Not logged in";
                            echo '<div style="color: red;"> user not found, check your credentials </div>';
                            echo '<script> $(.centered-container).css("background-color", "red"); </script>';
                            // header('Refresh: 2');
                        }
                    }
                    
                }
                else
                if(isset($_POST['sub']) && $_POST['sub'] == "Register" && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {

                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = sha1($_POST['password']);

                    $sqlCheckUserExists = "SELECT COUNT(*) FROM users u
                    WHERE u.email = ? OR u.username = ?";

                    $stmtCheckUserExists = $link->prepare($sqlCheckUserExists);
                    $stmtCheckUserExists->bind_param("ss", $email, $username);
                    $stmtCheckUserExists->execute();

                    $stmtCheckUserExists->bind_result($userCount);
                    $stmtCheckUserExists->fetch();
                    $stmtCheckUserExists->close();

                    if($userCount > 0) {
                        echo '<div style="color: red;"> user already exists </div>';
                        echo '<script> $(.centered-container).css("background-color", "red"); </script>';
                            // header('Refresh: 2');
                        die();
                    }


                    $sql = "INSERT INTO users(username, email, pasw) VALUES('$username','$email','$password')";

                    $sqlInsertUser = "INSERT INTO users(username, email, pasw) VALUES(?,?,?)";

                    $stmtInsertUser = $link->prepare($sqlInsertUser);
                    $stmtInsertUser->bind_param("sss", $username, $email, $password);
                    // $stmtInsertUser->execute();

                    
                    if($stmtInsertUser->execute()) {
                        $_SESSION['username'] = $username;
                        $_SESSION['password'] = $password;
                    }
                    else {
                        echo '<div style="color: red;"> error registering user </div>';
                        
                        echo '<script> $(.centered-container).css("background-color", "red"); </script>';
                        // header('Refresh: 2');
                    }
                    // $stmtInsertUser->bind_result($userCount);
                    // $stmtInsertUser->fetch();
                    $stmtInsertUser->close();

                }
            ?>
            </div>
        </div>

        
    </body>
</html>


