<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
<title>Minibooru install</title>
<?php
  $directorynotremoved = false;
  foreach(glob("./*.*") as $v)
    if(is_writable($v))
      unlink($v);
    else
      $directorynotremoved = true;
  if(!is_writable("."))
    $directorynotremoved = true;
  if(!$directorynotremoved)
    echo "<meta http-equiv=\"refresh\" content=\"3; url=../index.php?remove=true\">";
?>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="favorite icon" href="../favicon.png" />
</title>
</head>
<body id="main">
<h1>Minibooru install</h1>
<?php
  if($directorynotremoved) { 
?>
Couldn't remove install directory. You should do it manually and then <a href="../index.php?remove=true">Click here</a>
<?php
  }
  else {
?>
Install directory removed, redirecting you to <a href="../">Your booru</a>
<?php
  }
?>
</body>
</html>
