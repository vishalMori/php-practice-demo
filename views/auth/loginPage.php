<?php
  session_start();
  
  require "../../config/dbConnection.php";

  if ($_SESSION["currentUser"]["position"] == "student") {
    header('Location: ../User/homePage.php');
  } elseif ($_SESSION["currentUser"]["position"] == "admin") {
    header('Location: ../Admin/dashbord.php');
  }

  $token = $_GET['token'];
?>
<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="icon" type="image/x-icon" href="../../public/images/logo.png">
    <!--Bootstrap v5.0 cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!--JQuery cdn-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!--JQuery validater cdn-->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <!--Tostify-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.js"></script>
    <!--Custome css-->
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <link rel="stylesheet" href="../../public/assets/css/loginPage.css">
</head>

<body>
  <div class="center">
    <img class="logo" src="../../public/images/logo.png">
  </div>
  <div class="container">
    <div class="p-3 mb-2 text-dark center">
      <h3 id="message">Sign in</h3>
    </div>
    <form id="loginForm" action="../../Controllers/auth/login.php<?php if ($token) { echo "?token=" . $token; } ?>" method="post">
      <label for="email" class="form-label">Email address</label>
      <input type="text" id="email" name="email" class="form-control" placeholder="user name or email" required>
      <br>
      <label for="password" class="form-label">Password</label>
      <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
      <br>
      <input type="checkbox" id="rememberMe" name="rememberMe" class="form-check-input">
      <label for="rememberMe" class="form-label">Remember me</label><br>
      Don’t have an account? <a class="btn-link" href="registration.php">Sign up</a><br>
      <a class="btn-link" href="forgotPassword.php">Forgot Password?</a>
      <div class="center">
        <button id="submit" name="" class="btn btn-success">Sign in</button>
      </div>
    </form>
    <form action="../../Middleware/googleLogin.php">
      <div class="center">
        <button class="btn bg-blue">Continue with Google</button>
      </div>
    </form>
  </div>
  <span>
    <?php
      if ($_SESSION['response'] == true) {
        echo "
          <script>
          Toastify({
            text: '".$_SESSION['response']."',
            duration: 7000,
            }).showToast();
          </script>
        ";
      }
      if ($_SESSION['success'] == true) {
        echo "
          <script>
          Toastify({
            text: '".$_SESSION['success']."',
            duration: 7000
            }).showToast();
          </script>
        ";
      }
      $_SESSION['response'] = "";
      $_SESSION['success'] = "";
      ?>
  </span>
  <script src="../../public/assets/js/login.js"></script>
</body>

</html>
