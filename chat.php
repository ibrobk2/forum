<?php
session_start();
require_once "config.php";



// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"])){
    if(!isset($_SESSION["loggedin_admin"])){
    header("location: login.php");
    exit;
    }
}

$user_id = $_SESSION["id"];
$user_type = $_SESSION["user_type"];

// Fetch users and admins for the dropdown
$users = [];
$admins = [];

$user_sql = "SELECT id, username FROM users";
$user_result = mysqli_query($link, $user_sql);
while ($row = mysqli_fetch_assoc($user_result)) {
    $users[] = $row;
}

$admin_sql = "SELECT id, username FROM admin";
$admin_result = mysqli_query($link, $admin_sql);
while ($row = mysqli_fetch_assoc($admin_result)) {
    $admins[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
     <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
</head>
<body>
    <?php include "navbar_chat.php"; ?>
    <div class="container mt-1">
        <h2 class="mb-4">Chat</h2>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="chat-with">Chat with:</label>
                    <select id="chat-with" class="form-control" >
                        <option value="">Select a user</option>
                        <optgroup label="Users">
                            <?php foreach ($users as $user): ?>
                                <option value="user-<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['username']); ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                        <optgroup label="Admins">
                            <?php foreach ($admins as $admin): ?>
                                <option value="admin-<?php echo $admin['id']; ?>"><?php echo htmlspecialchars($admin['username']); ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    </select>
                </div>
                <div id="chat-box" style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <!-- Messages will be loaded here -->
                </div>
                <form id="chat-form" class="mt-3">
                    <div class="input-group">
                        <input type="text" id="message" class="form-control" placeholder="Type a message...">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">Send</button>
                        </div>
                       
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>
    <script>
        $(document).ready(function() {
            // Load messages
            function loadMessages() {
                var chatWith = $('#chat-with').val();
                if (chatWith) {
                    $.ajax({
                        url: 'load_messages.php',
                        method: 'GET',
                        data: { chat_with: chatWith },
                        success: function(data) {
                            $('#chat-box').html(data);
                            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                        }
                    });
                }
            }

            $('#chat-with').change(function() {
                loadMessages();
            });

            setInterval(loadMessages, 3000); // Refresh messages every 3 seconds

            // Send message
            $('#chat-form').submit(function(e) {
                e.preventDefault();
                var message = $('#message').val();
                var chatWith = $('#chat-with').val();
                if (message.trim() !== '' && chatWith) {
                    $.ajax({
                        url: 'send_message.php',
                        method: 'POST',
                        data: { message: message, chat_with: chatWith },
                        success: function() {
                            $('#message').val('');
                            loadMessages();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>