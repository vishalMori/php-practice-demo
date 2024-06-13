<?php
  require "../../config/dbConnection.php";
  require "../../Middleware/isAdmin.php";
  require "../../config/mail.php";
  require "../../vendor/autoload.php";
  require "../../services/MailServices.php";

  try {
    if (isset($_POST['btnBrodcast'])) {
      $message = $_POST['brodcastMessage'];
      for ($i = 1; $i <= count($_POST['recipient']); $i++) {
        $mail = new MailServices();
        //$mail->brodcastMail($message);
      }
    }
  
    if (isset($_POST["btnMessage"])) {
      for ($i = 0; $i <= count($_POST['recipient']); $i++) {
        $email = $_POST['recipient'][$i];
        $message = $_POST['brodcastMessage'];
        $setNotification = $conn->prepare("INSERT INTO `notifications` (`email`, `message`) VALUES ( ?, ?)");
        $setNotification->bind_param("ss", $email, $message);
      }
    }
    
  } catch (Exception $e) {
    echo $e->getMessage();
    echo $e->getLine();
  }
  $email = $_SESSION['currentUser']["email"];
  $profileImage = $_SESSION["currentUser"]["picture"];
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brodcast</title>
  <link rel="icon" type="image/x-icon" href="../../public/images/logo.png">
  <!--Bootstrap v5.2.3-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <!--Bootstrap icon cdn v1.3.0 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <!--Jquery cdn-->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!--JQuery validater-->
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <!--Select2 cdn -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!--Sweetalert2 cdn-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!--Custome css -->
  <link rel="stylesheet" href="../../public/assets/css/nav.css">
  <link rel="stylesheet" href="../../public/assets/css/sidebar.css">
  <link rel="stylesheet" href="../../public/assets/css/style.css">
  <link rel="stylesheet" href="../../public/assets/css/brodcastPage.css">
</head>
<body>
  <?php include "../layout/navbar.php" ?>
  <div class="content">
    <?php include "../layout/sidebar.php" ?>

    <div class="container sm-container">
      <div class="center bg-dark text-white">
        <h3>Brodcast</h3>
      </div>
      <form id="broadcastForm" method="post">
        <label id="brodcast-dropdown">Recipient:</label><br>
        <select id="brodcast-dropdown" class="brodcast js-example-basic-multiple" name="recipient[]" multiple="multiple" style="width: 100%;" required>
        </select>
        <br>
        <br>
        <label for="message-text" class="col-form-label">Message:</label>
        <textarea name="brodcastMessage" class="form-control" id="message-text" required></textarea>

        <div class="center">
          <button name="btnBrodcast" class="btn btn-success">Send Mail</button>
          <button name="btnMessage" class="btn btn-success">Send Message</button>
        </div>
      </form>
    </div>

  </div>
  

  <script src="../../public/assets/js/selectRecord.js"></script>
  <script>
    //This is for brodcast
    $(document).ready(function() {
      $(".js-example-basic-multiple").select2({ maximumSelectionSize: 5});
      $("#broadcastForm").validate({
        rules: {
          "recipient[]":{
            required: true
          }
        },
        messages: {
          "recipient[]": {
            required: "Please select at least one user"
          },
          "brodcastMessage": {
            required: "Write message for user.",
          }
        }
      })
    });
  </script>
</body>
</html>