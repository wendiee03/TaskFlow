<?php
require_once 'includes/Database.php';
$db = new Database();
$conn = $db->getConnection();

if(!isset($_SESSION)) { 
    session_start(); 
} 