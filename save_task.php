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
  $title = $_POST['title'];
  $description = $_POST['description'];
  $user_id = $_SESSION['user_id'];  // Suponiendo que has almacenado el id del usuario en la sesión durante el inicio de sesión.

  $query = "INSERT INTO task(title, description, user_id) VALUES ('$title', '$description', '$user_id')";
  $result = mysqli_query($conn2, $query);

  if (!$result) {
    die("Query Failed.");
  }

  $_SESSION['message'] = '¡Tarea guardada!';
  $_SESSION['message_type'] = 'success';
  header('Location: /taskusers/tasks.php');
}



