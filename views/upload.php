<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["files"])) {
    $uploadDir = "uploads/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $files = $_FILES["files"];
    $uploadedFiles = [];
    $errors = [];

    for ($i = 0; $i < count($files["name"]); $i++) {
        $fileName = basename($files["name"][$i]);
        $filePath = $uploadDir . $fileName;
        $fileSize = $files["size"][$i];
        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // File validation
        if ($fileType !== "jpg" && $fileType !== "jpeg") {
            $errors[] = "$fileName - Only JPG files are allowed.";
            continue;
        }
        if ($fileSize < 100 * 1024 || $fileSize > 500 * 1024) {
            $errors[] = "$fileName - File size must be between 100KB and 500KB.";
            continue;
        }

        if (move_uploaded_file($files["tmp_name"][$i], $filePath)) {
            $uploadedFiles[] = $filePath;
        } else {
            $errors[] = "$fileName - Upload failed.";
        }
    }

    $_SESSION['uploaded_files'] = $uploadedFiles;
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit;
}
?>
