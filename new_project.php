<?php
require_once 'db_connect.php';
require_once 'includes/Project.php';

if(!isset($_SESSION['login_id'])){
    header("Location: login.php");
    exit;
}

$project = new Project($db);

if(isset($_POST['save_project'])){
    $data = array(
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'status' => $_POST['status'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'manager_id' => $_POST['manager_id'],
        'user_ids' => implode(',', $_POST['user_ids'])
    );
    
    if($project->createProject($data)){
        echo "<script>
            alert('Project successfully created');
            window.location.href='project_list.php';
        </script>";
        exit;
    } else {
        $error = "Error creating project: " . $db->error();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Project</title>
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="col-lg-12">
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create New Project</h3>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Project Name</label>
                                                <input type="text" class="form-control" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="0">Pending</option>
                                                    <option value="3">On-Hold</option>
                                                    <option value="5">Done</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="date" class="form-control" name="start_date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="date" class="form-control" name="end_date" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <?php if($_SESSION['login_type'] == 1): ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Project Manager</label>
                                                    <select class="form-control select2" name="manager_id" required>
                                                        <option value="">Select Manager</option>
                                                        <?php 
                                                        $managers = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 2");
                                                        while($row = $managers->fetch_assoc()):
                                                        ?>
                                                        <option value="<?php echo $row['id'] ?>"><?php echo ucwords($row['name']) ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <input type="hidden" name="manager_id" value="<?php echo $_SESSION['login_id'] ?>">
                                        <?php endif; ?>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Team Members</label>
                                                <select class="form-control select2" multiple="multiple" name="user_ids[]" required>
                                                    <?php 
                                                    $employees = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 3");
                                                    while($row = $employees->fetch_assoc()):
                                                    ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo ucwords($row['name']) ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="4" required></textarea>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" name="save_project" class="btn btn-primary">Save Project</button>
                                        <a href="project_list.php" class="btn btn-default">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(function(){
            $('.select2').select2({
                placeholder: "Please select here",
                width: "100%"
            });
        });
    </script>
</body>
</html> 