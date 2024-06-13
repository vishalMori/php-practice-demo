<?php
require "../config/dbConnection.php";

try {
  if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    $obj = json_decode(file_get_contents("php://input"), true);
    $id = $obj["id"];
    $isRead = true;

    $update = $conn->prepare("UPDATE `notifications` SET `is_read` = ? WHERE `id` = ?");
    $update->bind_param("ss", $isRead, $id);
    $update->execute();
  }

} catch (Exception $e) {
  echo $e->getMessage();
}
