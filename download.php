<?php
$fileUrl = "https://drive.usercontent.google.com/u/0/uc?id=1fq9ia7b3EC2BM9u7cM0yndkHrT2hJQ-Q&export=download";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Free-Audit-Checklist.pdf");
readfile($fileUrl);
exit;
?>
