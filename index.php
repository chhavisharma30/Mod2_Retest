<?php

// Autoloading class files in the code
require __DIR__ . '/vendor/autoload.php';

// Getting the requested URI
$requestUri = $_SERVER['REQUEST_URI'];
// Defining routes and corresponding PHP files
$routes = [
  '/' => 'login.php',
  '/register' => 'register.php',
  '/home' => 'home.php',
  '/logout' => 'logout.php',
  '/registration' => 'Register.php',
  '/authenticate' => 'Login.php',
  '/player' => 'Player.php',
  '/team' => 'Team.php',
  '/userTeam' => 'userteam.php'
];

if (array_key_exists($requestUri, $routes)) {
  // Get the corresponding PHP file for the route
  $targetPhpFile = $routes[$requestUri];
  // Include the corresponding PHP file
  require (__DIR__ . "/app/$targetPhpFile");
} else {
  // If route not found, check if it contains query parameters
  $routeParts = explode('?', $requestUri, 2);
  $route = $routeParts[0];
  if (array_key_exists($route, $routes)) {
    // Get the corresponding PHP file for the route
    $targetPhpFile = $routes[$route];
    // Include the corresponding PHP file
    require (__DIR__ . "/app/$targetPhpFile");
  } else {
    // If route not found, return 404 error or handle accordingly
    echo '<h1>404 - Not Found</h1>';
  }
}