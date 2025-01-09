<?php
// Include config file
require_once "config.php";

// Initialize variables for SweetAlert
$alertType = '';
$alertMessage = '';

// Check if the id is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the file from the database
    $sql = "DELETE FROM uploads WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $alertType = 'success';
            $alertMessage = 'File deleted successfully.';
        } else {
            $alertType = 'error';
            $alertMessage = 'Something went wrong. Please try again later.';
        }
        mysqli_stmt_close($stmt);
    }
}

// Close connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete File</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '<?php echo $alertType; ?>',
                title: '<?php echo $alertMessage; ?>',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = 'manage_files.php';
            });
        });
    </script>
</body>
</html>