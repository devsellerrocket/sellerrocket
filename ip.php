<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ip'])) {
    $ip = $_POST['ip'];
    $date = date("Y-m-d H:i:s");

    // ✅ OPTION 1: Save to MySQL
    $conn = new mysqli("localhost", "u827204564_ip_address", "Sellerrocket@1@1", "u827204564_ipaddress");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO visitor_logs (ip_address, visit_date) VALUES (?, ?)");
    $stmt->bind_param("ss", $ip, $date);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // ✅ OPTION 2 (alternative): Save to a text file
    // file_put_contents("visits.txt", "$ip - $date\n", FILE_APPEND);

    echo "IP logged: $ip";
} else {
    echo "No IP received.";
}
?>
