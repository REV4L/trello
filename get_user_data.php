<?php
require_once "baza.php";
require_once "session.php";
header('Content-Type: application/json');

if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true ) {


    $response = array();

    // $sql = "SELECT u.id, u.username, u.email, t.name FROM users u INNER JOIN user_types ut ON u.user_type_id = ut.id WHERE ut.name != 'admin'";
    $sql = "SELECT u.id, u.username, u.email FROM users u";

    $result = mysqli_query($link, $sql);

       
    $response = array();

    if ($result) {
        while($row = mysqli_fetch_array($result)) {
            array_push($response, $row);
        }

    }
}

echo json_encode($response);

?>