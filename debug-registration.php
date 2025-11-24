<?php
require_once 'includes/config.php';

echo "<h2>Registration Debug Information</h2>";

// Test database connection
try {
    $stmt = $pdo->query("SELECT 1");
    echo "<p style='color: green;'>✅ Database connection successful</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
    exit;
}

// Check players table structure
try {
    $stmt = $pdo->query("DESCRIBE players");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<p style='color: green;'>✅ Players table exists with columns: " . implode(', ', $columns) . "</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Players table check failed: " . $e->getMessage() . "</p>";
}

// Check upload directory permissions
$upload_dirs = [
    'uploads/' => UPLOAD_PATH,
    'uploads/players/' => PLAYER_UPLOAD_PATH,
    'uploads/staff/' => STAFF_UPLOAD_PATH
];

foreach ($upload_dirs as $name => $path) {
    if (!file_exists($path)) {
        echo "<p style='color: orange;'>⚠️ Directory $name doesn't exist</p>";
        if (mkdir($path, 0777, true)) {
            echo "<p style='color: green;'>✅ Created directory: $name</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to create directory: $name</p>";
        }
    } else {
        echo "<p style='color: green;'>✅ Directory exists: $name</p>";
    }
    
    if (is_writable($path)) {
        echo "<p style='color: green;'>✅ Directory is writable: $name</p>";
    } else {
        echo "<p style='color: red;'>❌ Directory is NOT writable: $name</p>";
    }
}

// Test file upload capability
$test_file = PLAYER_UPLOAD_PATH . 'test.txt';
if (file_put_contents($test_file, 'test')) {
    echo "<p style='color: green;'>✅ File upload test successful</p>";
    unlink($test_file);
} else {
    echo "<p style='color: red;'>❌ File upload test failed</p>";
}

// Check PHP settings
echo "<h3>PHP Settings</h3>";
echo "<p>Upload Max Filesize: " . ini_get('upload_max_filesize') . "</p>";
echo "<p>Post Max Size: " . ini_get('post_max_size') . "</p>";
echo "<p>Max File Uploads: " . ini_get('max_file_uploads') . "</p>";

// Test form submission simulation
echo "<h3>Test Registration Data</h3>";
$test_data = [
    'name' => 'Test Player',
    'email' => 'test' . time() . '@example.com',
    'phone' => '+1234567890',
    'date_of_birth' => '2005-01-01',
    'position' => 'Midfielder',
    'address' => 'Test Address',
    'emergency_contact_name' => 'Test Parent',
    'emergency_contact_phone' => '+1234567891',
    'medical_conditions' => 'None',
    'previous_clubs' => 'Test Club',
    'height' => 170,
    'weight' => 65,
    'bio' => 'Test bio'
];

try {
    $stmt = $pdo->prepare("INSERT INTO players (name, email, phone, date_of_birth, position, age_group, address, emergency_contact_name, emergency_contact_phone, medical_conditions, previous_clubs, height, weight, bio, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    
    $age = date_diff(date_create($test_data['date_of_birth']), date_create('today'))->y;
    $age_group = calculateAgeGroup($age);
    
    $stmt->execute([
        $test_data['name'], $test_data['email'], $test_data['phone'], 
        $test_data['date_of_birth'], $test_data['position'], $age_group,
        $test_data['address'], $test_data['emergency_contact_name'], 
        $test_data['emergency_contact_phone'], $test_data['medical_conditions'],
        $test_data['previous_clubs'], $test_data['height'], $test_data['weight'],
        $test_data['bio']
    ]);
    
    echo "<p style='color: green;'>✅ Test registration successful! Player ID: " . $pdo->lastInsertId() . "</p>";
    
    // Clean up test data
    $pdo->prepare("DELETE FROM players WHERE email = ?")->execute([$test_data['email']]);
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Test registration failed: " . $e->getMessage() . "</p>";
}

function calculateAgeGroup($age) {
    if ($age <= 8) return 'U8';
    if ($age <= 10) return 'U10';
    if ($age <= 12) return 'U12';
    if ($age <= 14) return 'U14';
    if ($age <= 16) return 'U16';
    return 'U18';
}

echo "<hr><h3>Next Steps:</h3>";
echo "<p>1. If all tests pass, try registering again</p>";
echo "<p>2. If any test fails, fix the issue and try again</p>";
echo "<p>3. Check your server error logs for more details</p>";
?>