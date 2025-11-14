<?php
$zipFilePath = 'test.7z';
$extractToPath = 'public/';
$command = "p7zip-src/7zz x $zipFilePath -o$extractToPath";
$output = shell_exec($command);
echo "<pre>$output</pre>";