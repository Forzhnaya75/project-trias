<?php
// raw_db_debug.php
$host = '127.0.0.1';
$username = 'root';
$password = '';
$db = 'trias_db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get superadmin
    $stmt = $pdo->query("SELECT * FROM users WHERE role = 'superadmin' LIMIT 1");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "User found: " . $user['username'] . "\n";
        echo "Profile Picture Value: " . $user['profile_picture'] . "\n";
    } else {
        echo "Superadmin not found.\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
