<?php
require_once "baza.php";
require_once "session.php";
header('Content-Type: application/json');

// previusListId: previusListId
// newListId: newListId
// taskId: taskId

$response = array('status' => "error");
if(isset($_SESSION['username']) && isset( $_SESSION['password']) && isset
($_POST['listId']))  {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $listId = $_POST['listId'];

    $response = array('status' => "error2");

    $sql = "DELETE FROM tasks WHERE id IN (SELECT t.id FROM tasks t INNER JOIN lists l ON l.id = t.list_id WHERE l.id = $listId);";
    $sql2 = "DELETE FROM lists WHERE id = $listId ;";

    if(mysqli_query($link, $sql)) {
        $response = array('status' => "ok1");

        if(mysqli_query($link, $sql2)) {
            $response = array('status' => "ok2");
        }
    }

}

echo json_encode($response);

?>