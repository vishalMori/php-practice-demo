<?php
  require "../../config/dbConnection.php";

  $records;

  $select = "SELECT `email` FROM `students`";
  $result = $conn->query($select);
  while ($row = $result->fetch_assoc()) {
    $records[] = $row['email'];
  }
  echo json_encode($records);