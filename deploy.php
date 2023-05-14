<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $output = shell_exec('sh /home/mumeinosato/webdeploy.sh');
  echo "<pre>$output</pre>";
}
?>

