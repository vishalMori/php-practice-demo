<?php
  session_start();
  if ($_SESSION['currentUser']["position"] == "student" && isset($_SESSION['currentUser'])) {
    header('Location: ../User/homePage.php');
  } elseif (!isset($_SESSION['currentUser'])) {
    header('Location: ../auth/loginPage.php');
  }
  