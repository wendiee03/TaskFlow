<?php
if(!isset($_SESSION)) { 
    session_start(); 
}

if(!isset($_SESSION['login_id'])) {
    echo "<script>
        alert('Please login first');
        window.location.href='login.php';
    </script>";
    exit;
} 