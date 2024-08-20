
<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username =htmlentities( filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    // إعداد الاستعلام باستخدام prepared statement
    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // تحقق من أن الاستعلام تم تحضيره بنجاح
    if ($stmt) {
        // ربط المتغيرات بالاستعلام
        $stmt->bind_param('sss', $username, $password, $email);

        // تنفيذ الاستعلام
        if ($stmt->execute()) {
            echo "New user registered successfully";
            header("Location: index.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // إغلاق البيان
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            color: #004d40;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            color: #004d40;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #004d40;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        input[type="submit"]:hover {
            background-color: #003d33;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="post" action="register.php">
            <label for="username">Username:</label>
            <input type="text" name="username" minlength="8" maxlength="25" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" minlength="8" maxlength="16"required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
