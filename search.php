<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
<title>
<?php
  include 'config.php';
  echo "$title";
  if(isset($_GET['q'])) {
    $titleext = $_GET['q'];
    echo " - $titleext";
  }
?>
</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="favorite icon" href="favicon.png" />
</title>
</head>
<body id="search">
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
    <div>
      <input id="searchbox" name="q" size="25" type="text"
<?php
  if(isset($_GET['q']))
    echo "value=\"$_GET[q]\"";
?>
/><br />
      <input id="searchbutton" type="submit" value="Search" />
    </div>
  </form>
</div>
<div id="content">
<?php
$query = "SELECT filename, tags FROM minibooru ";
if(isset($_GET['q'])) {
  $keywords = explode(" ", $_GET['q']);
  $query .= "WHERE tags LIKE \"%$keywords[0]%\" ";
  for($i = 1; $i < count($keywords); $i++) {
    $query .= "AND tags LIKE \"%$keywords[$i]%\" ";
  }
}
if(isset($_GET['s'])) {
  switch($_GET['s']) {
    case "new":
      $query .= "ORDER BY date DESC ";
      break;
    case "old":
      $query .= "ORDER BY date ";
      break;
    default:
      $query .= "ORDER BY date DESC ";
      break;
  }
}
else {
  $query .= "ORDER BY date DESC ";
}
$query .= "LIMIT 10";
$result = mysql_query($query) or die(mysql_error());
if(!($row = mysql_fetch_array($result)))
  echo "<h2>Sorry! Nothing tagged with your search terms!</h2>";
while($row) {
  echo "<span class=\"thumb\"><a href=\"images/$row[filename]\"><img src=\"thumbnails/$row[filename]\" alt=\"$row[tags]\" title=\"$row[tags]\"></a></span>";
  $row = mysql_fetch_array($result);
}
?>
</div>
</body>
</html>
