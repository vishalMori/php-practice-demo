<?php
  session_start();
    if (isset($_SESSION['currentUser'])) {
    session_unset();
    session_destroy();
    header('Location: http://localhost/mywork/demoWebsite/views/auth/loginPage.php');
    }