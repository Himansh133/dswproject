<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog Using PHP And MySQL</title>
  <link rel="stylesheet" href="styles/style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 0;
    }

    .top-bar {
      background-color: #4caf50;
      padding: 10px 20px;
      color: white;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .all-posts-container {
      margin: 20px auto;
      width: 80%;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
    }

    .post-container {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      cursor: pointer;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .post-container:hover {
      transform: scale(1.03);
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }

    .post-container.expanded {
      grid-column: span 2;
      padding: 30px;
      height: 500px;
      width: 500px;
    }

    #displayTitle {
      font-size: 20px;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
      overflow-y: auto;
    }

    #displayDate {
      font-size: 14px;
      color: #777;
      margin-bottom: 15px;
    }

    #displayImage {
      /* margin-left: 20%; */
      width: 100%;
      height: auto;
      margin-bottom: 15px;
      border-radius: 10px;
      max-height: 200px;
      max-width: 200px;
    }
    #displayPara {
  font-size: 16px;
  color: #555;
  line-height: 1.6;
  text-align: justify;
  margin-bottom: 10px;
  overflow: hidden; /* Hide overflow initially */
  display: -webkit-box;
  -webkit-line-clamp: 5; /* Limit to 5 lines */
  line-clamp: 5;
  -webkit-box-orient: vertical;
  max-height: 120px; /* Define height for 5 lines */
}

.expanded #displayPara {
  overflow-y: auto; /* Enable scrolling */
  -webkit-line-clamp: unset; /* Remove line clamping */
  line-clamp: unset; /* Support for other browsers */
  max-height: 300px; /* Set a larger max height for scrolling */
 
}


    .write-post-button {
      display: inline-block;
      text-align: center;
      background-color: #4caf50;
      color: white;
      font-size: 16px;
      padding: 10px 20px;
      border: none;
      border-radius: 50px;
      cursor: pointer;
      margin-top: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .write-post-button:hover {
      background-color: #45a049;
    }

    @media (max-width: 768px) {
      .all-posts-container {
        width: 90%;
      }
    }
  </style>
</head>

<body>
  <div class="top-bar">
    <span id="topBarTitle">Blog | All Posts</span>
  </div>

  <br>

  <div class="all-posts-container">

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "blog_db";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) die("Connection Error" . $conn->connect_error);

    $sql = "select topic_title, topic_date, image_filename, topic_para from blog_table;";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<div class='post-container' onclick='expandPost(this)'>";

        echo "<span id='displayTitle'>" . $row["topic_title"] . "</span>";
        echo "<span id='displayDate'>" . $row["topic_date"] . "</span>";
        echo "<img id='displayImage' src='images/" . $row["image_filename"] . "'>";
        echo "<p id='displayPara'>" . $row["topic_para"] . "</p>";

        echo "</div>";
      }
    } else {
      echo "<center><span>No Blog Posts Found</span></center>";
    }

    $conn->close();
    ?>

  </div>

  <br>
  <center>
    <a href="index.html" class="write-post-button">Write a New Post</a>
  </center>
  <br>

  <script>
    function expandPost(post) {
      post.classList.toggle('expanded');
    }
  </script>
</body>

</html>
