<?php
require_once "baza.php";
require_once "session.php";
header('Content-Type: application/json');

// previusListId: previusListId
// newListId: newListId
// taskId: taskId
$response = array('status' => "error");

if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    $response = array('status' => "error2");

    // Delete tasks
    $sql = "DELETE t FROM tasks t
            INNER JOIN lists l ON l.id = t.list_id
            INNER JOIN boards b ON b.id = l.board_id
            INNER JOIN boards_users bu ON bu.board_id = b.id
            WHERE bu.user_id = ?";

    // Delete lists
    $sql2 = "DELETE l FROM lists l
             INNER JOIN boards b ON b.id = l.board_id
             INNER JOIN boards_users bu ON bu.board_id = b.id
             WHERE bu.user_id = ?";

    // Delete board-user associations
    $sql3 = "DELETE FROM boards_users WHERE user_id = ?";

    // Delete boards
    $sql4 = "DELETE b FROM boards b
             LEFT JOIN boards_users bu ON b.id = bu.board_id
             WHERE bu.user_id = ?";

    // Delete user
    $sql5 = "DELETE FROM users WHERE id = ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $response = array('status' => "ok1");

        $stmt2 = $link->prepare($sql2);
        $stmt2->bind_param("i", $userId);

        if ($stmt2->execute()) {
            $response = array('status' => "ok2");

            $stmt3 = $link->prepare($sql3);
            $stmt3->bind_param("i", $userId);

            if ($stmt3->execute()) {
                $response = array('status' => "ok3");

                $stmt4 = $link->prepare($sql4);
                $stmt4->bind_param("i", $userId);

                if ($stmt4->execute()) {
                    $response = array('status' => "ok4");

                    $stmt5 = $link->prepare($sql5);
                    $stmt5->bind_param("i", $userId);

                    if ($stmt5->execute()) {
                        $response = array('status' => "ok5");
                    }
                }
            }
        }
    }

    $stmt->close();
    $stmt2->close();
    $stmt3->close();
    $stmt4->close();
    $stmt5->close();
}

echo json_encode($response);
?>
