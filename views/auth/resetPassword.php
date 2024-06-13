<?php
  require "../../config/dbConnection.php";
  $tocken = $_GET['tocken'];

  if (isset($_POST['btnReset'])) {
    $tockenFetched;
    $email;
    $password = md5($_POST['password']);
    $sql = "SELECT `email`, `password_token` FROM `reset_passwords` WHERE `password_token` = '$tocken'";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $tockenFetched = $row['password_token'];
        $email = $row['email'];
      }
      if ($tocken === $tockenFetched) {
        echo $tockenFetched, $email;
        $update = "UPDATE `students` SET `password`='$password' WHERE `email` = '$email'";
        $delete = "DELETE FROM `reset_passwords` WHERE `email` = '$email'";
        if ($connection->multi_query($update . ";" . $delete)) {
          echo "reset complet";
        }
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--Custome css-->
  <link rel="stylesheet" href="../../public/assets/css/style.css">
</head>
<body>
  <div class="container">
    <form method="post">
      <h2 class="center">New password</h2>
      <label for="password" class="form-label">password</label>
      <input type="password" id="password" name="password" class="form-control" required>
      <br>
      <label for="conPassword" class="form-label">Confirm password</label>
      <input type="password" id="conPassword" name="conPassword" class="form-control" required>
      <br>
      <div class="center">
        <button class="btn btn-primary" name="btnReset">Change password</button>
      </div>
      <br>
    </form>
  </div>
</body>
</html>