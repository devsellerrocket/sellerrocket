<?php
$mysqli = new mysqli("localhost", "your_username", "your_password", "your_database");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handle the uploaded image
$targetDir = "uploads/";
$imageName = basename($_FILES["image"]["name"]);
$targetFile = $targetDir . time() . "_" . $imageName; 
// Add timestamp to avoid conflicts
$imageType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

$uploadOk = 1;
$allowedTypes = ["jpg", "jpeg", "png", "gif"];

if (!in_array($imageType, $allowedTypes)) {
    echo "Only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk && move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
    // Prepare and insert the article
    $stmt = $mysqli->prepare("INSERT INTO zomato_articles (heading, description, publish_date, url, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $_POST['heading'], $_POST['description'], $_POST['publish_date'], $_POST['url'], "hi");
    if ($stmt->execute()) {
        echo "Article uploaded successfully!";
    } else {
        echo "Error inserting article: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "There was an error uploading the image.";
}

$mysqli->close();
?>
