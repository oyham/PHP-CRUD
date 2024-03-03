<?php
include("db.php");
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM task WHERE user_id = '$user_id'";
} else {
    echo "No has iniciado sesión";
}
?>

<?php include('includes/header.php'); ?>

<main class="container p-4">
    <div class="row">
        <div class="col-md-4">


            <!-- ADD TASK FORM -->
            <div class="card card-body">
                <form action="save_task.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Título" autofocus>
                    </div>
                    <div class="form-group">
                        <textarea name="description" rows="2" class="form-control" placeholder="Descripción"></textarea>
                    </div>
                    <input type="submit" name="save_task" class="btn btn-success btn-block" value="Añadir tarea">
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Fecha de creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $user_id = $_SESSION['user_id'];
                    $query = "SELECT * FROM task WHERE user_id = '$user_id'";
                    $result_tasks = mysqli_query($conn2, $query);

                    if (!$result_tasks) {
                        die("Error en la consulta: " . mysqli_error($conn2));
                    }

                    while ($row = mysqli_fetch_assoc($result_tasks)) { ?>
                        <tr>
                            <td>
                                <?php echo $row['title']; ?>
                            </td>
                            <td>
                                <?php echo $row['description']; ?>
                            </td>
                            <td>
                                <?php echo $row['created_at']; ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id'] ?>" class="btn btn-secondary">
                                    <i class="fas fa-marker"></i>
                                </a>
                                <a href="delete_task.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
        <a href='logout.php' class="btn btn-primary m-3 p-2">Cerrar Sesión</a>
    </div>
    <!-- MESSAGES -->
    <?php if (isset($_SESSION['message'])) { ?>
        <div id="alert-container" class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show"
            role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            const $remove = document.getElementById('alert-container');
            setTimeout(function () {
                $remove.remove();
            }, 5000);
        </script>
        <?php ;
    } ?>
</main>
<?php include('includes/footer.php'); ?>