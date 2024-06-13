<?php
  session_start();

  include "../vendor/autoload.php";
  require "../config/dbConnection.php";

  use Firebase\JWT\JWT;
  use Firebase\JWT\Key;

  $email;
  $password;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $obj = json_decode(file_get_contents("php://input"), true);
    $email = $obj['email'];
    $password = md5($obj['password']);
  }
  $isVerified = true;
  $flag = false;

  //Variable for data retived from database
  $dateFetched;
  $emailFetched;
  $passwordFetched;
  $expDate;
  $key = "5a64dsfg5sd46f156d41";
  
  try {
    if(!empty($token)) {
      $query = "SELECT `email`, `date` FROM `emails_verification` WHERE `token` = '$token'";
      $getRecord = $conn->query($query);
  
      if ($getRecord->num_rows > 0) {
        $fetchPassword = "SELECT `password` FROM `students` WHERE `email` = '$email'";
        $result = $conn->query($fetchPassword);
        while ($row = $getRecord->fetch_assoc()) {
          $pass = $result->fetch_assoc();
          $passwordFetched = $pass['password'];
          $emailFetched = $row['email'];
          $dateFetched = $row['date'];
        }

        $expDate = date("Y-m-d H:m:s",strtotime("-1 day"));
        if ($expDate < $dateFetched) {
        }
        if ($expDate < $dateFetched) {
          if ($email == $emailFetched) {
            if ($password == $passwordFetched) {
              $verifyQuery = "UPDATE `students` SET `verified_email` = '$isVerified' WHERE `email` = '$email'";
              $verified = $conn->query($verifyQuery);
              $deleteToken = "DELETE FROM `emails_verification` WHERE `email` = '$emailFetched'";
              $deleted = $conn->query($deleteToken);
              if ($verified && $deleted) {
                $_SESSION['response'] = "verification complate";
                goto success;
              } else {
                throw new Exception("Query not executed", 1);
                header("Location: ../../views/auth/loginPage.php");
              }
            } else {
              $flag = true;
              http_response_code(400);
              throw new Exception("Wrong password.", 1);
            }
          } else {
            $flag = true;
            throw new Exception("Invalid credentials.", 1);
          }
        } else {
          $flag = true;
          throw new Exception("Link expired", 1);
        }
        
      } else {
        $flag = true;
        throw new Exception("Link expired", 1);
      }

    } else {
      success:
      $useNameFetched;
      $isVerifiedFetched;
      $phoneFetched;
      $statusFetched;
      $positionFetched;
      $isApproved;
      $profile;
      $isSocialLogin;
      
      $isExist = "SELECT `email` FROM `students` WHERE `email` = '$email'";
      $selectedResult = $conn->query($isExist);
      $profileImag = "SELECT `img` FROM `images` WHERE `email` = '$email'";
      $selectedImage = $conn->query($profileImag);

      if ($selectedResult->num_rows > 0) {
        $user = "SELECT `user_name`, `verified_email`, `password`, `status`, `position`, `is_approved`, `is_socialLogin` FROM `students` WHERE `email` = '$email'";
        $record = $conn->query($user);
        if ($record == true) {
          while ($row = $record->fetch_assoc()) {
            $imag = $selectedImage->fetch_assoc();

            $profile = $imag['img'];  
            $useNameFetched = $row['user_name'];
            $isVerifiedFetched = $row['verified_email'];
            $phoneFetched = $row['phone'];
            $passwordFetched = $row['password'];
            $statusFetched = $row['status'];
            $positionFetched = $row['position'];
            $isApproved = $row['is_approved'];
            $isSocialLogin = $row['is_socialLogin'];

          }
          if ($isVerifiedFetched == true) {
            if($passwordFetched == $password) {
              if ($isApproved == true) {
                if ($statusFetched == true) {
                  if ($isSocialLogin == true) {
                    $_SESSION["picture"] = $profile;
                  } else {
                    $_SESSION["picture"] = "../../public/uploads/" . $profile;
                  }
                  
                  $payload = [
                    "exp" => time() + 3600,
                    "data" => [
                      "id" => "5641sadf41",
                      "position" => "$positionFetched",
                      "name" => "$useNameFetched",
                    ]
                    
                  ];
                  header("Content-Type: aplication/json");
                  echo json_encode([
                    "status" => "sucess",
                    "token" => $jwt = JWT::encode($payload, $key, "HS256"),
                  ]);
                  
                } else {
                  $flag = true;
                  throw new Exception("You are currently unable to log in.", 1);
                }
              } else {
                $flag = true;
                throw new Exception("Wait for approval.", 1);
              }
            } else {
              $flag = true;
              throw new Exception("Wrong password.", 1);
            }
          } else {
            $flag = true;
              throw new Exception("Verify your email before login.", 1);
            }
        } else {
          throw new Exception("Query not executed.", 1);
        }

      } else {
        $flag = true;
        throw new Exception("Invalid credentials.", 1);
      }
    }
  } catch (Exception $e) {
    $message = $e->getMessage();
    echo json_encode($message);
  }