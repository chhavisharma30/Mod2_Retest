<?php
namespace app;

use app\Connection;

session_start();

class Team {
  // Database connection and username properties
  public $db_conn;

  // Constructor method
  public function __construct() {
    // Establishing a database connection
    $conn = new Connection();
    $this->db_conn = $conn->connect();
  }

  /**
   * Function to display user team
   */
  public function showUserTeam() {
    $userEmail = $_SESSION['email'];
    // Query to fetch all stocks
    $query = "SELECT * FROM players_table WHERE Id IN (SELECT PlayerId from team_table WHERE UserEmail = '$userEmail')";
    // Executing the query
    $result = mysqli_query($this->db_conn, $query);

    return $result;
  }

  // Function to select player
  public function selectPlayer() {
    //Retrieving current player info from id
    $id = $_POST['id'];
    $query1 = "SELECT * FROM players_table WHERE Id = $id";
    $result = mysqli_query($this->db_conn, $query1);

    if (mysqli_num_rows($result)) {
      $curr_player = [];
      while ($row = mysqli_fetch_assoc($result)) {
        $curr_player[] = $row;
      }

      $player_id = $curr_player[0]['Id'];
      $player_points = $curr_player[0]['Points'];
      $player_role = $curr_player[0]['Type'];

      // Initializing session variables if not set
      if (!isset($_SESSION['selected_players'])) {
        $_SESSION['selected_players'] = [];
        $_SESSION['total_points'] = 0;
        $_SESSION['role_counts'] = ['batsman' => 0, 'allrounder' => 0, 'bowler' => 0];
      }

      // Checking if player is already selected
      if (in_array($player_id, $_SESSION['selected_players'])) {
        // Removing player
        $_SESSION['selected_players'] = array_diff($_SESSION['selected_players'], [$player_id]);
        $_SESSION['total_points'] -= $player_points;
        $_SESSION['role_counts'][$player_role]--;
      } else {
        // Adding player
        if (count($_SESSION['selected_players']) < 11 && $_SESSION['total_points'] + $player_points <= 100) {
          if (
            ($player_role == 'batsman' && $_SESSION['role_counts']['batsman'] < 5) ||
            ($player_role == 'all rounder' && $_SESSION['role_counts']['allrounder'] < 2) ||
            ($player_role == 'bowler' && $_SESSION['role_counts']['bowler'] < 4)
          ) {

            $_SESSION['selected_players'][] = $player_id;
            $_SESSION['total_points'] += $player_points;
            $_SESSION['role_counts'][$player_role]++;
          } else {
            echo '<script>alert("Role limit exceeded for $player_role!")</script>';
            echo "<script>window.location.href='/home';</script>";
          }
        } else {
          echo '<script>alert("Max points or players limit exceeded!")</script>';
          echo "<script>window.location.href='/home';</script>";
        }
      }
    }
    echo "<script>window.location.href='/home';</script>";
  }

  /**
   * Function to save team
   */
  public function saveTeam() {
    $userId = $_SESSION['email'];
    $playerIds = $_SESSION['selected_players'];

    //Checking the number of players and points
    if (count($_SESSION['selected_players']) <= 11 && $_SESSION['total_points'] <= 100) {

      foreach ($playerIds as $playerId) {
        $stmt = "INSERT INTO team_table (UserEmail, PlayerId) VALUES ('$userId', $playerId)";
        mysqli_query($this->db_conn, $stmt);
      }

      // Clear the session variables
      $_SESSION['selected_players'] = [];
      $_SESSION['total_points'] = 0;
      $_SESSION['role_counts'] = ['batsman' => 0, 'allrounder' => 0, 'bowler' => 0];

      echo '<script>alert("Team saved successfully!")</script>';
      echo "<script>window.location.href='/userTeam';</script>";
    } else {
      echo '<script>alert("Invalid team selection.")</script>';
      echo "<script>window.location.href='/home';</script>";
    }

  }

}

$team = new Team();

if (isset($_POST['selectPlayer'])) {
  $team->selectPlayer();
} elseif (isset($_POST['save_team'])) {
  $team->saveTeam();
}
