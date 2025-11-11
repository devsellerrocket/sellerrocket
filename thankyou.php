<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>
</head>
<body>
    <h2>Thank you for submitting the form!</h2>
    <p>Your download will start shortly. If it doesn't, <a href="https://drive.usercontent.google.com/u/0/uc?id=1fq9ia7b3EC2BM9u7cM0yndkHrT2hJQ-Q&export=download">click here</a>.</p>

    <?php
    if (isset($_GET['download']) && $_GET['download'] === 'true') {
        echo "<script>
            window.onload = function() {
                const link = document.createElement('a');
                link.href = 'https://drive.usercontent.google.com/u/0/uc?id=1fq9ia7b3EC2BM9u7cM0yndkHrT2hJQ-Q&export=download';
                link.download = 'SellerRocket-Free-Audit.pdf';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            };
        </script>";
    }
    ?>
</body>
</html>
