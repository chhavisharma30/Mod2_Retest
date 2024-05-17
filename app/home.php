<?php
namespace app;

use app\Player;

//Starting session for use of session variables
session_start();
?>

<!-- Nav bar -->
<html>

<head>
  <link rel="stylesheet" href="../css/home.css">
</head>

<body>
  <div class="navbar">
    <a href="/home">IPL</a>
    <a href="/home">Home</a>
    <a href="/logout">Logout</a>
  </div>
</body>

</html>

<?php

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
  //Checking if admin login
  if ($_SESSION['email'] == "chhavisharma3007@gmail.com") {
    ?>

    <!-- Add Player form -->
    <link rel="stylesheet" href="../css/login.css">
    <form action="/player" method="post">
      <label for="id">Employee Id</label>
      <input type="text" name="id" required><br>
      <label for="name">Employee Name</label>
      <input type="text" name="name" required><br>

      <label for="type">Employee Type</label>

      <select name="type">
        <option value="batsman">Batsman</option>
        <option value="bowler">Bowler</option>
        <option value="all rounder">All Rounder</option>
      </select><br>
      <label for="points">Points</label>
      <input type="text" name="points" required><br>
      <input type="submit" name="addPlayer" value="Add Player">
    </form>
    <?php
  } else {  //If user login
    //Display all players
    echo "<a href='/userTeam'>My Team</a>";
    $pl = new Player();
    $players = $pl->showPlayers();
    ?>
    <table>
      <tr>
        <th>Employee Id</th>
        <th>Employee Name</th>
        <th>Employee Type</th>
        <th>Employee Points</th>
      </tr>
      <?php

      //Players in tabular form
      foreach ($players as $player) {
        ?>
        <tr>
          <td><?php echo $player['Id'] ?></td>
          <td><?php echo $player['Name'] ?></td>
          <td><?php echo $player['Type'] ?></td>
          <td><?php echo $player['Points'] ?></td>
          <td>
            <form action="/team" method="post">
              <input type="hidden" name="id" value="<?php echo $player['Id'] ?>">
              <input type="submit" name="selectPlayer" value="Select Player">
            </form>
          </td>
        </tr>
        <?php
      } ?>
    </table>
    <!-- Showing total points and save team button -->
    <p>Total Points: <?php echo $_SESSION['total_points']; ?></p>
    <form method="post" action="/team">
      <button type="submit" name="save_team" <?php echo (count($_SESSION['selected_players']) > 11 || $_SESSION['total_points'] > 100) ? 'disabled' : ''; ?>>Submit Team</button>
    </form>
    <?php
  }
