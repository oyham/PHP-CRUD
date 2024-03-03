<?php

include("db.php");
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: /taskusers/tasks.php');
    exit;
}

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if ($results !== false && count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
        $_SESSION['user_id'] = $results['id'];
        header("Location: /taskusers/tasks.php");
    } else {
        $message = 'Perdon, los datos no coinciden';
    }
}

?>

<?php include('includes/header.php'); ?>
<main class="grid text-center p-4">
    <?php if (!empty($message)): ?>
        <p id="message" class="p-3 text-bg-warning rounded-3">
            <?= $message ?>
        </p>
    <?php endif; ?>
    <h1 class="m-2 p-2">Inicia Sesión</h1>
    <form class="container-sm" action="login.php" method="POST">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Dirección de correo</label>
            <input name="email" type="email" class="form-control rounded-3" id="exampleInputEmail1"
                aria-describedby="emailHelp" placeholder="Inserte su email" required>
            <div id="emailHelp" class="form-text">Nunca compartiremos tu email con nadie.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword1"
                placeholder="introduzca su contraseña" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Recuerdame</label>
        </div>
        <input type="submit" value="Submit" class="btn btn-primary mb-4" />
    </form>
    <span>o <a href="register.php">Registrate</a></span>
</main>

<?php include('includes/footer.php'); ?>