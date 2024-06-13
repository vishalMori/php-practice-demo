<?php
  require "../config/dbConnection.php";
  require "../utility/validation.php";

  $responce;
  $email;

  if (emailValidate($_GET['email'])) {
    $email = $_GET['email'];
  }

  if (!empty($email)) {
    $select = $conn->prepare("DELETE FROM `students` WHERE `email` = ?");
    $select->bind_param("s", $email);
    $select->execute();

    header("Content-Type: Application/json");
    $responce = "Success";
  } else {
    $responce = "Invalid email.";
  }
  echo json_encode($responce);