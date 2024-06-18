<?php
require_once "baza.php";
require_once "session.php";
header('Content-Type: application/json');

// previusListId: previusListId
// newListId: newListId
// taskId: taskId

$response = array('status' => "error");
if(isset($_SESSION['username']) && isset( $_SESSION['password']) && isset
($_POST['boardId']))  {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $boardId = $_POST['boardId'];

    $response = array('status' => "error2");

    $sql = "DELETE FROM tasks WHERE id IN (SELECT t.id FROM tasks t INNER JOIN lists l ON l.id = t.list_id INNER JOIN boards b ON b.id = l.board_id WHERE b.id = $boardId);";
    $sql2 = "DELETE FROM lists WHERE id IN (SELECT l.id FROM lists l INNER JOIN boards b ON b.id = l.board_id WHERE b.id = $boardId);";
    $sql3 = "DELETE FROM boards_users WHERE board_id = $boardId ;";
    $sql4 = "DELETE FROM boards WHERE id = $boardId ;";

    if(mysqli_query($link, $sql)) {
        $response = array('status' => "ok1");

        if(mysqli_query($link, $sql2)) {
            $response = array('status' => "ok2");

            if(mysqli_query($link, $sql3)) {
                $response = array('status' => "ok3");

                if(mysqli_query($link, $sql4)) {
                    $response = array('status' => "ok4");
                }
            }
        }
    }

}

echo json_encode($response);

?>