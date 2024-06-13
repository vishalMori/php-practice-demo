<?php
  session_start();
  require "../config/googleLogin.php";
  require "../config/dbConnection.php";

  if (!isset($_GET['code'])) {
    $loginUrl = $client->createAuthUrl();
    header("Location: $loginUrl");
  } else {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (isset($token['error'])) {
      //header('Location: loginpage.php');
    }
    $client->setAccessToken($token);
  
    $infor = new Google\Service\Oauth2($client);
    $userInfo = $infor->userinfo->get();
    //$image = $userInfo['picture'];
    $extention = "png";
    $imageName = date('YmdHis') .".". $extention;
    $image = file_get_contents($userInfo->picture);
    file_put_contents("../public/uploads/" . $imageName, $image);
    //$userInfo['id'];
    $name = $userInfo['giveName'];
    $email = $userInfo['email'];
    $userName;
    $isEmailVerified = true;
    $isSocialLogin = 0;
    $socialLogin = "Social login";
    $isVerified;

    try {
      $findUser = "SELECT `email`, `verified_email`, `is_socialLogin` FROM `students` WHERE `email` = '$email'";
      $result = $conn->query($findUser);
      if ($result->num_rows == 0) {
        $userName = substr($email, 0, strpos($email, "@"));
        if (empty($name)) {
          $name = $userName;
        }
        $isSocialLogin = 1;
        $insert = "INSERT INTO `students`(`user_name`, `name`, `email`, `verified_email`, `is_socialLogin`) VALUES ('$userName', '$name', '$email', '$isEmailVerified', '$isSocialLogin')";
        $conn->query($insert);
        $insertImage = "INSERT INTO `images`(`email`,`img`) VALUES ('$email', '$imageName')";
        $conn->query($insertImage);
        $isSocialLogin = 0;
        goto success;
      } else {
        success:
        $useNameFetched;
        $phoneFetched;
        $statusFetched;
        $positionFetched;
        $profileFetched;
        
        if ($result->num_rows == 1) {
          while ($row = $result->fetch_assoc()) {
            $isVerified = $row['verified_email'];
            $isSocialLogin = $row['is_socialLogin'];
          }
          if ($isVerified == 0 || $isSocialLogin == 0) {
            $isSocialLogin = true;
            $updateInfo = "UPDATE `students` SET `verified_email` = '$isEmailVerified', `password` = '$isSocialLogin', `is_socialLogin` = '$isSocialLogin' WHERE `email` = '$email'";
            $conn->query($updateInfo);
            $updateImage = "UPDATE `images` SET `img` = '$imageName' WHERE `email` = '$email'";
            $conn->query($updateImage);
            file_put_contents($imageName, file_get_contents($imageName));
          }
        }
        $user = "SELECT `user_name`, `status`, `position`, `is_approved`, `is_socialLogin` FROM `students` WHERE `email` = '$email'";
        $record = $conn->query($user);
        $image = "SELECT `img` FROM `images` WHERE `email` = '$email'";
        $result = $conn->query($image);
        while ($row = $record->fetch_assoc()) {
          $img = $result->fetch_assoc();
          $profileFetched = $img['img'];
          $useNameFetched = $row['user_name'];
          $phoneFetched = $row['phone'];
          $statusFetched = $row['status'];
          $positionFetched = $row['position'];
          $isApproved = $row['is_approved'];
          $isSocialLogin = $row['is_socialLogin'];
        }
        if ($isApproved == true) {
          if ($statusFetched == true) {
            $_SESSION["userName"] = $useNameFetched;
            $_SESSION["position"] = $positionFetched;
            $_SESSION["phone"] = $phoneFetched;
            $_SESSION["email"] = $email;
            if ($isSocialLogin == true) {
              $_SESSION['picture'] = $profileFetched;
            } else {
              $_SESSION['picture'] = "../../public/uploads/" . $profileFetched;
            }
            if ($positionFetched == "admin") {
              header("Location: ../views/Admin/dashbord.php");
            } elseif ($positionFetched == "student") {
              header("Location: ../views/User/homePage.php");
            }
          } else {
            $flag = true;
            throw new Exception("You are currently unable to log in.", 1);
          }
        } else {
          $flag = true;
          throw new Exception("Wait for approval.", 1);
        }
      }
    } catch (Exception $e) {
      $time = "[" . date('Y-m-d h:m:s') . "]";
      $currentPage = $e->getFile();
      $lineNumber = "line " . $e->getLine();
      $message = $e->getMessage() . "\n";

      $error =  $time . " : " . $currentPage . " : " . $lineNumber . ": " . $message;
      $errorFile = fopen("../errors.log", "a") or die("Unable to opane file");
      fwrite($errorFile, $error);
      fclose($errorFile);
      if ($flag == true) {
        $_SESSION['response'] = $e->getMessage();
        header("Location: ../views/auth/loginPage.php");
      }
    }

  }
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <body>
    <form action="../public/uploads/">
  </body>
  </html>