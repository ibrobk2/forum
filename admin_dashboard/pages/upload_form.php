<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload File</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Upload File</h2>
        <form action="upload_file.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Choose file to upload:</label>
                <input type="file" name="fileToUpload" id="fileToUpload" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Upload File</button>
        </form>
    </div>
</body>
</html>