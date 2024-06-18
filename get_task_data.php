<?php
require_once "baza.php";
require_once "session.php";
header('Content-Type: application/json');

if(isset($_SESSION['username']) && isset( $_SESSION['password']) && isset($_POST['taskId']))  {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $taskId = $_POST['taskId'];

    if($taskId < 0) {
        $response = array();

        echo json_encode($response);
        return;
    }

    $sql = "SELECT t.id, t.name, t.description, t.data, t.complete FROM tasks t WHERE id = $taskId";

    $result = mysqli_query($link, $sql);

       
    $response = array();

    if ($result) {
        while($row = mysqli_fetch_array($result)) {
            $response = $row;
        }

    }
}

echo json_encode($response);

?>