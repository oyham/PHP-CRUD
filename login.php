<?php

include("db.php");

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: /tasks.php');
}


if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
        $_SESSION['user_id'] = $results['id'];
        header("Location: /tasks");
    } else {
        $message = 'Sorry, those credentials do not match';
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
    <h1>Inicia Sesión</h1>
    <form class="container-sm" action="login.php" method="POST">
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
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <input type="submit" value="Submit" class="btn btn-primary">Submit</input>
    </form>
    <span>o <a href="register.php">Registrate</a></span>
</main>

<?php include('includes/footer.php'); ?>