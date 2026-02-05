<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli("mariadb", "root", "IU2026", "itsyssoftware");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  
  }

  $lat = floatval($_POST["lat"]);
  $lng = floatval($_POST["lng"]);
  $popup = $conn->real_escape_string($_POST["popup"]);

  $sql = "INSERT INTO markers (lat, lng, popup) VALUES ($lat, $lng, '$popup')";
  if ($conn->query($sql) !== TRUE) {
    die("Error adding marker: " . $conn->error);
  }

  header("Location: index.php");
  exit();
} else {
  # return 500 error for non-POST requests
  http_response_code(500);
  echo "Invalid request method.";
}