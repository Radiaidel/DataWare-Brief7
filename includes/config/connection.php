<?php
  $conn = new mysqli("localhost", "root", "", "dataware_db");
  if ($conn->connect_error) {
      die("connection failed : " . $connection->connect_error);
  }
  //  UTF-8
mysqli_set_charset($conn, "utf8");
?>