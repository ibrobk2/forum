<?php
require_once "config.php";

$chat_with = $_GET['chat_with'];
list($chat_with_type, $chat_with_id) = explode('-', $chat_with);

$sql = "SELECT * FROM messages WHERE (user_id = ? AND user_type = ?) OR (user_id = ? AND user_type = ?) ORDER BY created_at ASC";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "isii", $_SESSION['id'], $_SESSION['user_type'], $chat_with_id, $chat_with_type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $user_type = $row['user_type'];
        $user_id = $row['user_id'];
        $message = htmlspecialchars($row['message']);
        $created_at = $row['created_at'];

        if ($user_type == 'user') {
            $user_sql = "SELECT username FROM users WHERE id = $user_id";
        } else {
            $user_sql = "SELECT username FROM admin WHERE id = $user_id";
        }

        $user_result = mysqli_query($link, $user_sql);
        $user_row = mysqli_fetch_assoc($user_result);
        $username = htmlspecialchars($user_row['username']);

        echo "<div><strong>$username:</strong> $message <small class='text-muted'>$created_at</small></div>";
    }
    mysqli_stmt_close($stmt);
}
?>