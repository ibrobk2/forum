<?php
// Include config file
require_once "config.php";

// Fetch files from the database
$sql = "SELECT id, file_name FROM uploads";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Download Files</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="container mt-5">
        <h2 class="mb-4">Download Files</h2>
        <table id="filesTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                                <td>' . htmlspecialchars($row['file_name']) . '</td>
                                <td>
                                    <a href="uploads/' . htmlspecialchars($row['file_name']) . '" class="btn btn-primary btn-sm" download>
                                        <i class="la la-download"></i> Download
                                    </a>
                                </td>
                              </tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">No files found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php include "footer.php"; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#filesTable').DataTable();
        });
    </script>
</body>
</html>

<?php
// Close connection
mysqli_close($link);
?>