<?php
require_once "baza.php";
require_once "session.php";
header('Content-Type: application/json');

// previusListId: previusListId
// newListId: newListId
// taskId: taskId

$response = array('status' => "error");
if(isset($_SESSION['username']) && isset( $_SESSION['password']) && isset
($_POST['listId']) && isset($_POST['listName']))  {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $listId = $_POST['listId'];
    $listName = $_POST['listName'];

    $response = array('status' => "error2");

    $sql = "UPDATE lists SET `name`= '$listName' WHERE id = $listId ;";

    if(mysqli_query($link, $sql)) {
        $response = array('status' => "ok");
    }

}

echo json_encode($response);

?>