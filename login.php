<?php
require_once 'config.php';

$message = "";
$message_type = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        // Hash the incoming password to compare
        $hashed_input = hash('sha256', $password);
        
        // Fetch user by username
        $endpoint = "/rest/v1/users?username=eq." . urlencode($username);
        $response = supabase_request('GET', $endpoint);
        
        if ($response['status'] == 200 && !empty($response['body'])) {
            $user = $response['body'][0];
            
            if ($user['password'] === $hashed_input) {
                $message = "تم تسجيل الدخول بنجاح! أهلاً " . htmlspecialchars($user['username']);
                $message_type = "success";
            } else {
                $message = "كلمة المرور غير صحيحة";
                $message_type = "error";
            }
        } else {
            $message = "اسم المستخدم غير موجود";
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
    <title>تسجيل الدخول</title>
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
        <h2>دخول</h2>
        <?php if ($message): ?>
            <div class="msg <?php echo $message_type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="اسم المستخدم" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <button type="submit">دخول</button>
        </form>
        <a href="index.html" class="back">العودة للرئيسية</a>
    </div>
</body>
</html>
