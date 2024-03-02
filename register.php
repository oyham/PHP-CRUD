<?php

include("db.php");
$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        $message = 'Successfully created new user';
    } else {
        $message = 'Sorry there must have been an issue creating your account';
    }
}
?>


<?php include('includes/header.php'); ?>
<main class="grid text-center p-4">
    <?php if (!empty($message)): ?>
        <p>
            <?= $message ?>
        </p>
    <?php endif; ?>
    <h1 class="m-2 p-2">Registrate</h1>
    <form class="container-sm" action="register.php" method="POST">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Dirección de correo</label>
            <input name="email" type="email" class="form-control rounded-3" id="exampleInputEmail1"
                aria-describedby="emailHelp" placeholder="Inserte su email">
            <div id="emailHelp" class="form-text">Nunca compartiremos tu email con nadie.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword1"
                placeholder="introduzca una contraseña">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Repita la contraseña</label>
            <input name="confirm_password" type="password" class="form-control" id="exampleInputPassword1"
                placeholder="Repita la contraseña">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Recuerdame</label>
        </div>
        <input type="submit" value="Submit" class="btn btn-primary  mb-4"></input>
    </form>
    <span>o <a href="login.php">Inicia Sesión</a></span>
</main>

<?php include('includes/footer.php'); ?>