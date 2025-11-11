<!DOCTYPE html>
<html>
<head>
  <title>User IP Info</title>
</head>
<body>
  <h2>User IP Details</h2>
  <pre>
<?php
// MySQL DB config
$host = 'localhost';
$user = 'u827204564_ip_address';
$pass = 'Sellerrocket@1@1';
$dbname = 'u827204564_ipaddress';

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// Fetch all IPs from the user_visits table
$sql = "SELECT distinct ip_address FROM user_visits";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ip = $row['ip_address'];

        // Get IP geolocation info from ip-api.com
        $json = @file_get_contents("http://ip-api.com/json/{$ip}");

        if ($json !== false) {
            $data = json_decode($json, true);

            if ($data['status'] === 'success') {
                echo "IP: " . $data['query'] . "\n";
                echo "City: " . $data['city'] . "\n";
                echo "Region: " . $data['regionName'] . "\n";
                echo "Country: " . $data['country'] . "\n";
                echo "ISP: " . $data['isp'] . "\n";
                echo "--------------------------\n";
            } else {
                echo "IP: $ip - Failed to get location info.\n";
            }
        } else {
            echo "IP: $ip - Could not connect to IP API.\n";
        }
    }
} else {
    echo "No records found.";
}

$conn->close();
?>
  </pre>
</body>
</html>
