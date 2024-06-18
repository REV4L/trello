<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>Trello</title>
        <script src="jquery-3.7.1.min.js"></script>
        <script src="jquery-ui/jquery-ui.js"></script>
        <!-- <script src="node_modules/wowjs/dist/wow.min.js"></script> -->
        <!-- <script src="anime.min.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.2.1/tilt.jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.css"/>
        <!-- <link rel="stylesheet" type="text/css" href="node_modules/animate.css/animate.css"> -->
        <!-- <script src="jquery-sortable.js"></script> -->
        <script type="module" src="dashboard.js" defer></script>

        <!-- <script>
            new WOW().init();
        </script> -->
      
    </head>

    <div class="navbar">
        <div class="navitem" style="flex: 2"><?php require "log_in_status.php"; ?></div>
        <a href="home.php" class="navitem">Home</a>
        <a href="dashboard.php" class="navitem">Dashboard</a>
    </div>
    <body>
        
        <!-- <div class="top-bar">
        <?php require "req_log_in.php"; ?>
            <?php 
            // require "log_in_status.php"; 
            ?>
        </div> -->


        <div class="overlay" id="o-insert-board">
            <!-- <div class="normal-tilt"> -->
            <div class="centered-container2" style="">
                <div class="huge-title" style="font-size: 16px; font-size: calc((4vh + 4vw)/2); font-size: min(4vh, 4vw); margin-bottom: 3%;" id="title">
                    New Board
                </div>

                <form method="post" action="#" id="f-create-board">
                    <input class="button-default sized-input-L shadow-default" name="boardname" type="text" style="font-size: 130%; margin: 2%;" placeholder="board name" id="i-boardname" required>
                    <!-- <br> -->
                    <input class="button-default sized-input-L shadow-default" name="description" type="text" style="font-size: 130%; margin: 2%;" placeholder="description (optional)" id="i-description">
                    <!-- <br> -->
                    <!-- <input class="button-default sized-input-L shadow-default" name="password" type="password" style="font-size: 130%; " placeholder="password" required> -->
                    <!-- <br> -->

                    <input value="Create" name="sub" class="button-default button-input  sized-input-L shadow-default" type="submit" style="font-size: 150%; filter:hue-rotate(111deg); margin: 2%;" id="btn-create-board">

                    <div class="button-default button-input  sized-input-L shadow-default unselectable" style="font-size: 150%; filter:hue-rotate(90deg) saturate(1.5); margin: 2% auto; width: 30%; height: 10%" id="btn-cancel-create-board">
                        Cancel
                    </div>

            <!-- </div> -->
            </div>
        </div>

        <div class="content">
            <?php require "req_log_in.php"; ?>
            
            <!-- <div class="side-bar shadow-large">
                
                <div class="side-bar-title unselectable">
                    Sidebar
                </div>
                
                <a href="index.php" class="a-reset">
                    <div class="side-bar-item unselectable" id="btn-home">
                        Log in
                    </div>
                </a>
                <a href="dashboard.php" class="a-reset">
                    <div class="side-bar-item unselectable" id="btn-home">
                        Dashboard
                    </div>
                </a>
                <a href="board.php" class="a-reset">
                    <div class="side-bar-item unselectable" id="btn-home">
                        Test Board
                    </div>
                </a>
                <div class="side-bar-item unselectable" id="btn-blur">
                    Eye burn
                </div>
            </div> -->

            <div class="board">
                <div class="frame unselectable" style="padding: 2px; font-size: 120%; font-weight: bolder;">
                    <a id="btn-search" class="button-default shadow-default square" style="padding: 4px 10px; margin: 0px; background-color:mediumslateblue; color:black; border-radius: 1000px">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </a>
                    <!-- Search:  -->
                    <input id="search" type="text" class=" shadow-default" style="height:50px; width:20%; font-size: 120%;">
                </div>
                
                <div class="frame" style="padding: auto" id="dashboard">

                <a id="btn-create-board-overlay"    class="board-select-area-void unselectable"    style="float: left; text-align: center; ">
                            <div style="font-size: 700%;   transform:translateY(-20px); margin-left: auto;margin-right: auto;">
                                +
                            </div>
                    </a>
                <!-- ///////template/////// -->
                    <a class="duplicate-this" href="board.php" style="display: none;">
                        <div class="board-select-area unselectable" style="text-align: center;">
                            <div style="float: right; width:200%; height: 20%; transform: rotate(-30deg) translate(0,-00%); background-color:rgba(0,0,0,0.2);">
                            </div>
                            <div class="title" style="margin: mim(20%, 70px) auto; font-size: 150%; font-weight: bold;">If you see this something is wrong (board template)</div>
                            <div style="display: flex;">
                                <div class="delete button-transparent large-text" style=""> 
                                    <div style="transform: scale(1) translateY(10px)">Delete</div>
                                </div>
                                <div class="open button-transparent large-text" style=""> 
                                    <div style="transform: scale(1) translateY(10px)" >Open</div>
                                </div>
                                <!-- <div class="button-transparent large-text" style=""> 
                                    <div style="transform: scale(1) rotate(45deg) translateY(10px) translateX(4px);">Open</div>
                                </div> -->
                            </div>
                        </div>
                    </a>
        </div>
    </body>
</html>


