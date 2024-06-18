<?php
require_once "req_log_in.php";
header('Content-Type: application/json');

$response = array('bname' => "!isset", 'description' => '!isset');
if(isset($_SESSION['username']) && isset( $_SESSION['password']))  {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $sql = "SELECT b.id, b.title FROM boards b INNER JOIN boards_users bu ON b.id = bu.board_id INNER JOIN users u ON u.id = bu.user_id WHERE u.username='$username' AND u.pasw='$password'";
    $result = mysqli_query($link, $sql);

       
    $response = array(array());

    if ($result) {
        while($row = mysqli_fetch_array($result)) {
            $bname = $row['title'];
            $id = $row['id'];

            $arr = array('id' => $id,'bname' => $bname, 'description' => 'a neat board');
            array_push($response, $arr);
        }

    }
}

echo json_encode($response);

?>