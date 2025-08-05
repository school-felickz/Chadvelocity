<?php
// sql_injection_demo.php
// DEMO: Deliberately vulnerable to SQL injection for SAST testing
// WARNING: This code contains intentional security vulnerabilities and should NOT be used in production

// Database connection - using similar structure to existing codebase
$mysqli = new mysqli("localhost", "cbent023", "", "cbent_db");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get user input from URL parameter - NO SANITIZATION (VULNERABLE)
$username = $_GET['username']; // User input directly used without validation

// VULNERABLE SQL QUERY - Direct string interpolation allows SQL injection
$query = "SELECT * FROM users WHERE username = '$username'";

echo "<html><head><title>SQL Injection Demo - VULNERABLE CODE</title></head><body>";
echo "<h1>User Lookup Demo (VULNERABLE TO SQL INJECTION)</h1>";
echo "<p><strong>WARNING:</strong> This page is intentionally vulnerable for security testing purposes.</p>";
echo "<p>Query being executed: <code>" . htmlspecialchars($query) . "</code></p>";

// Execute the vulnerable query
$result = $mysqli->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        echo "<h2>Results:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Username</th><th>Email</th><th>Role</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found.</p>";
    }
} else {
    echo "<p>Error in query: " . $mysqli->error . "</p>";
}

// Example of vulnerable usage
echo "<h2>Test this vulnerability:</h2>";
echo "<p>Try these payloads in the 'username' parameter:</p>";
echo "<ul>";
echo "<li><code>?username=admin</code> - Normal usage</li>";
echo "<li><code>?username=admin' OR '1'='1</code> - Basic SQL injection to dump all users</li>";
echo "<li><code>?username=admin'; DROP TABLE users; --</code> - SQL injection to drop table</li>";
echo "<li><code>?username=admin' UNION SELECT table_name,null,null FROM information_schema.tables --</code> - Information disclosure</li>";
echo "</ul>";

echo "<h3>Current URL:</h3>";
echo "<p><a href='?username=admin'>?username=admin</a></p>";
echo "<p><a href=\"?username=admin' OR '1'='1\">?username=admin' OR '1'='1</a></p>";

$mysqli->close();
echo "</body></html>";
?>