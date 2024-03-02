<?php
session_start();
include("db.php");

if (isset($_SESSION['user_id'])) {
  $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = null;

  if (count($results) > 0) {
    $user = $results;
  }
}

?>

<?php include('includes/header.php'); ?>
<main class="container p-4">
  <div class="d-flex justify-content-center align-items-center flex-column">
    <?php if (!empty($user)):
      header('Location: /taskusers/tasks.php');
    else: ?>
      <h1>Registrate o Inicia sesión</h1>
      <div>
        <a href="register.php" class="btn btn-outline-primary">Registrate</a>
        <a href="login.php" class="btn btn-primary">Inicia sesión</a>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php include('includes/footer.php'); ?>