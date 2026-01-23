<?php
require_once 'config.php';

$response = supabase_request('GET', '/rest/v1/users?select=*');
$users = $response['body'] ?? [];
$status = $response['status'];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قائمة المستخدمين - فحص</title>
    <style>
        body { font-family: sans-serif; background: #1c1c1c; color: #f4f4f4; padding: 2rem; }
        h2 { color: #3ecf8e; border-bottom: 2px solid #3ecf8e; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #2a2a2a; border-radius: 8px; overflow: hidden; }
        th, td { padding: 15px; text-align: right; border-bottom: 1px solid #444; }
        th { background: #333; color: #3ecf8e; }
        tr:hover { background: #333; }
        .status { color: #888; font-size: 0.8rem; }
        .back { display: inline-block; margin-bottom: 20px; color: #3ecf8e; text-decoration: none; }
    </style>
</head>
<body>
    <a href="index.html" class="back">← العودة للرئيسية</a>
    <h2>المستخدمين في Supabase</h2>
    <p class="status">HTTP Status: <?php echo $status; ?></p>
    
    <?php if ($status != 200): ?>
        <p style="color: #ff4b4b;">خطأ في جلب البيانات: <?php echo print_r($users, true); ?></p>
    <?php elseif (empty($users)): ?>
        <p>لا يوجد مستخدمين مسجلين حالياً.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>اسم المستخدم</th>
                    <th>كلمة المرور (Hashed)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td style="font-family: monospace; font-size: 0.8rem;"><?php echo htmlspecialchars($user['password']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
