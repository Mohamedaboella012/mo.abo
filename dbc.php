<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_content";

// إنشاء اتصال بقاعدة البيانات
$con = new mysqli($servername, $username, $password, $dbname);

// التحقق من نجاح الاتصال
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
