<?php
  function writeString($fileName, $msg) {
    if (file_exists($fileName)) {
      $size = @filesize($fileName);
      if ($size >= MAX_LOG_SIZE) {
        rename($fileName, LOG_DIR . '/' . date('YmdHis') . '.txt');
      }
    }
    
    if ($fh = @fopen($fileName, "a+")) {
      fputs($fh, $msg, strlen($msg));
      fclose($fh);
    }
  }

  function writeLine($fileName, $msg) {
    $msg = $msg . "\r"; 
    writeString($fileName, $msg);
  }

  function writeLogLine($fileName, $msg) {
    $msg = "[" . date('d-m-Y H:i:s') . "] " . $msg;
    writeLine($fileName, $msg);
  }

  function writeLog($msg) {
    if (DEBUG) {
      writeLogLine(LOG_FILE, $msg);
    }
  }

  function writeError($msg) {
    writeLogLine(ERROR_FILE, $msg);
  }
  