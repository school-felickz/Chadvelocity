<?php
// setup_users_table.php
// Creates a users table for the SQL injection demo
// This is a helper file to set up test data for sql_injection_demo.php

$mysqli = new mysqli("localhost", "cbent023", "", "cbent_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "<html><head><title>Users Table Setup</title></head><body>";
echo "<h1>Setting up Users Table for SQL Injection Demo</h1>";

// Drop existing users table if it exists
$query = "DROP TABLE IF EXISTS users";
if ($mysqli->query($query)) {
    echo "<p>✓ Dropped existing users table</p>";
} else {
    echo "<p>Error dropping table: " . $mysqli->error . "</p>";
}

// Create users table
$query = "CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user'
)";

if ($mysqli->query($query)) {
    echo "<p>✓ Created users table</p>";
} else {
    echo "<p>Error creating table: " . $mysqli->error . "</p>";
}

// Insert sample data
$users = [
    ['admin', 'admin@example.com', 'administrator'],
    ['john_doe', 'john@example.com', 'user'],
    ['jane_smith', 'jane@example.com', 'user'],
    ['manager', 'manager@example.com', 'manager'],
    ['guest', 'guest@example.com', 'guest']
];

foreach ($users as $user) {
    $query = "INSERT INTO users (username, email, role) VALUES ('{$user[0]}', '{$user[1]}', '{$user[2]}')";
    if ($mysqli->query($query)) {
        echo "<p>✓ Inserted user: {$user[0]}</p>";
    } else {
        echo "<p>Error inserting user {$user[0]}: " . $mysqli->error . "</p>";
    }
}

echo "<h2>Setup Complete!</h2>";
echo "<p><a href='sql_injection_demo.php?username=admin'>Test the SQL Injection Demo</a></p>";

$mysqli->close();
echo "</body></html>";
?>