<?php
require_once "req_log_in.php";
header('Content-Type: application/json');

$response = array('status' => 'Error');

if(isset($_SESSION['username']) && isset( $_SESSION['password']) && isset($_POST['boardname']))  {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    
    $boardname = $_POST['boardname'];

    if (strlen($boardname) <= 3) {
        $response = array('status' => 'Name too short');
        echo json_encode($response);
        return;
    }

    $description = isset($_POST['description']) ? $_POST['description'] : '';
    
    $dateadded = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS

    // a z obstaja en z istim imenom
    $sqlCheckUserExists = "SELECT COUNT(*) FROM boards b
        INNER JOIN boards_users bu ON bu.board_id = b.id
        INNER JOIN users u ON bu.user_id = u.id
        WHERE b.title = ? AND u.username = ?";
    // $sqlCheckBoardExists = "SELECT COUNT(*) FROM boards b
    // INNER JOIN boards_users bu ON bu.board_id = b.id
    // INNER JOIN users u ON bu.user_id = u.id
    // WHERE b.title = ?";
    $stmtCheckUserExists = $link->prepare($sqlCheckUserExists);
    $stmtCheckUserExists->bind_param("ss", $boardname, $username);
    $stmtCheckUserExists->execute();
    // $stmtCheckBoardExists->bind_result($boardNames, $users);
    $stmtCheckUserExists->bind_result($boardCount);
    $stmtCheckUserExists->fetch();
    $stmtCheckUserExists->close();

    if ($boardCount > 0) {
        $response = array('status' => 'Name taken');
        echo json_encode($response);
        return;
    }

//////////////////////////////
    
    $sqlInsertBoard = "INSERT INTO boards (title, description, date_added) VALUES (?, ?, ?)";
    $stmtInsertBoard = $link->prepare($sqlInsertBoard);
    
    $stmtInsertBoard->bind_param("sss", $boardname, $description, $dateadded);
    
    if($stmtInsertBoard->execute()) {
        $response = array('status' => 'Added board only');
        $boardId = $stmtInsertBoard->insert_id;

        $sqlGetUserId = "SELECT id FROM users WHERE username=? AND pasw=?";
        $stmtGetUserId = $link->prepare($sqlGetUserId);
        $stmtGetUserId->bind_param("ss", $username, $password);

        $stmtGetUserId->execute();
        $stmtGetUserId->bind_result($userId);
        $stmtGetUserId->fetch();
        $stmtGetUserId->close();

        $response = array('status' => 'No userId');

        if($userId) {
            $sqlInsertBoardsUsers = "INSERT INTO boards_users(user_id, board_id) VALUES (?, ?)";
            $stmtInsertBoardsUsers = $link->prepare($sqlInsertBoardsUsers);
        
            $stmtInsertBoardsUsers->bind_param("ii", $userId, $boardId);

            if($stmtInsertBoardsUsers->execute()) {
                $stmtInsertBoardsUsers->close();
                $response = array('status' => 'Success');
            }
        }

    }
    else 
    {
        //noob
        $response = array('status' => 'Failed');
    }

    $stmtInsertBoard->close();
}

echo json_encode($response);

?>