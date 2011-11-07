<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
<title>
<?php
  include 'config.php';
  echo "$title";
?>
<link rel="stylesheet" type="text/css" href="/style.css" />
<link rel="favorite icon" href="/favicon.png" />
</title>
</head>
<body id="main">
<h1><?php echo "$title"; ?></h2>
<div id="navbar">
  <a href="/search.php?s=new&amp;a=list">Newest</a>
  <a href="/upload.php">Upload</a>
  <a href="/settings.php">Settings</a>
  <a href="/about.php">About</a>
</div>
<form action="/search.php" method="get">
  <div>
    <input id="searchbox" name="q" size="30" type="text" />
    <input id="searchbutton" type="submit" value="Search" />
  </div>
</form>
<div id="footer">Running minibooru 0.1</div>
</body>
</html>
