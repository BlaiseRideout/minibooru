<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
<title>
<?php
  include 'config.php';
  echo "$title";
?>
</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="favorite icon" href="favicon.png" />
</title>
</head>
<body id="main">
<h2>About <?php echo "$title"; ?></h2>
<div id="navbar">
  <a href="index.php">Home</a>
  <a href="search.php?s=new">Newest</a>
  <a href="upload.php">Upload</a>
  <a href="about.php">About</a>
</div><br />
<?php
  $link = mysql_connect($mysql_host, $mysql_user, $mysql_password) or die('Could not connect: ' . mysql_error());
  mysql_select_db($mysql_database) or die('Could not select database');  
  $result = mysql_query("SELECT COUNT(*) FROM minibooru") or die(mysql_error());
  $numimages = mysql_fetch_array($result);
  echo "Total number of images in database: $numimages[0]\n";
?>
<br /><br />
This booru runs on <a href="https://github.com/rippinblaise/minibooru">minibooru</a>
</body>
</html>
