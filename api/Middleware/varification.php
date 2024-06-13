<?php
  require "../../vendor/autoload.php";

  use Firebase\JWT\JWT;
  use Firebase\JWT\Key;

  $key = "5a64dsfg5sd46f156d41";
  $request;
  $obj;

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $obj = json_decode(file_get_contents("php://input"), true);
    $request = $obj['request'];

  } elseif ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    $obj = json_decode(file_get_contents("php://input"), true);
    $request = "delete";
  }

  $header = apache_request_headers();
  $jwt = explode(" ", $header['Authorization'])[1];
  $decode = JWT::decode($jwt, new Key($key, "HS256"));

  if ($decode->exp > time()) {
    if ($request == "select") { 
      header("Location: http://localhost/mywork/demoWebsite/api/selectData.php");
    } elseif ($request == "delete") {
      $email = $obj['email'];
      $url ="http://localhost/mywork/demoWebsite/api/deleteData.php?email=" . $email;
      header("Location: $url");
    }
  } else {
    echo "expired";
  }
