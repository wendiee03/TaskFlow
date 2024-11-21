<?php
session_start();
require_once 'db_connect.php';

if(isset($_SESSION['login_id'])) {
    header("location: index.php");
    exit;
}

if(isset($_POST['login'])) {
    $email = $db->escape_string($_POST['email']);
    $password = md5($_POST['password']); // Using MD5 to match existing database

    $sql = "SELECT *, concat(firstname,' ',lastname) as name FROM users WHERE email = '$email' AND password = '$password'";
    $result = $db->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['login_id'] = $row['id'];
        $_SESSION['login_name'] = $row['name'];
        $_SESSION['login_type'] = $row['type'];
        
        echo "<script>
            alert('Welcome ".$row['name']."!');
            window.location.href='index.php';
        </script>";
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Task Management System</title>
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1">Task Management</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <a href="register.php">Register a new account</a>
                        </div>
                        <div class="col-4">
                            <button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/dist/js/adminlte.min.js"></script>
</body>
</html> 