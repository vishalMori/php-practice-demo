<?php
  require "../config/dbConnection.php";
  require_once "../api/Create.php";
  
  $url = $_SERVER["REQUEST_URI"];
  $endPoint = substr($url, strrpos($url, "/")+1);
  
  $request = $_SERVER['REQUEST_METHOD'];
  
  switch ($endPoint) {
    case "create":
      if ($request == "POST") {
        try {
          $obj = json_decode(file_get_contents('php://input'), true);
          $registration = new Registration($conn);
          $registration->registerUser($obj);
        } catch  (Exception $e) {
          echo $e->getMessage();
          //echo json_encode( array("message" => $e->getMessage()));
        }
      } else {
        http_response_code(405);
      }
      break;
    case "update":
      if ($request == "PUT") {
        $obj = json_decode(file_get_contents('php://input'), true);
      } else {
        http_response_code(405);
      }
      break;
  }