<?php
   //require "../config/dbConnection.php";

  class Registration
  {
    private $conn;
    //public $conn;
    public function __construct($conn)
    {
      $this->conn = $conn;
    }
    private function ValideInput($value)
    {
      if (!empty($value)) {
        $value = str_replace( array('\'', '"',',' , ';', '<', '>', ' '), '', $value);
        $value = strip_tags($value);
        $value = trim($value);
        $value = htmlspecialchars($value);
        return $value;
      } else {
        throw new Exception("Invalide input", 400); 
      }
    }
    private function ValideEmail($email)
    {
      try {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
      } else {
        throw new Exception("Invalid email format.", 400);
      }
    } catch (Exception $e) {
      throw new Exception("Invalid email formate", 400, $e);
    }
    }
    public function  registerUser($data)
    {
      $name = $this->ValideInput($data['name']);
      $email = $this->ValideEmail($data['email']);
      $insert = "INSERT INTO `test`(`name`, `email`) VALUES ('$name', '$email')";
      $result = $this->conn->query($insert);
      if ($result == true) {
        echo "successfully registered";
      } else {
        echo "Registration fail";
      }
    }
  }