<?php
  require "../config/dbConnection.php";
  require "../vendor/autoload.php";
  
  header("Content-Type: application/json");
  
  use Firebase\JWT\JWT;
  use Firebase\JWT\Key;

  $key = "5a64dsfg5sd46f156d41";
  $responce;
  $array = [];

  if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $header = apache_request_headers();
    $jwt = explode(" ", $header['Authorization'])[1];
    $decode = JWT::decode($jwt, new Key($key, "HS256"));

    $position = $decode->data->position;
    if ($position == "admin") {
      $select = "SELECT * FROM `students`";
      $result = $conn->query($select);
      while ($row = $result->fetch_assoc()) {
        $array[] = $row;
      }
      echo json_encode([$responce, $array]);
    } else {
      http_response_code(401);
      $responce = "Unauthorized user";
    }
  } else {
    http_response_code(405);
  }
  echo json_encode($responce);