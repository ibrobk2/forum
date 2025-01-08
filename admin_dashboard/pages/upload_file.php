<?php
// Include config file
require_once "config.php";
// Load the upload form
include "upload_form.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadOk = 1;
    $upload_dir = "uploads/";
    $file_name = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $upload_dir . $file_name;
    $fileExtension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Allow specific file extensions
    $allowedExtensions = ["jpg", "jpeg", "png", "gif", "doc", "docx", "xls", "xlsx", "pdf", "mp3", "mp4", "avi"];
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "Sorry, only the following file types are allowed: " . implode(", ", $allowedExtensions);
        $uploadOk = 0;
    }

    // Check file size (e.g., 10MB limit)
    if ($_FILES["fileToUpload"]["size"] > 10 * 1024 * 1024) {
        echo "Sorry, your file is too large. Maximum allowed size is 10MB.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Attempt to upload the file
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars($file_name) . " has been uploaded.";
            
            // Prepare an insert statement
            $sql = "INSERT INTO uploads (file_name) VALUES (?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_file_name);
                // Set parameters
                $param_file_name = $file_name;
                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    echo "File name saved to database.";
                } else {
                    echo "Something went wrong. Please try again later.";
                }
                // Close statement
                mysqli_stmt_close($stmt);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close connection
mysqli_close($link);
?>
