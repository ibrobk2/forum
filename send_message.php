<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["id"];
    $user_type = $_SESSION["user_type"];
    // $user_id = $_POST["id"];
    // $user_type = $_POST["user_type"];
    $message = $_POST["message"];
    $chat_with = $_POST["chat_with"];
    list($chat_with_type, $chat_with_id) = explode('-', $chat_with);

    $sql = "INSERT INTO messages (user_id, user_type, message) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "iss", $user_id, $user_type, $message);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
?>