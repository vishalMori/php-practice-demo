<?php
  require "../../config/googleLogin.php";
  session_start();
  $_SESSION['gmail'] = $client->getScopes("email");
  header("Location: http://localhost/mywork/demoWebsite/views/User/homePage.php");