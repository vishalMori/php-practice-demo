<?php
  session_start();

  require "../config/dbConnection.php";
  require "../vendor/autoload.php";
  require "../utility/validation.php";
  require "../config/mail.php";
  require "../services/MailServices.php";

  if (isset($_SESSION['response'])) {
    $_SESSION['response'] = "";
  }

  $name;
  $surname;
  $password;
  $conformPassword;
  $email = "helll";
  $phone;
  $gender;
  $grade;
  $hobby;
  $token = uniqid();
  $imageName;
  $flag;
  $response = "";
  $validEmail = "";
  $validPhone = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $obj = json_decode(file_get_contents("php://input"), true);

    $image = base64_decode($obj['image']);
    $imageName = "profile.jpg";
    file_put_contents("../public/uploads/" . $imageName, $image);
    //move_uploaded_file($imageName, "../public/uploads/" . $imageName);
    // $insertImage = "INSERT INTO `images`(`email`,`img`) VALUES ('$email', '$imageName')";
    // $conn->query($insertImage);


    // $name = valideValue($obj['name']);
    // $surname = valideValue($obj['surname']);
    // $password = md5($obj['password']);
    // $conformPassword = md5($obj['conPassword']);
    // $email = $obj['email'];
    // $phone = $obj['phone'];
    // $gender = $obj['gender'];
    // $grade = $obj['grade'];
    // $hobby = $obj['hobby'];
    // $tempName = $_FILES['file']['tmp_name'];
    // $valideFormates = ["image/jpeg", "image/jpg", "image/png"];
    // $fileFormate = mime_content_type($tempName);
    // if (in_array($fileFormate, $valideFormates)) {
    //   echo "valide";
    // }
  }
  
  // $fileName = $_FILES['file']['name'];
  // $extentions = ["png", "jpg", "jpeg"];
  // $ext = pathinfo($fileName, PATHINFO_EXTENSION);

  // if (in_array($ext, $extentions)) {
  //   $imageName = $phone . "." . $ext;
  // } else {
  //   $response = "invalid file type";
  // }

//   try {
//     if (emailValidate($email) == 1) {
//       $validEmail = $email;
//       if (strlen($phone) == 10) {
//         $validPhone = $phone;
//         $userName = substr($validEmail, 0, strpos($validEmail, "@"));

//         $userExist = "SELECT `email` FROM `students` WHERE `email` = '$validEmail'";
//         $finddUser = $conn->query($userExist);
//         if ($finddUser->num_rows == 0) {
//           if ($password == $conformPassword) {
//             //move_uploaded_file($tempName, "../../public/uploads/" . $imageName);
//             $newRecord = "INSERT INTO `students` (`user_name`, `name`, `surname`, `email`, `phone`, `gender`, `grade`, `password`, `hobby`)
//             VALUES ('$userName', '$name', '$surname', '$validEmail', '$validPhone', '$gender', '$grade', '$password', '$hobby')";
//             $conn->query($newRecord);
//             $insertToken = "INSERT INTO `emails_verification`(`email`, `token`) VALUES ('$validEmail','$token')";
//             $conn->query($insertToken);
//             $insertImage = "INSERT INTO `images`(`email`,`img`) VALUES ('$validEmail', '$imageName')";
//             //$conn->query($insertImage);
//             //$mail = new MailServices();
//             //$mail->verificationMail($token);
//             echo $response = "Registrion success mail send verify email.";
//             http_response_code(201);
//             //header("Location: http://localhost/mywork/demoWebsite/views/auth/afterRegistration.php");
//           } else {
//             $flag = true;
//             http_response_code(400);
//             throw new Exception("Password and conform password not match.", 1);
//           }
//         } else {
//           $flag = true;
//           http_response_code(400);
//           throw new Exception("User alredy exist.", 1);
//         }
//       } else {
//         $flag = true;
//         http_response_code(400);
//         throw new Exception("Phone number must be 10 digits", 1);
//       }
//     } else {
//       $flag = true;
//       http_response_code(400);
//       throw new Exception("Invalid email formate", 1);
//     }
//     $conn->close();
//   } catch (Exception $e) {
//     if ($flag == true) {
//       $_SESSION['response'] = $e->getMessage();
//       //header("Location: http://localhost/mywork/demoWebsite/views/auth/registration.php");
//     }
//     $time = "[" . date('Y-m-d h:i:s') . "]";
//     $currentPage = $e->getFile();
//     $lineNumber = "line " . $e->getLine();
//     echo $message = $e->getMessage() . "\n";

//     $error =  $time . " : " . $currentPage . " : " . $lineNumber . ": " . $message;
//     $errorFile = fopen("../../errors.log", "a") or die("Unable to opane file");
//     fwrite($errorFile, $error);
//     fclose($errorFile);
//   }
// ?>