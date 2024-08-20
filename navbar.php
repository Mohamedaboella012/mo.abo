<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Example</title>
    <style>
        /* تنسيق شريط التنقل */
        .navbar {
            display: flex;
            justify-content: flex-start; /* محاذاة الروابط إلى اليسار */
            background-color: #333; /* لون خلفية شريط التنقل */
            padding: 10px;
            position: fixed; /* تثبيت شريط التنقل في أعلى الصفحة */
            top: 0;
            width: 100%; /* جعل الشريط يغطي عرض الصفحة بالكامل */
            z-index: 1000; /* ضمان أن الشريط سيكون في مقدمة أي محتوى آخر */
        }

        /* تنسيق الروابط داخل شريط التنقل */
        .navbar a {
            color: white; /* لون النص */
            padding: 14px 20px; /* المسافات داخل كل رابط */
            text-decoration: none; /* إزالة التسطير */
            text-align: center; /* محاذاة النص في وسط الكتلة */
        }

        /* تغيير لون الخلفية عند مرور الفأرة */
        .navbar a:hover {
            background-color: #575757; /* لون الخلفية عند التمرير */
        }

        /* إضافة هامش أعلى المحتوى لتجنب تداخل المحتوى مع شريط التنقل المثبت */
        body {
            margin-top: 50px; /* يجب أن يتناسب مع ارتفاع شريط التنقل */
        }
    </style>
</head>
<body>

    <div class="navbar">
    <a href="logout.php">Logout</a>
    <a href="welcome.php">Home</a>
        <a href="search.php">Search</a>
        <a href="post.php">Post</a>
        <a href="allpost.php">all Post</a>
    </div>

  

</body>
</html>
