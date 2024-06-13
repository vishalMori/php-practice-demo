<?php
  require "../vendor/autoload.php";
  require "../config/dbConnection.php";
  require "../utility/validation.php";

  use Firebase\JWT\JWT;
  use Firebase\JWT\Key;
  $result;
  $key = "5a64dsfg5sd46f156d41";

  $header = apache_request_headers();
  $jwt = explode(" ", $header['Authorization'])[1];
  $decode = JWT::decode($jwt, new Key($key, "HS256"));
  if ($decode->exp > time()) {
    if ($_SERVER['REQUEST_METHOD'] == "PUT") {
      $obj = json_decode(file_get_contents("php://input"), true);
      $email = $obj['email'];
      $phone = $obj['phone'];
      if (emailValidate($email) == 1) {
        if (strlen($phone) == 10) {
          $update = $conn->prepare("UPDATE `students` SET `phone` = ? WHERE `email` = ?");
          $update->bind_param('ss', $phone, $email);
          $result = $update->execute();
          http_response_code(200);
          $responce = "Successfully updated";
        } else {
          http_response_code(400);
          $responce = "Phone number must be 10 digit";
        }
      } else {
        http_response_code(400);
        $responce = "Invalid email formate";
      }
    } else {
      http_response_code(405);
      $responce = "Invalide request";
    }
  }
  echo json_encode($responce);
