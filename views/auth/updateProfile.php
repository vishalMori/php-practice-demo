<?php
  session_start();
  require "../../config/dbConnection.php";
  require "../../Middleware/isLoginDone.php";

  $isSocialLogin;
  $email;
  $enrollment = $_GET["enrollment"];

  $hobby = "SELECT * FROM `hobbys`";
  $hobbySelected = $conn->query($hobby);
  
  $selectRecord = $conn->prepare("SELECT `name`, `surname`, `email`, `phone`, `gender`, `is_socialLogin` FROM `students` WHERE `enrollment` = ?");
  $selectRecord->bind_param("s", $enrollment);
  $selectRecord->execute();
  $result = $selectRecord->get_result()->fetch_assoc();
  $isSocialLogin = $result['is_socialLogin'];
  $email = $_SESSION['updateRequestEmail'] = $result['email'];

  $image = $conn->prepare("SELECT `img` FROM `images` WHERE `email` = ?");
  $image->bind_param("s", $email);
  $image->execute();
  $imageResult = $image->get_result()->fetch_assoc();
  $profile =  "../../public/uploads/" . $imageResult['img'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!--Bootstrap v5.0-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--Custome css-->
  <link rel="stylesheet" href="../../public/assets/css/style.css">
  <link rel="stylesheet" href="../../public/assets/css/updatePage.css">
</head>
<body>
  <div class="container" id="container">
    <div class="p-3 mb-2 text-dark center">
      <h3>Update Profile</h3>
    </div>
    <div class="center">
      <img class="profile" src="<?php echo $profile; ?>" alt="profile pic">
    </div>
    <h6><span class="error">*</span> required field</h6>
    <form id="userInput" action="../../Controllers/Update.php" method="post" enctype="multipart/form-data">
      <label for="enrollment" class="form-label">Enrollment</label><br>
      <input type="text" id="enrollment" name="enrollment" class="form-control" value="<?php echo $enrollment; ?>" placeholder="Name" readonly>
      <br>
      <label for="name" class="form-label">Name  <span class="error">*</span> </label><br>
      <input type="text" id="name" name="name" class="form-control" value="<?php echo $result['name']; ?>" placeholder="Name" required>
      <br>
      <label for="surname" class="form-label">Surname <span class="error">*</span> </label>
      <input type="text" id="surname" name="surname" class="form-control" value="<?php echo $result['surname']; ?>" placeholder="surname" required>
      <br>
      <label for="phoneNumber" class="form-label">Phone Number <span class="error">*</span> </label>
      <input type="text" id="phoneNumber" name="phone" class="form-control" value="<?php echo $result['phone']; ?>" placeholder="93xxxxxxxx" required>
      <br>
      <label for="uploadFile" class="form-label">Upload File</label>
      <input type="file" id="profile" name="profile" class="form-control">
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
      <br>
      <label class="form-label">Choose gender <span class="error">*</span> </label><br>
      <input type="radio" id="male" class="form-check-input" name="gender" value="male" <?php echo ($result['gender']) == "male" ? "checked" : ""; ?>>
      <label for="male" class="form-label">Male</label>

      <input type="radio" id="female" class="form-check-input" name="gender" value="female" <?php echo ($result['gender']) == "female" ? "checked" : ""; ?>>
      <label for="female" class="form-label">Female</label>
      <br><br>
      <div class="center">
        <button type="submit" name="btnupdate" class="btn btn-lg btn-success">Submit</button>
        <button class="btn btn-danger">cancel</button>
      </div>
    </form>
  </div>
  <!--<script src="../../public/assets/js/opretions.js"></script>-->
</body>
</html>