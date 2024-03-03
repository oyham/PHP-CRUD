<?php
include("db.php");
session_start();
if (!isset($_SESSION['user_id'])) {
  echo "No has iniciado sesión.";
  header('Location: /taskusers/index.php');
  exit;
}


if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "DELETE FROM task WHERE id = $id";
  $result = mysqli_query($conn2, $query);
  if (!$result) {
    die("Query Failed.");
  }

  $_SESSION['message'] = '¡Tarea eliminada!';
  $_SESSION['message_type'] = 'danger';
  header('Location: /taskusers/tasks.php');
}
