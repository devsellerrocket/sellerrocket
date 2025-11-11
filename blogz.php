<?php
// Connect to the database
$mysqli = new mysqli("localhost", "u827204564_developers", "X~pms=Dm7", "u827204564_leaduserslist");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch the last row
$sql = "SELECT * FROM blogs ORDER BY id DESC LIMIT 1";
$result = $mysqli->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $heading = $row['heading'];
    $description = $row['description'];
    $publish_date = date("M j, Y", strtotime($row['publish_date']));
    $url = $row['url']; // Optional: Add a column in DB if dynamic URL needed
    echo '
    <h2 class="font-weight-semibold text-5 line-height-6 mt-3 mb-2">
        <a href="' . $url . '">' . htmlspecialchars($heading) . '</a>
    </h2>
    <p>' . $publish_date . '</p>
    <p style="text-align: justify;">' . htmlspecialchars($description) . '</p>
    ';
} else {
    echo "<p>No articles found.</p>";
}

$mysqli->close();
?>
