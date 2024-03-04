<?php
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
  echo "No has iniciado sesión.";
  header('Location: /taskusers/index.php');
  exit;
}

$user_id = $_SESSION['user_id'];
if (isset($_POST['save_task'])) {
  $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
  $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
  $user_id = $_SESSION['user_id'];

  $title = mysqli_real_escape_string($conn2, $title);
  $description = mysqli_real_escape_string($conn2, $description);

  $query = "INSERT INTO task(title, description, user_id) VALUES ('$title', '$description', '$user_id')";
  $result = mysqli_query($conn2, $query);

  if (!$result) {
    die("Query Failed.");
  }

  $_SESSION['message'] = '¡Tarea guardada!';
  $_SESSION['message_type'] = 'success';
  header('Location: /taskusers/tasks.php');
}



