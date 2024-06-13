<?php
  require_once "connection.php";

  $response = "";
  $arr = [];

  try {
    $selectRecord = "SELECT `name`, `email`, `verified_email`, `phone`, `status`, `is_approved` FROM `students`";
    $result = $conn->query($selectRecord);
    $selectImage = "SELECT `img` FROM `images`";
    $selected = $conn->query($selectImage);
    while ($row = $result->fetch_assoc() ) {
       $image = $selected->fetch_assoc();
      $arr[] = $row + $image;
    }
    $response = json_encode($arr);
  } catch (Exception $e) {
    $response = $e->getMessage();
  } finally {
    echo $response;
    $conn->close();
  }
