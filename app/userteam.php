<?php
namespace app;

use app\Team;

?>

<!-- Nav bar -->
<html>

<head>
  <link rel="stylesheet" href="../css/home.css">
</head>

<body>
  <div class="navbar">
    <a href="/home">App Name</a>
    <a href="/home">Home</a>
    <a href="/logout">Logout</a>
  </div>
</body>

</html>

<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
  header("LOCATION:/");
}
?>

<html>

<head>
  <title>IPL Dashboard</title>
  <link rel="stylesheet" type="text/css" href="../css/entry.css">
</head>

<body>
  <?php
  //Displaying user team
  $team = new Team();
  $userPlayers = $team->showUserTeam();
  ?>
  <table>
    <tr>
      <th>Employee Id</th>
      <th>Employee Name</th>
      <th>Employee Type</th>
      <th>Employee Points</th>
    </tr>
    <?php
    foreach ($userPlayers as $player) {
      ?>
      <tr>
        <td><?php echo $player['Id'] ?></td>
        <td><?php echo $player['Name'] ?></td>
        <td><?php echo $player['Type'] ?></td>
        <td><?php echo $player['Points'] ?></td>
      </tr>
      <?php
    } ?>
  </table>
</body>

</html>