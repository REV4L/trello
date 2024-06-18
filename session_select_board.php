<?php
require_once "baza.php";
require_once "req_log_in.php";
header('Content-Type: application/json');


$response = array('status' => 'Id not set in post');
if(isset($_POST['id']))  {
    $_SESSION['selectedBoardId'] = $_POST['id'];
    $response = array('status' => 'Complete');
}

echo json_encode($response);

?>