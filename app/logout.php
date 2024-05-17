<?php

// Starting session to use session variable.
session_start();

// Class to logout.
class Logout {
   /**
    * Constructor method
   */ 
   public function __construct() {
      // If not loggedin, redirect to login page. 
      if (!isset($_SESSION["loggedin"])) {
         header("Location: /");
      }
   }

   /**
    * Function to logout.
    */
   public function loggingout() {
      // Unset session variables and destroy the session.
      session_unset();
      session_destroy();
      // Redirect to login page.
      header('Refresh: 1; URL = /');
   }
}


// Creating object of Logout class.
$lo = new Logout();
$lo->loggingout();
