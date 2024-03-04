<?php

include("db.php");
$message = '';

if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (strlen($password) >= 8 && preg_match('/^[a-zA-Z0-9]+$/', $password)) {
            if ($password === $confirmPassword) {
                $checkEmailSql = "SELECT COUNT(*) FROM users WHERE email = :email";
                $checkEmailStmt = $conn->prepare($checkEmailSql);
                $checkEmailStmt->bindParam(':email', $_POST['email']);
                $checkEmailStmt->execute();
                $emailExists = $checkEmailStmt->fetchColumn();

                if ($emailExists) {
                    $message = 'El email ya está registrado. Por favor, elige otro.';
                } else {
                    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':email', $_POST['email']);
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $stmt->bindParam(':password', $password);

                    if ($stmt->execute()) {
                        $message = '¡Usuario creado!';
                    } else {
                        $message = 'Perdón, huno un problema al crear tu cuenta.';
                    }
                }
            } else {
                $message = 'La contraseña y la confirmación de la contraseña no coinciden.';
            }
        } else {
            $message = 'La contraseña debe tener al menos 8 caracteres alfanuméricos (mayúsculas y minúsculas).';
        }
    } else {
        $message = 'Por favor, ingresa un correo electrónico válido.';
    }
} else {
    $message = 'Por favor, completa todos los campos.';
}
?>


<?php include('includes/header.php'); ?>
<main class="grid text-center p-4">
    <?php if (!empty($message)): ?>
        <p id="message" class="p-3 text-bg-warning rounded-3">
            <?= $message ?>
        </p>
    <?php endif; ?>
    <h1 class="m-2 p-2">Registrate</h1>
    <form class="container-sm" action="register.php" method="POST">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Dirección de correo</label>
            <input required name="email" type="email" class="form-control rounded-3" id="exampleInputEmail1"
                aria-describedby="emailHelp" placeholder="Inserte su email">
            <div id="emailHelp" class="form-text">Nunca compartiremos tu email con nadie.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Contraseña (min 8 caracteres alfanuméricos)</label>
            <input required name="password" type="password" class="form-control" id="exampleInputPassword1"
                placeholder="introduzca una contraseña" pattern="^[a-zA-Z0-9]+$" minlength="8">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Repita la contraseña</label>
            <input required name="confirm_password" type="password" class="form-control" id="exampleInputPassword2"
                placeholder="Repita la contraseña" pattern="^[a-zA-Z0-9]+$" minlength="8">
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