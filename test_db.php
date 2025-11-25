<?php
// test_db.php
echo "<h2>Database Connection Test</h2>";

// Your database credentials
$host = 'localhost';
$dbname = 'academy_db';
$username = 'chaomwdk_trip';
$password = 'Trip@1234';

try {
    // Test connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
    
    // Test if players table exists
    $tables = $pdo->query("SHOW TABLES LIKE 'players'")->fetch();
    if ($tables) {
        echo "<p style='color: green;'>✅ Players table exists</p>";
        
        // Count players
        $count = $pdo->query("SELECT COUNT(*) FROM players")->fetchColumn();
        echo "<p>Total players in database: $count</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Players table doesn't exist</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>❌ Connection failed: " . $e->getMessage() . "</p>";
    
    // Try to connect without database to check if MySQL is running
    try {
        $pdo = new PDO("mysql:host=$host", $username, $password);
        echo "<p style='color: orange;'>⚠️ Can connect to MySQL but database '$dbname' doesn't exist or is inaccessible</p>";
    } catch(PDOException $e2) {
        echo "<p style='color: red;'>❌ Cannot connect to MySQL server: " . $e2->getMessage() . "</p>";
    }
}
?>