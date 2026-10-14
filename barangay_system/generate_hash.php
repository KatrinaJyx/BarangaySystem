<?php
// ⚠️ DELETE THIS FILE AFTER USE!
echo "<pre>";
echo "Hash for admin123: " . password_hash("admin123", PASSWORD_DEFAULT) . "\n";
echo "</pre>";
echo "<p>Copy the hash above and paste it into the users table password column.</p>";
?>