<?php
$imageUrl = "https://sellerrocket.in/img/team/ceo-4.webp"; // full URL of your image
$nextjsUrl = "http://localhost:3000/try-on1";
?>

<button onclick="window.location.href='<?php echo $nextjsUrl . "?image=" . urlencode($imageUrl); ?>'">
    Send Image to Next.js
</button>
