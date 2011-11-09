<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
<title>
<?php
  if(isset($_GET['remove'])) {
    rmdir("./install/");
  }
  if(file_exists('config.php')) {
    include 'config.php';
    echo "$title";
?>
</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="favorite icon" href="favicon.png" />
</head>
<body id="main">
<h1><?php echo "$title"; ?></h1>
<div id="navbar">
  <a href="index.php">Home</a>
  <a href="search.php?s=new">Newest</a>
  <a href="upload.php">Upload</a>
  <a href="about.php">About</a>
</div>
<form action="search.php" method="get">
  <div>
    <input id="searchbox" name="q" size="30" type="text" />
    <input id="searchbutton" type="submit" value="Search" />
  </div>
</form>
<div id="footer">Running minibooru 0.1</div>
<?php
  }
  else {
?>
No config!</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="favorite icon" href="favicon.png" />
</head>
<body id="main">
<h1>No config.php!</h1>
There doesn't appear to be a config.php file present. This file is necessary for proper operation of the site.<br />
If this is a new install, you can <a href="install">click here</a> to make one. If not, you should re-download<br />
<a href="https://github.com/rippinblaise/minibooru">minibooru</a>
<?php
  }
?>
</body>
</html>
