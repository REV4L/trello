<?php
require_once "session.php";
header('Content-Type: application/json');

$response = array('value' => -1, 0 => -1);
if(isset($_POST['varname']))  {
    $varname = $_POST['varname'];
    $val = (isset($_SESSION[$varname])) ? $_SESSION[$varname] : -1;

    $response = array('value' => $val, 0 => $val);
}

echo json_encode($response);

?>