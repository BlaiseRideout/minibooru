<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
<title>
<?php
  include 'config.php';
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    echo "$title - Edit $id";
    $noid = 0;
  }
  else {
    echo "$title - Not found";
    $noid = 1;
  }
?>
</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="favorite icon" href="favicon.png" />
</title>
</head>
<body id="edit">
<?php
  $link = mysql_connect($mysql_host, $mysql_user, $mysql_password) or die('Could not connect: ' . mysql_error());
  mysql_select_db($mysql_database) or die('Could not select database');
?>
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
</div>
<div id="content">
<?php
  if($noid) {
    echo "Couldn't find image to edit\n";
  }
  else {
    $query = "SELECT * FROM `minibooru` WHERE `filename` = '$id' LIMIT 1";
    $result = mysql_query($query) or die(mysql_error());
    $row = mysql_fetch_array($result);
    if(isset($_GET['new'])) {
      $newu = $_GET['new'];
      $newa = explode(' ', $newu);
      sort($newa);
      $new = implode(" ", $newa);
      $query = "UPDATE `minibooru` SET `tags` = ' $new ' WHERE `filename` = '$id' LIMIT 1";
      $result = mysql_query($query) or die(mysql_error());
      echo "Updated tags successfully<br />\n";
    }
    else {
      $tags = $tags = substr($row['tags'], 1, strlen($row['tags']) - 2);
      echo "<img src=\"$imagedir/$id\" alt=\"$tags\" title=\"$tags\"><br />\n"
?>
<form action="edit.php" method="GET">
Tags:<br /><textarea name="new" rows="10" cols="40">
<?php
    echo "$tags</textarea><br />\n";
    echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />";
?>
<input type="submit" value="Update" /><br />
</form>
<?php
    }
  }
?>
</div>
</div>
</body>
</html>
