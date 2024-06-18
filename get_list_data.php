<?php
require_once "req_log_in.php";
header('Content-Type: application/json');

$response = array('id' => "!isset", 'name' => '!isset',
    'tasks' => array(
        array('taskname' => 'Task 1'),
        array('data' => 'complete: 0')
    ));
if(isset($_SESSION['username']) && isset( $_SESSION['password']) && isset($_POST['selectedBoardId']))  {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $boardId = $_POST['selectedBoardId'];

    if($boardId < 0) {
        $response = array(array());

        echo json_encode($response);
        return;
    }

    $sql = "SELECT l.id, l.name FROM boards b
            INNER JOIN lists l ON l.board_id = b.id
            WHERE l.board_id = $boardId
            ORDER BY l.order DESC";
    $result = mysqli_query($link, $sql);

       
    $response = array();

    if ($result) {
        while($row = mysqli_fetch_array($result)) {
            $listId = $row['id'];
            $listName = $row['name'];
            $tasks = array();

            $sql2 = "SELECT t.id, t.name, t.description, t.data, t.complete FROM lists l
                    INNER JOIN tasks t ON t.list_id = l.id
                    WHERE l.id = $listId
                    ORDER BY t.order";
            $result2 = mysqli_query($link, $sql2);

            while($row2 = mysqli_fetch_array($result2)) {
                $arr = $row2;
                array_push($tasks, $arr);
            }

            $listData = array('id' => $listId, 'name' => $listName,
                'tasks' => $tasks
            );
            array_push($response, $listData);
        }

    }
}

echo json_encode($response);

?>