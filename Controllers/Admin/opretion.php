<?php
  require "../../config/dbConnection.php";
  require "../../vendor/autoload.php";
  require "../../config/mail.php";
  require "../../services/MailServices.php";
  
  $jsonObj = json_decode($_POST['obj'], true);
  
  $opretion = $jsonObj['opretion'];
  $enrollment = $jsonObj['id'];
  $isApprove = true;

  if ($opretion == "approve") {
    $approveRequest = $conn->prepare("UPDATE `students` SET `is_approved` = ? WHERE `enrollment` = ?");
    $approveRequest->bind_param("ss", $isApprove, $enrollment);
    $approveRequest->execute();
    $mail = new MailServices();
    //$mail->approveMail();
  }