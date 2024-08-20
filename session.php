<?php
session_start();
session_regenerate_id();


if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();}
include 'navbar.php';
?>