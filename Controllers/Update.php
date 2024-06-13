<?php
  session_start();
  require "../config/dbConnection.php";
  require "../utility/validation.php";

  if (isset($_POST['btnupdate'])) {
    $name = valideValue($_POST['name']);
    $surname = valideValue($_POST['surname']);
    echo $phone = $_POST['phone'];
    $hobby = implode(",",$_POST['hoby']);
    $gender = $_POST['gender'];
    $email = $_SESSION['updateRequestEmail'];
    
    $updateRecord = $conn->prepare("UPDATE `students` SET `name` = ?, `surname` = ?, `phone`= ?, `gender` = ?, `hobby` = ? WHERE `email` = ?");
    $updateRecord->bind_param('ssssss', $name, $surname, $phone, $gender, $hobby, $email);
    $updateRecord->execute();
    if ($_SESSION['socialLogin'] !== 1) {
      if (!empty($_FILES['profile'])) {
        $fileName = $_FILES['profile']['name'];
        $tempName = $_FILES['profile']['tmp_name'];
        $extentions = ["png", "jpg", "jpeg"];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if (in_array($ext, $extentions)) {
          $imageName = $phone . "." . $ext;
          $insertImage = "INSERT INTO `images`(`email`,`img`) VALUES ('$email', '$imageName')";
          $conn->query($insertImage);
          move_uploaded_file($tempName, "../public/uploads/" . $imageName);
        } else {
          $response = "invalid file type";
        }
      }
    }
    ($_SESSION['userName'] == "admin") ? header("Location: ../views/Admin/usersList.php") : header("Location: ../views/User/homePage.php");
  }