<?php
  session_start();
  require "../../Middleware/isLoginDone.php";
  require "../../config/dbConnection.php";

  if ($_SESSION["currentUser"]["position"] == "admin") {
    header("Location: ../Admin/dashbord.php");
  }
  
  $enrollment = $_SESSION["currentUser"]["enrollment"];
  $name = $_SESSION["currentUser"]["name"];
  $profile = $_SESSION["currentUser"]["picture"];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="icon" type="image/x-icon" href="../../public/images/logo.png">
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--Bootstrap icon cdn v1.3.0 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!--Custome css-->
    <link rel="stylesheet" href="../../public/assets/css/navbar.css">
    <link rel="stylesheet" href="../../public/assets/css/style.css">
  </head>

<body>
  <nav>
    <div class="container-md hor-center">
      <img class="logo-image" src = "../../public/images/logo.png">
    </div>
    <ul>
      <li>Dashboard</li>
      <li>Services</li>
      <li>About us</li>
      <li><a href="notificationPage.php"><i class="bi bi-bell-fill" style="font-size: 1.5rem;"></i></a></li>
    </ul>
    <div>
      <a class="" href="../auth/updateProfile.php?enrollment=<?php echo $enrollment ?>" ><img class="image" src="../../public/uploads/<?php echo $profile; ?>"></a>
    </div>
    <div>
      <a href="../../Controllers/logout.php" class="btn btn-danger"><i class="bi bi-power"></i>Logout</a>
    </div>
  </nav>

  <h3 class="">Hello <?php echo $name ?></h3>
  <script>
    function updateProfile()
    {
      window.location.href = "../auth/updateProfile.php?enrollment=" + id;
    }
    function visibility()
    {
      let div = document.getElementById("container");
      if (div.style.display === "none") {
        div.style.display = "block";
      } else {
        div.style.display = "none";
      }
    }
  </script>
</body>

</html>