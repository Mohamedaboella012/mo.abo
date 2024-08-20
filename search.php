<?php
 include 'session.php';
require 'db.php';



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $searchId =filter_var( ($_GET['searchId']),FILTER_VALIDATE_INT);
    $searchUsername = filter_var($_GET['searchUsername'],FILTER_SANITIZE_STRING);
    
 }
    // إعداد الاستعلام بناءً على المدخلات
    if (!empty($searchId)) {
        $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE id = ?');
        if ($stmt) {
            $stmt->bind_param('i', $searchId);
        }
    } elseif (!empty($searchUsername)) {
        $searchUsername = "%" . $searchUsername . "%";
        $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE username LIKE ?');
        if ($stmt) {
            $stmt->bind_param('s', $searchUsername);
        }
    }

    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo "<h3>User Found:</h3>";
            echo "User ID: " . $row['id'] . "<br>";
            echo "Username: " . $row['username'] . "<br>";
            echo "Password (hashed): " . $row['password'] . "<br>";
        } else {
            echo "No user found with the provided ID or username.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }


$conn->close();
?>

<!-- <!DOCTYPE html>
<html>
<head>
    <title>Search User</title>
</head>
<body>
    <h2>Search for a User</h2>
    <form method="POST" action="search.php">
        <input type="text" name="searchId" placeholder="Enter ID to Search">
        <input type="text" name="searchUsername" placeholder="Enter Username to Search">
        <button type="submit">Search</button>
    </form>
</body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search User</title>
    <style>
        /* تنسيق الجسم */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4; /* خلفية فاتحة */
            display: flex;
            flex-direction: column; /* ترتيب العناصر عمودياً */
            align-items: center; /* توسيط المحتوى أفقيًا */
            justify-content: center; /* توسيط المحتوى عموديًا */
            height: 100vh; /* ملء ارتفاع الصفحة */
        }

        /* تنسيق النموذج */
        form {
            max-width: 600px;
            width: 100%; /* استخدام عرض كامل الصفحة */
            padding: 20px;
            background-color: #fff; /* خلفية بيضاء للنموذج */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* ظل خفيف حول النموذج */
            box-sizing: border-box; /* لتضمين الحشو في العرض الإجمالي */
            margin-top: 20px; /* مسافة من الأعلى */
        }

        /* تنسيق العنوان */
        h2 {
            text-align: center;
            color: #333; /* لون نص داكن */
            margin-bottom: 20px;
        }

        /* تنسيق حقول الإدخال */
        input[type="text"] {
            width: calc(50% - 12px); /* عرض نصف النموذج مع مساحة للهامش */
            padding: 10px;
            border: 1px solid #ccc; /* لون حدود رمادي فاتح */
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box; /* لتضمين الحشو في العرض الإجمالي */
            margin-right: 10px; /* مسافة بين الحقول */
            margin-bottom: 10px; /* مسافة أسفل الحقل */
        }

        /* تنسيق زر البحث */
        button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff; /* لون أزرق مميز */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        button:hover {
            background-color: #0056b3; /* لون أزرق داكن عند التمرير */
        }
    </style>
</head>
<body>
    <h2>Search for a User</h2>
    <form method="GET" action="search.php">
        <input type="text" name="searchId" placeholder="Enter ID to Search">
        <input type="text" name="searchUsername" placeholder="Enter Username to Search">
        <button type="submit">Search</button>
    </form>
</body>
</html>
