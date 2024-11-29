<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "blog_db";

// Form data
$blogTitle = $_POST["blogtitle"];
$blogDate = $_POST["blogdate"];
$blogPara = $_POST["blogpara"];

// Database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Default filename if no file is uploaded
$filename = "NONE";

// Handle file upload
if (isset($_FILES['uploadimage']) && $_FILES['uploadimage']['error'] === UPLOAD_ERR_OK) {
    $filename = $_FILES['uploadimage']['name'];
    $tempname = $_FILES['uploadimage']['tmp_name'];

    // Ensure images folder exists
    if (!file_exists('images')) {
        mkdir('images', 0777, true);
    }

    // Move uploaded file to the images directory
    if (move_uploaded_file($tempname, "images/" . $filename)) {
        // echo "Image uploaded successfully.<br>";
    } else {
        echo "Failed to upload image.<br>";
    }
} else {
    echo "No image uploaded or an error occurred.<br>";
}

// Insert data into database
$sql = "INSERT INTO blog_table (topic_title, topic_date, image_filename, topic_para) 
        VALUES ('$blogTitle', '$blogDate', '$filename', '$blogPara')";

if ($conn->query($sql) === TRUE) {
    // echo "Post saved successfully.<br>";
} else {
    echo "Error saving post: " . $conn->error;
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Saved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        .container {
            width: 60%;
            margin: auto;
            text-align: left;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            text-align: center;
        }
        .container img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: auto;
        }
        a {
            text-decoration: none;
            color: white;
            background-color: dodgerblue;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Post Saved</h1>
        <p><strong>Title:</strong> <?php echo htmlspecialchars($blogTitle); ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($blogDate); ?></p>
        <?php if ($filename !== "NONE") : ?>
            <img src="images/<?php echo htmlspecialchars($filename); ?>" alt="Blog Image">
        <?php else : ?>
            <p>No image uploaded.</p>
        <?php endif; ?>
        <p><strong>Content:</strong> <?php echo nl2br(htmlspecialchars($blogPara)); ?></p>
        <br>
        <a href="index.html">Go to Home Page</a>
    </div>

 
</body>
</html>
