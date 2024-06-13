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
  $email = "morivishal@gmail.com";

  $notifications = $conn->prepare("SELECT * FROM `notifications` WHERE `email` = ?");
  $notifications->bind_param("s", $email);
  $notifications->execute();
  $resultNotifications = $notifications->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifications</title>
  <link rel="icon" type="image/x-icon" href="../../public/images/logo.png">
  <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--Bootstrap icon cdn v1.3.0 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <!--Jquery-->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!--Data table plugin cdn-->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
  <!--Data table-->
  <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
  <!--Custome css-->
  <link rel="stylesheet" href="../../public/assets/css/style.css">
  <link rel="stylesheet" href="../../public/assets/css/navbar.css">
  <link rel="stylesheet" href="../../public/assets/css/notificationPage.css">
</head>
<body>
  <nav>
    <div class="container-md hor-center">
      <img class="logo-image" src = "../../public/images/logo.png">
      <a class="btn btn-light" href="../auth/updateProfile.php?enrollment=<?php echo $enrollment ?>" >Profile</a>
    </div>
    <ul>
      <li>Dashboard</li>
      <li>Services</li>
      <li>About us</li>
      <li><a href="notificationPage.php"><i class="bi bi-bell-fill" style="font-size: 1.5rem;"></i></a></li>
    </ul>
    <form action="../../Controllers/logout.php" method="get">
      <img class="image" src="../../public/uploads/<?php echo $profile; ?>">
      <button type="submit" name="logout" class="btn btn-danger">Logout</button>
    </form>
  </nav>
  <table id="tbl" class="table">
    <thead>
      <tr>
        <th>time</th>
        <th>viewed</th>
        <th>message</th>
      </tr>
    </thead>
    <tbody>
      <?php
        while ($row  = mysqli_fetch_assoc($resultNotifications)) {
          echo  "
          <tr>
            <td>".$row['date']."</td>
            <td>";
              echo ($row['is_read'] == 1) ? "read!" : "<button class='btn btn-success' onclick='markasread(".$row['id'].")'>Mark as read</button>"; echo"
            </td>
            <td>
              <span class='"; echo ($row['is_read'] == 0) ? "bold": ""; echo "'>". $row['message']."</span>
            </td>
          </tr>
          ";
        }
      ?>
    </tbody>
  </table>
  <script>
    $("#tbl").DataTable({
      "searching": false,
      "columnDefs": [
        { "orderable": false, "targets": [0, 2] },
        { width: '10%', targets: [0, 1] }
    ],
    "paging": false
    });
  </script>
  <script src="../../public/assets/javascript/notification.js"></script>
</body>
</html>
