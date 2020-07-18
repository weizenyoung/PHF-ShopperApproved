<?php
  require("../app/init.php");
  $content = @file_get_contents(ERROR_FILE);
  echo "<code><pre>" . htmlspecialchars($content) . "</pre></code>";