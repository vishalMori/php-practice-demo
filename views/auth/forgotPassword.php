<?php
  require "../../config/dbConnection.php";
  require "../../vendor/autoload.php";
  require "../../config/mail.php";
  require "../../services/MailServices.php";
  require "../../utility/validation.php";

  try {
    if (isset($_POST["btnSendMail"])) {
      $email;
      $error;
      $url = "http://localhost/mywork/demoWebsite/views/auth/resetPassword.php?tocken=";
      if (emailValidate(($_POST['email'])) == 1) {
        $email = $_POST['email'];
        $token = uniqid();
        $query = $conn->prepare("SELECT `email` FROM `students` WHERE `email` = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
          $insertToken = $conn->prepare("INSERT INTO `reset_passwords`(`email`, `password_token`) VALUES (?, ?)");
          $insertToken->bind_param("ss", $email, $token);
          if ($insertToken->execute() === true) {
            $mail = new MailServices();
            //$mail->resetPasswordMail($url, $token);
          }
        }
      } else {
        $error = "invalid email formate";
      }
    }

  }catch (Exception $e) {
    echo $e->getMessage();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset password</title>
  <!--Bootstrap v5.0 cdn-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--Custome css-->
    <link rel="stylesheet" href="../../public/assets/css/forgotPassword.css">
  </head>
  
  <body>
    <div class="container">
      <form id="form" method="post">
      <h2 class="text-muted center">Reset your password</h2>
      <h3><?php echo $error; ?></h3>
      <br>
      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" name="email" class="form-control" placeholder="example@mail.com" required>
      <br>
      <a class="center btn text" href="loginPage.php">Back to Sign in?</a>
      <div class="center">
        <button type="submit" class="btn btn-success" name="btnSendMail">Submit</button>
      </div>
      <br>
    </form>
  </div>

  <!--JQuery-->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!--JQuery validater-->
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
</body>

</html>