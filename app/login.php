<?php

// Starting session for using session variables.
session_start();

// If session is already logged in then redirect to homepage.
if (isset($_SESSION["loggedin"])) {
  header("LOCATION:/home");
}

?>
<html>

<head>
  <title>Login page</title>
  <link rel="stylesheet" href="../css/login.css">
</head>

<body>

  <h2>Enter Username and Password</h2>


  <form action="/authenticate" method="post">
    <label for="email">Email: </label>
    <input type="text" name="email" required autofocus></br>
    <label for="password">Password: </label>
    <input type="password" name="password" required></br>
    <button type="submit" name="login">Login</button><br><br>
  </form>

  <!-- <br><a href="/register">Register</a> -->

</body>

</html>
