<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
<?php
  include 'config.php';
  $link = mysql_connect($mysql_host, $mysql_user, $mysql_password) or die('Could not connect: ' . mysql_error());
  mysql_select_db($mysql_database) or die('Could not select database');
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM `minibooru` WHERE `filename` = '$id' LIMIT 1";
    $result = mysql_query($query) or die(mysql_error());
    if($row = mysql_fetch_array($result)) {
      $titleext = $row['tags'];
    }
    else {
      $notfound = true;
      $titleext = "Not Found";
    }
    echo "<title>$title - $titleext";
  }
?>
</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="favorite icon" href="favicon.png" />
</title>
</head>
<body id="view">
<div id="header">
  <span style="font-size: 25px; font-weight: bold"><?php echo "$title"; ?></span>
  <div id="navbar">
    <a href="index.php">Home</a>
    <a href="search.php?s=new">Newest</a>
    <a href="upload.php">Upload</a>
    <a href="about.php">About</a>
  </div>
</div>
<div id="sidebar">
  <form action="search.php" method="get">
    <div id="searcharea">
      <input id="searchbox" name="q" size="22" type="text" /><br />
      <input id="searchbutton" type="submit" value="Search" />
    </div>
  </form>
  <div id="tags">
<?php
  $tags = explode(' ', $row['tags']);
  foreach($tags as $tag) {
    echo "<a href=\"search.php?q=$tag\">$tag</a><br />\n";
  }
?>
  </div>
</div>
<div id="content">
<?php
  $filename = $row['filename'];
  $width = $row['width'];
  $height = $row['height'];
  echo "<img src=\"$imagedir/$filename\" alt=\"$titleext\" title=\"$titleext\"><br />\n";
  echo "Width: $width Height: $height<br />\n";
  echo "<a href=\"remove.php?id=$filename\">Remove</a> <a href=\"edit.php?id=$filename\">Edit</a>\n";
?>
</div>
</body>
</html>
