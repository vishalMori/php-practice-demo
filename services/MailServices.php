<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  class MailServices
  {
    public function verificationMail($token)
    {
      //Server settings
      $phpmailer = new PHPMailer();
      $phpmailer->isSMTP();
      $phpmailer->Host = host;
      $phpmailer->SMTPAuth = smtpauth;
      $phpmailer->Port = port;
      $phpmailer->Username = userName;
      $phpmailer->Password = password;

      //Recipients
      $phpmailer->setFrom('vishal@krishaweb.com', 'Mailer');
      $phpmailer->addAddress('vishal@krishaweb.com', 'Joe User');

      //Content
      $phpmailer->isHTML(true);
      $phpmailer->Subject = 'Here is the subject';
      $phpmailer->Body    = "Click on button and login again<br> <button><a href=
      'http://localhost/mywork/demoWebsite/views/auth/loginPage.php?token=$token'>Verify</a></button>";
      $phpmailer->AltBody = 'This is the body in plain text for non-HTML mail clients';
      $phpmailer->send();
    }

    public function approveMail()
    {
      //Server settings
      $phpmailer = new PHPMailer();
      $phpmailer->isSMTP();
      $phpmailer->Host = host;
      $phpmailer->SMTPAuth = smtpauth;
      $phpmailer->Port = port;
      $phpmailer->Username = userName;
      $phpmailer->Password = password;

      //Recipients
      $phpmailer->setFrom('vishal@krishaweb.com', 'Mailer');
      $phpmailer->addAddress('vishal@krishaweb.com', 'Joe User');

      //Content
      $phpmailer->isHTML(true);
      $phpmailer->Subject = 'Here is the subject';
      $phpmailer->Body    = "Your are approved.";
      $phpmailer->AltBody = 'This is the body in plain text for non-HTML mail clients';
      $phpmailer->send();
    }

    public function brodcastMail($message)
    {
    $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = host;
    $phpmailer->SMTPAuth = smtpauth;
    $phpmailer->Port = port;
    $phpmailer->Username = userName;
    $phpmailer->Password = password;

    //Recipients
    $phpmailer->setFrom('vishal@krishaweb.com', 'Mailer');
    $phpmailer->addAddress('vishal@krishaweb.com', 'Joe User');

    //Content
    $phpmailer->isHTML(true);
    $phpmailer->Subject = 'Here is the subject';
    $phpmailer->Body    = "<h2>This is brodcast Mail<h2><br>" . $message;
    $phpmailer->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $phpmailer->send();
    }

    public function resetPasswordMail($url, $string)
    {
      $link = $url . $string;
      //Server settings
      $phpmailer = new PHPMailer();
      $phpmailer->isSMTP();
      $phpmailer->Host = host;
      $phpmailer->SMTPAuth = smtpauth;
      $phpmailer->Port = port;
      $phpmailer->Username = userName;
      $phpmailer->Password = password;
      //Recipients
      $phpmailer->setFrom('vishal@krishaweb.com', 'Mailer');
      $phpmailer->addAddress('vishal@krishaweb.com', 'Joe User');
      //Content
      $phpmailer->isHTML(true);
      $phpmailer->Subject = 'Here is the subject';
      $phpmailer->Body    = "Click on button and login again<br> <button><a href='$link'>Verify</a></button>";
      $phpmailer->AltBody = 'This is the body in plain text for non-HTML mail clients';
      $phpmailer->send();
    }
  }