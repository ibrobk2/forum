<?php
// Include config file
require_once "config.php";

// Initialize variables for SweetAlert
$alertType = '';
$alertMessage = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $file_name = $_POST['file_name'];

    // Update the file name in the database
    $sql = "UPDATE uploads SET file_name = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $file_name, $id);
        if (mysqli_stmt_execute($stmt)) {
            $alertType = 'success';
            $alertMessage = 'File name updated successfully.';
        } else {
            $alertType = 'error';
            $alertMessage = 'Something went wrong. Please try again later.';
        }
        mysqli_stmt_close($stmt);
    }
}

// Fetch the file details
$id = $_GET['id'];
$sql = "SELECT file_name FROM uploads WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $file_name);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit File</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit File</h2>
        <form action="edit_file.php" method="post">
            <div class="form-group">
                <label for="file_name">File Name</label>
                <input type="text" name="file_name" id="file_name" class="form-control" value="<?php echo htmlspecialchars($file_name); ?>">
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <?php if ($alertMessage): ?>
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
    <?php endif; ?>
</body>
</html>

<?php
// Close connection
mysqli_close($link);
?>