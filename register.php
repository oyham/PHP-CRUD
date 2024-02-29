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
<main class="container p-4">
    <?php if (!empty($message)): ?>
        <p>
            <?= $message ?>
        </p>
    <?php endif; ?>
    <h1 class="m-4 p-4">Registrate</h1>
    <form class="container-sm" action="register.php" method="POST">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input name="email" type="email" class="form-control rounded-3" id="exampleInputEmail1"
                aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Confirma la contraseña</label>
            <input name="confirm_password" type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <input type="submit" value="Submit" class="btn btn-primary">Submit</input>
    </form>
    <span>o <a href="login.php">Inicia Sesión</a></span>
</main>

<?php include('includes/footer.php'); ?>