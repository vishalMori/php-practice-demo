<?php
  require "../../Middleware/isAdmin.php";
  require "../../config/dbConnection.php";

  $response = "";
  $email = $_SESSION['email'];
  $profileImage = $_SESSION["currentUser"]["picture"];

  try {
    $selectRecord = "SELECT `enrollment`, `user_name`, `name`, `email`, `verified_email`, `phone`, `status`, `position`, `is_approved`, `register_date`, `is_socialLogin` FROM `students`";
    $result = $conn->query($selectRecord);
    $selectImage = "SELECT `img` FROM `images`";
    $selectedImage = $conn->query($selectImage);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users List</title>
  <link rel="icon" type="image/x-icon" href="../../public/images/logo.png">
  <!--Bootstrap v5.0-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--Bootstrap icon cdn v1.3.0 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <!--Tostyfy cdn-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.css">
  <!--Jquery-->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!--Sweetalert2 cdn-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!--Data table plugin cdn-->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
  <!--Data table-->
  <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
  <!--Tostyfy-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.js"></script>
  <!--Custome css-->
  <link rel="stylesheet" href="../../public/assets/css/nav.css">
  <link rel="stylesheet" href="../../public/assets/css/sidebar.css">
  <link rel="stylesheet" href="../../public/assets/css/userList.css">
</head>

<body>
  <?php include "../layout/navbar.php" ?>
  
  <div class="con-1">
    <?php include "../layout/sidebar.php" ?>

    <div class="con-2">

      <div class="con-3">
        <form action="../../Controllers/Admin/exportData.php">
          <button class="btn btn-dark">Export</button>
        </form>
        <form action="../../Controllers/Admin/generatePdf.php">
          <button class="btn btn-dark">Generate PDF</button>
        </form>
        <button class="btn btn-dark">Back</button>
      </div>
      <div class="con-4">
        <table id="tbl" class="table">
          <thead>
            <tr>
              <td>Profile</td>
              <td>User Name</td>
              <td>Name</td>
              <td>Email</td>
              <td>Email verified ?</td>
              <td>Phone Number</td>
              <td>Active / Deactive</td>
              <td>is Approved</td>
              <td>registrated Date</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody name="n">
            <?php
              while ($row = $result->fetch_assoc()) {
                $profile = $selectedImage->fetch_assoc();
                if ($row['position'] == "admin") continue;
                echo '
                <tr>
                <td>
                  <img class="profile" src="../../public/uploads/' . $profile['img'].'">
                </td>
                <td>'.$row["user_name"].'</td>
                <td>'.$row["name"].'</td>
                <td>'.$row["email"].'</td>
                    <td>';
                      echo ($row["verified_email"] == 1) ? "verified" : "not verified";
                      echo '
                      </td>
                      <td>'.$row["phone"].'</td>
                      <td>
                      <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" onchange="permissionConfirmation(this.value,' .$row['enrollment']. ')" value = "' . $row['status'] . '"';
                        if ($row['status'] == 1) {echo "checked";}
                        echo '>
                      </div>
                    </td>
                    <td>';
                      echo ($row['is_approved'] == 1) ? "Approved!" : '<button class="btn btn-success" onclick="approveUser(' . $row['enrollment'] . ')">Approve</button>';
                      echo "
                    </td>
                    <td>".$row['register_date']."</td>
                    <td>
                      <select class='form-select' onchange='action(this.value, " . $row['enrollment'] .",`" . $row['email'] . "`)'>
                        <option>Action</option>
                        <option>Delete</option>
                        <option>Update</option>
                      </select>
                    </td>
                  </tr>
                ";
              }
              ?>
          </tbody>
        </table>
      </div>
      
    </div>

  </div>

  
  <?php
    } catch (Exception $e) {
      $response = $e->getMessage();
    } finally {
      echo $response;
      $conn->close();
    }
    ?>
  <script src="../../public/assets/javascript/opretion.js"></script>
  <script>
    function action(selected, id, email)
    {
      switch (selected) {
        case "Delete":
          deleteConfirmation(id, email);
          break;
          case "Update":
            window.location.href = "../auth/updateProfile.php?enrollment=" + id;
          break;
      }
    }

    let dtable = new DataTable('#tbl');
    dtable.searching = true;

    function permissionConfirmation(status, id)
    {
      let text;
      if (status == 1) {
        text = "deactivate";
      } else {
        text = "activate";
      };
      Swal.fire({
        title: `Are you sure to ${text} the user?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
      }).then((result) => {
        if (result.isConfirmed) {
          permission(status, id)
        }
      });
    }

    function deleteConfirmation(id, email)
    {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete user!"
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: "Deleted!",
            text: "User Deleted.",
            icon: "success"
          });
          deleteStudent(id, email);
        }
      });
    }
    $("a").click(function() {  
  //remove all active class from a elements
  $(this).addClass("active");      //add the class to the clicked element
});
    </script>
    <!--Custome js-->
    <script src="../../public/assets/javascript/opretion.js"></script>
</body>

</html>