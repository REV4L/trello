<?php
require_once "baza.php";
require_once "session.php";
header('Content-Type: application/json');

$response = array('status' => "error");
if(isset($_SESSION['username']) && isset( $_SESSION['password']) && isset($_POST['boardId']) && isset($_POST['listId']))  {

    $response = array('status' => "error2");
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $boardId = $_POST['boardId'];
    $listId = $_POST['listId'];
    // $dateadded = date('Y-m-d H:i:s');

    $sql = "INSERT INTO tasks(name, date_added, list_id)
            VALUES('New task', NOW(), $listId)";

    if(mysqli_query($link, $sql)) {
        $response = array('status' => "Added");
    }

}

echo json_encode($response);

?>