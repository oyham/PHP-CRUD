<?php
session_start();
include("db.php");

if (isset($_SESSION['user_id'])) {
  $records = $conn->prepare('SELECT id, email, password FROM users WEHERE id = :id');
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
  <div class="row">
    <?php if (!empty($user)): ?>
      <br>Welcome.
      <?= $user['email'] ?>
      <br>You are succesfully logged In
      <a href='logout.php'>Logout</a>
    <?php else: ?>
      <h1>Please Login or SignUp</h1>
      <a href="register.php">Registrate </a>
      <a href="login.php">Inicia sesión</a>
    <?php endif; ?>
  </div>
</main>

<?php include('includes/footer.php'); ?>