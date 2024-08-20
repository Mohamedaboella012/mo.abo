<?php
include 'session.php';

// تضمين ملف الاتصال بقاعدة البيانات
include 'dbc.php';


// التحقق مما إذا تم تقديم النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // الحصول على نص المنشور
    $postText = htmlspecialchars(strip_tags($_POST['postText']));
  
    // تهيئة متغيرات للملف
    $fileName = null;
    $filePath = null;

    // تحقق مما إذا كان المستخدم قد رفع ملفًا
    if (!empty($_FILES["fileToUpload"]["name"])) {
        $target_dir = "uploads/";
        $fileName = basename($_FILES["fileToUpload"]["name"]);
        $filePath = $target_dir . $fileName;
        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // حدد الامتدادات المسموح بها
        $allowed_extensions = array("jpg", "jpeg", "png", "gif", "pdf", "doc", "docx");

        // تحقق مما إذا كان الامتداد مسموحًا به
        if (!in_array($fileType, $allowed_extensions)) {
            echo "Sorry, only JPG, JPEG, PNG, GIF, PDF, DOC, and DOCX files are allowed.";
            exit;
        }

        // تحقق من حجم الملف قبل رفعه
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            exit;
        }

        // حاول رفع الملف
        if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filePath)) {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    // إدراج بيانات المنشور والملف في قاعدة البيانات
    $stmt = $con->prepare("INSERT INTO posts (post_text, file_name, file_path) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $postText, $fileName, $filePath);

    if ($stmt->execute()) {
        echo "Post and file uploaded successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // إغلاق الاتصال
    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Post and File</title>
    <style>
        /* تنسيق الجسم */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e0f7fa; /* خلفية ملونة فاتحة */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh; /* ملء ارتفاع الصفحة */
        }

        /* تنسيق العنوان */
        h2 {
            text-align: center;
            color: #00796b; /* لون أخضر داكن */
            margin-bottom: 20px;
        }

        /* تنسيق النموذج */
        form {
            max-width: 800px;
            width: 100%; /* استخدام عرض كامل الصفحة */
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff; /* خلفية بيضاء */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* تنسيق منطقة النص */
        textarea {
            width: 100%;
            height: 200px;
            padding: 12px;
            border: 2px solid #00796b; /* حدود خضراء داكنة */
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        /* تنسيق زر التحميل */
        input[type="file"] {
            display: block;
            margin: 20px 0;
        }

        /* تنسيق أزرار النموذج */
        button {
            display: inline-block;
            padding: 12px 24px;
            font-size: 18px;
            color: #fff;
            background-color: #009688; /* لون أخضر ملفت */
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        button:hover {
            background-color: #00796b; /* لون أخضر داكن عند التمرير */
        }
    </style>
</head>
<body>
    <div>
        <h2>Create a New Post</h2>
        <form action="post.php" method="POST" enctype="multipart/form-data">
            <textarea name="postText" placeholder="Enter your post here" required></textarea><br>
            <input type="file" name="fileToUpload" required ><br>
            <button type="submit">Upload Post</button>
        </form>
    </div>
</body>
</html>
