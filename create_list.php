<?php
require_once "baza.php";
require_once "session.php";
header('Content-Type: application/json');

$response = array('status' => "error");
if(isset($_SESSION['username']) && isset( $_SESSION['password']) && isset($_POST['boardId']))  {
    $response = array('status' => "error2");
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $boardId = $_POST['boardId'];
    $dateadded = date('Y-m-d H:i:s');

    $sql = "INSERT INTO lists(name, date_added, board_id)
            VALUES('New list', NOW(), $boardId)";

    if(mysqli_query($link, $sql)) {
        $response = array('status' => "Added");
    }

}

echo json_encode($response);

?>