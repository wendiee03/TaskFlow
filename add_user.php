<?php
require_once '../includes/Database.php';  // Change path as needed
$db = new Database();

if(!isset($_SESSION)) { 
    session_start(); 
}

// Process form submission
if(isset($_POST['submit'])){
    $firstname = $db->escape_string($_POST['firstname']);
    $lastname = $db->escape_string($_POST['lastname']);
    $email = $db->escape_string($_POST['email']);
    $phone = $db->escape_string($_POST['phone']);
    $type = $db->escape_string($_POST['type']);
    
    // Validate passwords match
    if($_POST['password'] !== $_POST['confirm_password']){
        $error = "Passwords do not match!";
    } else {
        $password = md5($_POST['password']); // Using MD5 to match existing DB
        
        // Check if email exists
        $check = $db->query("SELECT * FROM users WHERE email = '$email'");
        if($check->num_rows > 0){
            $error = "Email already exists!";
        } else {
            $sql = "INSERT INTO users (firstname, lastname, email, password, Phone_No, type) 
                    VALUES ('$firstname', '$lastname', '$email', '$password', '$phone', '$type')";
            
            if($db->query($sql)){
                echo "<script>
                    alert('User added successfully!');
                    window.location.href='index.php';
                </script>";
                exit;
            } else {
                $error = "Error: " . $db->error();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Add New User</h3>
                                </div>
                                
                                <?php if(isset($error)): ?>
                                    <div class="alert alert-danger m-3"><?php echo $error; ?></div>
                                <?php endif; ?>

                                <form method="POST" class="p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" name="firstname" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" name="lastname" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="text" name="phone" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>User Type</label>
                                                <select name="type" class="form-control" required>
                                                    <option value="3">Employee</option>
                                                    <option value="2">Project Manager</option>
                                                    <option value="1">Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" name="confirm_password" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-primary">Add User</button>
                                        <a href="index.php" class="btn btn-default">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html> 