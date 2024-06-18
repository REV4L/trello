<?php
require_once "baza.php";
require_once "session.php";
header('Content-Type: application/json');

// previusListId: previusListId
// newListId: newListId
// taskId: taskId

$response = array('status' => "error");
if(isset($_SESSION['username']) && isset( $_SESSION['password']) && isset
($_POST['newListId']) && isset($_POST['taskId']))  {

    $response = array('status' => "error2");
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $newListId = $_POST['newListId'];
    $taskId = $_POST['taskId'];
    // $dateadded = date('Y-m-d H:i:s');

    $sql = "UPDATE tasks 
            SET list_id = $newListId
            WHERE id = $taskId";

    if(mysqli_query($link, $sql)) {
        $response = array('status' => "ok");
    }

}

echo json_encode($response);

?>