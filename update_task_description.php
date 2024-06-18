<?php
require_once "baza.php";
require_once "session.php";
header('Content-Type: application/json');

// previusListId: previusListId
// newListId: newListId
// taskId: taskId

$response = array('status' => "error");
if(isset($_SESSION['username']) && isset( $_SESSION['password']) && isset
($_POST['taskId']) && isset($_POST['taskDescription']))  {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $taskId = $_POST['taskId'];
    $taskDescription = $_POST['taskDescription'];

    $response = array('status' => "error2");

    $sql = "UPDATE tasks SET `description`= '$taskDescription' WHERE id = $taskId ;";

    if(mysqli_query($link, $sql)) {
        $response = array('status' => "ok");
    }

}

echo json_encode($response);

?>