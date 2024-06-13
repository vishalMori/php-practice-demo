<?php
  session_start();
  require "../../config/dbConnection.php";
  
  $hobby = "SELECT * FROM `hobbys`";
  $hobbySelected = $conn->query($hobby);
  $grade = "SELECT * FROM `grades`";
  $gradeSelected = $conn->query($grade);
  ?>

<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../../public/images/logo.png">
  <!--Bootstrap cdn-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--JQuery cdn-->
  <link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css”>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!--JQuery validater-->
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <!--Toastify cdn-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.js"></script>
  <!--Custome css-->
  <link rel="stylesheet" href="../../public/assets/css/style.css">
  <style>
    .content {
      justify-content: space-between;
    }
  </style>
</head>

<body>
  <div class="center">
    <img class="logo" src="../../public/images/logo.png">
    <div>
      <a class="btn btn-success" href ="loginPage.php">Sign in</a>
    </div>
  </div>
  <div class="container">
    <div class="p-3 mb-2 text-dark center">
      <h3>Sign up</h3>
    </div>
    <h6><span class="error">*</span> required field</h6>
    <form id="userInput" action="../../Controllers/Users/registration.php" method="post" enctype="multipart/form-data">
      <label for="name" class="form-label">Name <span class="error">*</span> </label><br>
      <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
      <br>
      <label for="surname" class="form-label">Surname <span class="error">*</span> </label>
      <input type="text" id="surname" name="surname" class="form-control" placeholder="surname" required>
      <br>
      <label for="email" class="form-label">Email <span class="error">*</span> </label>
      <input type="email" id="email" name="email" class="form-control" placeholder="example@mail.com" required>
      <br>
      <label for="password" class="form-label">password <span class="error">*</span> </label>
      <input type="password" id="password" name="password" class="form-control" required>
      <br>
      <label for="conPassword" class="form-label">Confirm password <span class="error">*</span> </label>
      <input type="password" id="conPassword" name="conPassword" class="form-control" required>
      <br>
      <label for="phoneNumber" class="form-label">Phone Number <span class="error">*</span> </label>
      <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="93xxxxxxxx" required>
      <br>
      <label for="uploadFile" class="form-label">Upload File</label>
      <input type="file" id="uploadFile" name="file" class="form-control" required>
      <br>
      <label class="form-label">Choose gender <span class="error">*</span> </label><br>
      <input type="radio" id="male" class="form-check-input" name="gender" value="male" checked>
      <label for="male" class="form-label">Male</label>

      <input type="radio" id="female" class="form-check-input" name="gender" value="female">
      <label for="female" class="form-label">Female</label>
      <br><br>
      
      <label>Select Grade</label><br>
      <select name="grade" class="form-select">
      <?php
        while ($row = $gradeSelected->fetch_assoc()) {
          echo '
            <option>' .$row['grade']. '</option>
            ';
          }
      ?>
      </select>
      <br>
      
      <p>Select Hobby</p>
      <?php
        while ($row = $hobbySelected->fetch_assoc()) {
          echo '
          <input type="checkbox" name="hoby[]" class="form-check-input" value="' .$row['hobby']. '" id="checkbox">
          <label class="form-check-label" for="checkbox">'.$row['hobby'].'</label>
          <br>
          ';
        }
        ?>
    <div class="center">
      <button type="submit" name="btnSubmit" onclick="" class="btn btn-lg btn-success">Sign up</button>
    </div>
    </form>
  </div>
  
  <?php
    if ($_SESSION['response'] == true) {
      echo "<script>
        Toastify({
          text: '".$_SESSION['response']."',
          duration: 7000
        }).showToast();
      </script>";
      $_SESSION['response'] = "";
    }
    ?>
  <!--Custom js-->
  <script src="../../public/assets/js/validation.js"></script>
</body>

</html>