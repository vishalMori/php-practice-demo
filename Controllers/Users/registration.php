<?php
  session_start();

  require "../../config/dbConnection.php";
  require "../../vendor/autoload.php";
  require "../../utility/validation.php";
  require "../../config/mail.php";
  require "../../services/MailServices.php";

  if (isset($_SESSION['response'])) {
    $_SESSION['response'] = "";
  }

  $response = "";
  $validEmail = "";
  $validPhone = "";
  $name = valideValue($_POST['name']);
  $surname = valideValue($_POST['surname']);
  $password =  password_hash(valideValue($_POST["password"]), PASSWORD_DEFAULT);
  $email = $_POST['email'];
  $phone = $_POST['phoneNumber'];
  $gender = $_POST['gender'];
  $grade = $_POST['grade'];
  $hobby = implode(",",$_POST['hoby']);
  $token = uniqid();
  $imageName;
  $flag;

  $fileName = $_FILES['file']['name'];
  $tempName = $_FILES['file']['tmp_name'];
  $extentions = ["png", "jpg", "jpeg"];
  $ext = pathinfo($fileName, PATHINFO_EXTENSION);

  if (in_array($ext, $extentions)) {
    $imageName = date('YmdHis') .".". $ext;
  } else {
    $response = "invalid file type";
  }
  
  try {
    if (emailValidate($email) == 1) {
      $validEmail = $email;
      
      if (strlen($phone) == 10) {
        $validPhone = $phone;
        $userName = substr($validEmail, 0, strpos($validEmail, "@"));

        $userExist = "SELECT `email` FROM `students` WHERE `email` = '$validEmail'";
        $finddUser = $conn->query($userExist);
        if ($finddUser->num_rows == 0) {
          $newRecord = "INSERT INTO `students` (`user_name`, `name`, `surname`, `email`, `phone`, `gender`, `grade`, `password`, `hobby`)
          VALUES ('$userName', '$name', '$surname', '$validEmail', '$validPhone', '$gender', '$grade', '$password', '$hobby')";
          $conn->query($newRecord);
          $insertToken = "INSERT INTO `emails_verification`(`email`, `token`) VALUES ('$validEmail','$token')";
          $conn->query($insertToken);
          $insertImage = "INSERT INTO `images`(`email`,`img`) VALUES ('$validEmail', '$imageName')";
          $conn->query($insertImage);
          move_uploaded_file($tempName, "../../public/uploads/" . $imageName);
          $mail = new MailServices();
          //$mail->verificationMail($token);
          $response = "Registrion success mail send verify email.";
          header("Location: http://localhost/mywork/demoWebsite/views/auth/afterRegistration.php");
        } else {
          $flag = true;
          throw new Exception("User alredy exist.", 1);
        }
      } else {
        $flag = true;
        throw new Exception("Phone number must be 10 digits", 1);
      }
    } else {
      $flag = true;
      throw new Exception("Invalid email formate", 1);
    } 
    $conn->close();
  } catch (Exception $e) {
    if ($flag == true) {
      $_SESSION['response'] = $e->getMessage();
      header("Location: http://localhost/mywork/demoWebsite/views/auth/registration.php");
    }
    $time = "[" . date('Y-m-d h:m:s') . "]";
    $currentPage = $e->getFile();
    $lineNumber = "line " . $e->getLine();
    $message = $e->getMessage() . "\n";

    $error =  $time . " : " . $currentPage . " : " . $lineNumber . ": " . $message;
    $errorFile = fopen("../../errors.log", "a") or die("Unable to opane file");
    fwrite($errorFile, $error);
    fclose($errorFile);
  }
?>