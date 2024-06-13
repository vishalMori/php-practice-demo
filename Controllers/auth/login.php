<?php
  session_start();

  require "../../config/dbConnection.php";
  require "../../vendor/autoload.php";

  class UserLogin
  {
    protected $connection;
    public $flag;
    public function  __construct($connect)
    {
      $this->connection = $connect;
    }

    public function verifyUser($token, $email, $password)
    {
      try {
        $isVerified = true;
        $expDate = date("Y-m-d H:m:s",strtotime("-1 day"));

        $verify = $this->connection->prepare("SELECT `email`, `token`, `date` FROM `emails_verification` WHERE `email` = ?");
        $verify->bind_param("s", $email);
        $verify->execute();
        $result = $verify->get_result()->fetch_assoc();
        //Get users password for verify user
        $usersPassword = $this->connection->prepare("SELECT `password` FROM students WHERE `email` = ?");
        $usersPassword->bind_param("s", $email);
        $usersPassword->execute();
        $userPasswordData = $usersPassword->get_result()->fetch_assoc()["password"];
        if ($result) {
          if ($result["token"] == $token) {
            if (password_verify($password, $userPasswordData)) {
              if ($expDate < $result["date"]) {
                $verifyEmail = $this->connection->prepare("UPDATE `students` SET `verified_email` = ? WHERE `email` = ?");
                $verifyEmail->bind_param("ss", $isVerified, $email);
                $verifyEmail->execute();
                //Delete verification token
                $deleteToken = $this->connection->prepare("DELETE FROM `emails_verification` WHERE `email` = ?");
                $deleteToken->bind_param("s",$email);
                $deleteToken->execute();
                $_SESSION["success"] = "Verification  Successful!";
                return true;
              } else {
                $this->flag = true;
                throw new Exception("Link  Expired! Please Generate a new one.");
              }
            } else {
              $this->flag = true;
              throw new Exception("wrong password");
            }
          } else {
            $this->flag = true;
            throw new Exception('Token is invalid');
          }
        } else {
          $this->flag = true;
          throw new Exception("Link  Expired! Please Generate a new one.");
        }
      } catch (Exception $e) {
        if ($this->flag == true) {
          $_SESSION['response'] = $e->getMessage();
          header("Location: ../../views/auth/loginPage.php");
        }
      }
    }

    public function userLogin($email, $password)
    {
      try {
        //Check if user is exists in the database or not
        $userExists = $this->connection->prepare("SELECT `enrollment`, `name`, `email`, `verified_email`, `password`, `status`,
        `position`, `is_approved` FROM students WHERE `email` = ?");
        $userExists->bind_param("s", $email);
        $userExists->execute();
        $result = $userExists->get_result()->fetch_assoc();
        if ($result) {
          if ($result["verified_email"]) {
            if (password_verify($password, $result["password"])) {
              if ($result["is_approved"]) {
                if ($result["status"]) {
                  //Get user's profile pic
                  $getImage = $this->connection->prepare("SELECT `img` FROM images WHERE email=?");
                  $getImage->bind_param("s", $email);
                  $getImage->execute();
                  $imageData = $getImage->get_result()->fetch_assoc()["img"];
                  //Store user information to session
                  $_SESSION["currentUser"] = array(
                    "enrollment" => $result["enrollment"],
                    "name" => $result["name"],
                    "email" => $result["email"],
                    "position" => $result["position"],
                    "picture" => $imageData
                  );
                  //Redirect user according to position.
                  if ($result["position"] == "admin") {
                    header("Location: ../../views/Admin/dashbord.php");
                  } elseif ($result["position"] == "student") {
                    header("Location: ../../views/User/homePage.php");
                  }
                } else {
                  $this->flag = true;
                  throw new Exception("Your account has been suspended.");
                }
              } else {
                $this->flag = true;
                throw new Exception("Wait for approval.");
              }
            } else {
              $this->flag = true;
              throw new Exception("wrong password");
            }
          } else {
            $this->flag = true;
            throw new Exception("Verify your email before login.");
          }
        } else {
          $this->flag = true;
          throw new Exception("Invalid credentials.");
        }
      } catch (Exception $e) {
        if ($this->flag == true) {
          $_SESSION['response'] = $e->getMessage();
          header("Location: ../../views/auth/loginPage.php");
        }
      }
    }
  }

  $token = $_GET['token'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $login = new UserLogin($conn);

  if (!empty($token)) {
    if ($login->verifyUser($token, $email, $password)) {
      $login->userLogin($email, $password);
    }
  } else {
    $login->userLogin($email,$password);
  }