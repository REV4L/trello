<?php
require_once "baza.php";
require_once "session.php";
header('Content-Type: application/json');

// previusListId: previusListId
// newListId: newListId
// taskId: taskId

$response = array('status' => "error");
if(isset($_SESSION['username']) && isset( $_SESSION['password']) && isset
($_POST['taskIds']) && isset($_POST['taskOrders']))  {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $listIds = $_POST['taskIds'];
    $listOrders = $_POST['taskOrders'];

    $ok = true;

    $response = array('status' => "error2");

    foreach ($listIds as $index => $listId) {

        $order = $listOrders[$index];

        $sql = "UPDATE tasks SET `order` = $order WHERE id = $listId ;";

        $result = mysqli_query($link, $sql);

        $ok = $ok && $result;
    }

    if($ok) {
        $response = array('status' => "ok");
    } else {
        $response = array('status' => "updating one or multiple task orders failed");
    }

}

echo json_encode($response);

?>