<html>
    <head>
      <link rel="stylesheet" href="style.css">
      <title>Trello</title>
      <script src="jquery-3.7.1.min.js"></script>
      <script src="jquery-ui/jquery-ui.js"></script>
      <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.css"/>
      <!-- <script src="jquery-sortable.js"></script> -->
      <script src="jquery.ui.touch-punch.min.js"></script>
      <script type="module" src="board.js" defer></script>
    </head>

    <div class="navbar">
        <div class="navitem" style="flex: 2"><?php require "log_in_status.php"; ?></div>
        <a href="home.php" class="navitem">Home</a>
        <a href="dashboard.php" class="navitem">Dashboard</a>
    </div>

    <body>
        
        <div id="boardId" style="display: none;">
        <?php 
        require "req_log_in.php";

        if(isset($_SESSION['selectedBoardId'])) {
            echo "boardId: " . $_SESSION['selectedBoardId'];
        }
        else {
            echo '-1';
            header("Location: dashboard.php");
        }
        ?>
        </div>

        <div class="overlay" id="o-inspect-task">
            <!-- <div class="normal-tilt"> -->
            <div class="centered-container3" style="">
                <div class="huge-title" style="font-size: 16px; font-size: calc((4vh + 4vw)/2); font-size: min(2vh, 2vw); margin-bottom: 3%; margin-top: 5%;" id="title">
                    Task name
                </div>

                    <textarea class="button-default sized-input-L shadow-default" name="boardname"  style="font-size: 150%; margin: 2%; height: 50%; width: 80%; transform: scale(1); outline: none !important; border:1px solid transparent;" placeholder="description" id="i-task-description" name="task-description" rows="4" cols="50" required></textarea>
                    <!-- <br> -->

                    <!-- <br> -->
                    <!-- <input class="button-default sized-input-L shadow-default" name="password" type="password" style="font-size: 130%; " placeholder="password" required> -->
                    <!-- <br> -->

                    <input value="Delete" name="sub" class="button-default button-input  sized-input shadow-default" type="submit" style="font-size: 150%; filter:hue-rotate(90deg) saturate(1.5); margin: 2%;" id="btn-delete-task">
                    <input value="Close" name="sub" class="button-default button-input  sized-input shadow-default" type="submit" style="font-size: 150%; filter:hue-rotate(111deg); margin: 2%;" id="btn-close-inspect-task">


            <!-- </div> -->
            </div>
        </div>

        <div class="content">


            <?php 
            //    $token = 'dett';
            //    $email = 'valozimic@gmail.com';
            //    $subject = "Email Verification";
            //    $message = "Please click the link below to verify your email:\n\n";
            //    $message .= "http://your-site.com/verify.php?token=$token\n\n";
            //    $message .= "If you did not register for an account, please ignore this email.";
            //    $headers = "From: no-reply@trello.ozimic.si";
            //
            //    // Send the email
            //    if (mail($email, $subject, $message, $headers)) {echo 'mailed';}
            ?>
            <!-- <div class="side-bar shadow-large">
                
                <div class="side-bar-title unselectable">
                    Sidebar
                </div>
                
                <a href="index.php">
                    <div class="side-bar-item unselectable" id="btn-home">
                        Log in
                    </div>
                </a>
                <a href="dashboard.php">
                    <div class="side-bar-item unselectable" id="btn-home">
                        Dashboard
                    </div>
                </a>
                <a href="board.php">
                    <div class="side-bar-item unselectable" id="btn-home">
                        Test Board
                    </div>
                </a>
                <div class="side-bar-item unselectable" id="btn-blur">
                    Eye burn
                </div>
            </div>  -->

            <ul class="board flex" id="board">
                <!-- LIST TEMPLATE /////////////////////////////////-->
                <li class="board-list-area unselectable list" style="display: none;">
                    <div class="board-list-title">
                        <input class="board-list-input title" type="textarea" value="Item 1" spellcheck="false" style="color: white; font-size:large">

                        <a class="del button-void square shadow-default" style="float:right; font-size:10px;"> 
                            <div style="width: 10px; height: 10px; margin: 5 0 0 5;">del</div> 
                        </a>
                        <a class="addTask button-void square shadow-default large-text" style="float:right;"> 
                            +
                        </a>
                    </div>
                    <!-- TASKS LIST -->
                    <ul class="board-list" style="min-height: 80px; border-bottom: rgba(255, 255, 255, 0.1) solid 3px;">
                        <li class="board-list-item" style="display: none;">
                            <input class="board-list-input" type="textarea" value="Item 1" spellcheck="false">

                            <div class="task-inspect button-void square shadow-default large-text item-button" style=""> 
                                <div style="transform: scale(-1.3) rotate(45deg) translateY(-7px);">...</div>
                            </div>
                            <div class="complete button-void large-text item-button" style=""> 
                                ✔
                            </div>
                        </li>
                    </ul>
                    <!-- end tasks list -->
                </li>
                <li>
                    <a id="btn-create-list"    class="board-select-area-void unselectable"    style="float: left; text-align: center; width: 100px; height: 100px;">
                            <div style="font-size: 700%;   transform:translateY(-40px); margin-left: auto;margin-right: auto;">
                                +
                            </div>
                    </a>
                </li>
                <!-- end LIST TEMPLATE /////////////////////////////-->
            </ul>
            
        </div>
    </body>
</html>


