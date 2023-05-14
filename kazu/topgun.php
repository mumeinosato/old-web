<?php
$file_path = '/mnt/nas/share/web/topgun.mp4';
$mime_type = mime_content_type($file_path);
$file_size = filesize($file_path);

header('Content-Type: '.$mime_type);
header('Content-Length: '.$file_size);
header('Content-Disposition: inline; filename="topgun.mp4"');
header('Accept-Ranges: bytes');

readfile($file_path);
exit;
?>