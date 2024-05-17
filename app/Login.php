<?php

namespace app;

use app\Connection;

// Starting a PHP session for using session variables.
session_start();

// Authentication class definition.
class Login {
  public $db_conn;

  /**
   * Constructor method
   */ 
  public function __construct() {
    // Establishing a database connection
    $conn = new Connection();
    $this->db_conn = $conn->connect();
  }

  /**
   * Method to authenticate user.
   * 
   * @throws \Exception
   *  If error occurs.
   */
  public function authenticate() {
    // Checking if form data is submitted.
    if (isset($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])) {
      $email = $_POST['email'];
      $pw = md5($_POST['password']);

      // Query to check if username and password match.
      $sql = "SELECT Role FROM credentials_table WHERE Email ='$email' AND Password = '$pw'";
      $result = mysqli_query($this->db_conn, $sql);

      // If a row is returned, credentials are correct.
      if (mysqli_num_rows($result)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header("LOCATION: /home");
      } else {
        // Showing error message and redirecting back to login page if authentication fails.
        echo '<script>alert("Wrong email or password!")</script>';
        echo "<script>window.location.href='/';</script>";
      }
    } else {
      // Showing error message if empty cells.
      echo '<script>alert("Please enter email and password!")</script>';
    }
  }
}

// Creating object of Login class.
$login = new Login();

if (isset($_POST['login'])) {
  $login->authenticate();
}
