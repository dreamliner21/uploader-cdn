<?php
header('Content-Type: application/json');

// Set folder penyimpanan
$uploadDir = 'uploads/';

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = uniqid() . '-' . basename($file['name']);
    $filePath = $uploadDir . $fileName;

    // Proses upload file
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        echo json_encode([
            "success" => true,
            "url" => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . $filePath
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "File upload failed."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No file uploaded."]);
}
?>