<?php
require_once __DIR__ . '/backend/config/database.php';

try {
    $db = Database::getConnection();
    
    // The new password we want to set
    $new_password = "password123";
    $hashed = password_hash($new_password, PASSWORD_BCRYPT);
    
    // Update the admin account
    $stmt = $db->prepare("UPDATE users SET password = ? WHERE role = 'admin'");
    $stmt->execute([$hashed]);
    
    if ($stmt->rowCount() > 0) {
        $msg = "✅ SUCCESS! The admin password has been reset to: <strong>password123</strong>";
    } else {
        // Let's check if an admin even exists
        $check = $db->query("SELECT email FROM users WHERE role = 'admin'")->fetch();
        if ($check) {
            $msg = "✅ The admin password is ALREADY set to password123. Email is: " . $check['email'];
        } else {
            $msg = "❌ ERROR: No admin user found in the database. You need to register one!";
        }
    }
} catch (Exception $e) {
    $msg = "❌ Database Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head><title>Reset Password</title><style>body{font-family:sans-serif; padding:40px; text-align:center; background:#f4f4f5;} .box{background:#fff; padding:30px; border-radius:10px; box-shadow:0 4px 6px rgba(0,0,0,0.1); display:inline-block;}</style></head>
<body>
    <div class="box">
        <h2>Password Reset Utility</h2>
        <p style="font-size: 1.2rem;"><?php echo $msg; ?></p>
        <p><a href="frontend/pages/auth/login.html" style="display:inline-block; margin-top:20px; padding:10px 20px; background:#004ac6; color:#fff; text-decoration:none; border-radius:5px;">Go to Login</a></p>
    </div>
</body>
</html>
