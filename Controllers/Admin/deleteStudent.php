<?php
  include "../../config/dbConnection.php";

  
  $obj = json_decode($_GET['obj'], true);
  $enrollment = $obj["enrollment"];
  $email = $obj["email"];
  
  try {
    $selectImage = $conn->prepare("SELECT `img` FROM `images` WHERE `email` = ?");
    $selectImage->bind_param("s", $email);
    $selectImage->execute();
    $imageName = $selectImage->get_result()->fetch_assoc()['img'];
    
    $filePath = "../../public/uploads/" . $imageName;

    $deleteStudent = "DELETE FROM students WHERE `enrollment` = '$enrollment'";
    if ($conn->query($deleteStudent)) {
      $response = "removed";
      unlink($filePath);
    } else {
      $response = "Fail to remove";
    }
  $conn->close();
  } catch (Exception $e) {
    echo $e->getMessage();
  }
