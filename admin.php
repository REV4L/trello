<html>
    <head>
      <link rel="stylesheet" href="style.css">
      <title>Trello</title>
      <script src="jquery-3.7.1.min.js"></script>
      <script src="jquery-ui/jquery-ui.js"></script>
      <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.css"/>
      <!-- <script src="jquery-sortable.js"></script> -->
      <script src="jquery.ui.touch-punch.min.js"></script>
      <script type="module" src="admin.js" defer></script>
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

        if(!isset($_SESSION['isAdmin'])) {
            header("Location: index.php");
        }
        else if($_SESSION['isAdmin']!=true){
            header("Location: index.php");
        }

        ?>
        </div>

        <div class="content" style="padding-top: 12vh;">
        
            <div class='duplicate-this' style="display: none; background-color:rgba(0,0,0,0.4)">
                <div class="data">

                </div>

                <input value="delete" name="sub" class="del button-default button-input  sized-input shadow-default" type="submit" style="font-size: 150%; filter:hue-rotate(90deg) saturate(1.5); margin: 2%;" id="btn-delete-task">
            </div>

        </div>
            
    </body>
</html>


