<?php
require_once '../includes/Database.php';  // Change path as needed
$db = new Database();

if(!isset($_SESSION)) { 
    session_start(); 
}

// Process form submission
if(isset($_POST['save_user'])){
    // Validate password match
    if($_POST['password'] != $_POST['cpass']){
        $error = "Passwords do not match";
    } else {
        $firstname = $db->escape_string($_POST['firstname']);
        $lastname = $db->escape_string($_POST['lastname']);
        $email = $db->escape_string($_POST['email']);
        $password = md5($_POST['password']); // Using MD5 to match existing DB
        $type = isset($_POST['type']) ? $_POST['type'] : '3';
        $phone = $db->escape_string($_POST['phone']);

        // Check if email already exists
        $check = $db->query("SELECT * FROM users WHERE email = '$email'");
        if($check->num_rows > 0){
            $error = "Email already exists";
        } else {
            // Handle file upload
            $avatar = '';
            if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
                $fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
                $move = move_uploaded_file($_FILES['img']['tmp_name'], '../assets/uploads/'. $fname);
                if($move){
                    $avatar = $fname;
                }
            }

            $sql = "INSERT INTO users (firstname, lastname, email, password, type, Phone_No, avatar) 
                    VALUES ('$firstname', '$lastname', '$email', '$password', '$type', '$phone', '$avatar')";
            
            if($db->query($sql)){
                echo "<script>
                    alert('User successfully created');
                    window.location.href='user_list.php';
                </script>";
                exit;
            } else {
                $error = "Error creating user: " . $db->error();
            }
        }
    }
}

// Get user data if editing
if(isset($_GET['id'])){
    $user = $db->query("SELECT * FROM users where id = ".$_GET['id'])->fetch_array();
    foreach($user as $k => $v){
        $$k = $v;
    }
}
?>

<div class="col-lg-12">
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create New User</h3>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
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
                            <label>User Role</label>
                            <select name="type" class="form-control">
                                <option value="3">Employee</option>
                                <option value="2">Project Manager</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone No</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="cpass" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Avatar</label>
                    <input type="file" name="img" class="form-control" accept="image/*">
                </div>

                <div class="card-footer">
                    <button type="submit" name="save_user" class="btn btn-primary">Save User</button>
                    <a href="user_list.php" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    img#cimg{
        max-height: 150px;
        max-width: 150px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>

<script>
    // Simple image preview
    document.querySelector('input[name="img"]').addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('cimg').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script> 
</script> 