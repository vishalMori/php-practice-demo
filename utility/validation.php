<?php

class Validater
{
  public function ValideInput($value)
  {
    if (!empty($value)) {
      $value = strip_tags($value);
      $value = str_replace( array('\'', '"',',' , ';', '<', '>', ' '), '', $value);
      $value = trim($value);
      $value = htmlspecialchars($value);
      return $value;
    } else {
      throw new Exception("Invalide input", 1);
    }
  }
}
  // This function validate email address
  function emailValidate($email) {
    $status = preg_match( "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
    return $status;
  }

  // This function use for validate value
  function valideValue($value) {
    $value = strip_tags($value);
    $value = str_replace( array('\'', '"',',' , ';', '<', '>', ' '), '', $value);
    $value = trim($value);
    $value = htmlspecialchars($value);
    return $value;
  }