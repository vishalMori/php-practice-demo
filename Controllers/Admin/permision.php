<?php
  require "../../config/dbConnection.php";

  $jsonObj = json_decode($_GET['obj'], false);
  $getStatus = $jsonObj->status;
  $phone = $jsonObj->id;

  ($getStatus == "1") ? $getStatus = "0" : $getStatus = "1";
  
  $updatePermition = $conn->prepare("UPDATE `students` SET `status` = ? WHERE `enrollment` = ?");
  $updatePermition->bind_param("ss", $getStatus, $phone);
  $updatePermition->execute();
