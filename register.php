<?php
require_once 'config.php';

$message = "";
$message_type = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        // Hash password (SHA-256)
        $hashed_password = hash('sha256', $password);
        
        $data = [
            'username' => $username,
            'password' => $hashed_password
        ];
        
        $response = supabase_request('POST', '/rest/v1/users', $data);
        
        if ($response['status'] == 201) {
            $message = "تم التسجيل بنجاح!";
            $message_type = "success";
        } else {
            $error_msg = isset($response['body']['message']) ? $response['body']['message'] : "حدث خطأ غير معروف";
            $message = "خطأ في التسجيل: " . $error_msg;
            $message_type = "error";
        }
    } else {
        $message = "يرجى ملء جميع الحقول";
        $message_type = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل مستخدم جديد</title>
    <style>
        body { font-family: sans-serif; background: #1c1c1c; color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: #2a2a2a; padding: 2rem; border-radius: 12px; width: 300px; box-shadow: 0 4px 15px rgba(0,0,0,0.5); }
        h2 { color: #3ecf8e; text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #444; background: #333; color: #fff; box-sizing: border-box; }
        button { width: 100%; border: none; padding: 10px; background: #3ecf8e; color: #1c1c1c; font-weight: bold; border-radius: 5px; cursor: pointer; }
        button:hover { background: #2eb87e; }
        .msg { padding: 10px; margin-bottom: 10px; border-radius: 5px; text-align: center; }
        .success { background: rgba(62, 207, 142, 0.2); color: #3ecf8e; border: 1px solid #3ecf8e; }
        .error { background: rgba(255, 75, 75, 0.2); color: #ff4b4b; border: 1px solid #ff4b4b; }
        .back { display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="card">
        <h2>حساب جديد</h2>
        <?php if ($message): ?>
            <div class="msg <?php echo $message_type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="اسم المستخدم" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <button type="submit">تسجيل</button>
        </form>
        <a href="index.html" class="back">العودة للرئيسية</a>
    </div>
</body>
</html>
