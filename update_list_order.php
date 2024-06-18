<?php
require_once "baza.php";
require_once "session.php";
header('Content-Type: application/json');

// previusListId: previusListId
// newListId: newListId
// taskId: taskId

$response = array('status' => "error");
if(isset($_SESSION['username']) && isset( $_SESSION['password']) && isset
($_POST['listIds']) && isset($_POST['listOrders']))  {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $listIds = $_POST['listIds'];
    $listOrders = $_POST['listOrders'];

    $ok = true;

    $response = array('status' => "error2");

    foreach ($listIds as $index => $listId) {

        $order = $listOrders[$index];

        $sql = "UPDATE lists SET `order` = $order WHERE id = $listId ;";

        $result = mysqli_query($link, $sql);

        $ok = $ok && $result;
    }

    if($ok) {
        $response = array('status' => "ok");
    } else {
        $response = array('status' => "updating one or multiple list orders failed");
    }

}

echo json_encode($response);

?>