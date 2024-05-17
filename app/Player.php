<?php
namespace app;

use app\Connection;

//class for Player
class Player
{
  // Database connection
  public $db_conn;

  /**
   * Constructor Method
   */
  public function __construct() {
    // Establishing a database connection
    $conn = new Connection();
    $this->db_conn = $conn->connect();
    // Retrieving username from session
  }

  /**
   * Function to show all Players
   */
  public function showPlayers() {
    // Query to fetch all stocks
    $query = "SELECT * from players_table";
    // Executing the query
    $result = mysqli_query($this->db_conn, $query);
    return $result;
  }

  /**
   * Function to validate player entries
   */
  public function validateEntry() {
    if (!preg_match('/^[A-Za-z][A-Za-z ]+$/', $_POST['name'])) { // Validating name format
      echo '<script>alert("Name should contain only letters!!")</script>';
      return false;
    } elseif (!preg_match('/^[0-9]+$/', $_POST['id'])) {
      echo '<script>alert("Invalid Id!!")</script>';
      return false;
    } elseif (!preg_match('/^[0-9]+$/', $_POST['points'])) {
      echo '<script>alert("Points should be in numbers!!")</script>';
      return false;
    }elseif ($_POST['points']<2 ||$_POST['points']>10) {
      echo '<script>alert("Points should be between 2 and 10!!")</script>';
      return false;
    }
    return true;
  }

  // Method to add new player
  public function addPlayer() {
    // Retrieving data from form submission
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $points = $_POST['points'];
    // Query to insert new player
    $query = "INSERT INTO players_table(Id, Name, Type, Points) VALUES($id, '$name', '$type', $points)";
    // Executing the query
    mysqli_query($this->db_conn, $query);
    // Redirecting after adding the player
    header('Refresh: 1; URL = /');
  }

}

//Making object of Player class and handling post requests
$player = new Player();
if (isset($_POST['addPlayer'])) {
  if($player->validateEntry()){
    $player->addPlayer();
  }else{
    header('Refresh: 1; URL = /');
  }
}
