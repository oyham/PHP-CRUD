<?php
include("db.php");
session_start();
if (!isset($_SESSION['user_id'])) {
  echo "No has iniciado sesión.";
  header('Location: /taskusers/index.php');
  exit;
}
$title = '';
$description = '';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM task WHERE id=$id";
  $result = mysqli_query($conn2, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $title = $row['title'];
    $description = $row['description'];
  }
}

if (isset($_POST['update'])) {
  $id = $_GET['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];

  $query = "UPDATE task set title = '$title', description = '$description' WHERE id=$id";
  mysqli_query($conn2, $query);
  $_SESSION['message'] = '¡Tarea editada!';
  $_SESSION['message_type'] = 'warning';
  header('Location: tasks.php');
}

?>
<?php include('includes/header.php'); ?>
<div class="container p-4">
  <div class="row">
    <div class="col-md-4 mx-auto">
      <div class="card card-body">
        <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
          <div class="form-group">
            <input name="title" type="text" class="form-control" value="<?php echo $title; ?>"
              placeholder="Editar título">
          </div>
          <div class="form-group">
            <textarea name="description" class="form-control" cols="30" rows="10"><?php echo $description; ?></textarea>
          </div>
          <button class="btn-success" name="update">
            Editar
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>