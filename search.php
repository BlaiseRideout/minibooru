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
    <div id="searcharea">
      <input id="searchbox" style="width: 96%" name="q" type="text"
<?php
  if(isset($_GET['q']))
    echo "value=\"$_GET[q]\"";
?>/><br />
      <input id="searchbutton" type="submit" value="Search" />
    </div>
  </form>
</div>
<div id="content">
<?php
if(isset($_GET['q'])) {
  $keywords = explode(" ", $_GET['q']);
  $query = "WHERE tags LIKE \"% $keywords[0] %\" ";
  for($i = 1; $i < count($keywords); $i++) {
    $query .= "AND tags LIKE \"% $keywords[$i] %\" ";
  }
}
else {
  $query = "";
}
$numimagesquery = "SELECT COUNT(*) FROM minibooru " . $query;
$query = "SELECT filename, tags FROM minibooru " . $query;
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
if(isset($_GET['p'])) {
  $page = $_GET['p'] * 20;
}
else {
  $page = 0;
}
$query .= "LIMIT ";
$query .= "$page";
$query .= ",20";
$numimagesres = mysql_query($numimagesquery) or die(mysql_error());
$numimagesarr = mysql_fetch_array($numimagesres);
$numimages = $numimagesarr[0];
if($numimages == 0)
  echo "<h2>Sorry! Nothing tagged with your search terms!</h2>\n";
else {
  echo "Number of results: $numimages\n<br />\n<div id=\"thumbs\">\n";
  $result = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_array($result);
  while($row) {
    $tags = substr($row['tags'], 1, strlen($row['tags']) - 2);
    echo "<span class=\"thumb\"><a href=\"view.php?id=$row[filename]\"><img src=\"thumbs/$row[filename]\" alt=\"$tags\" title=\"$row[tags]\"></a></span>\n";
    $row = mysql_fetch_array($result);
  }
  echo "</div>\n<br /><span id=\"pages\">\n";
  $numpages = floor($numimages / 20);
  $page /= 20;
  if($page != 0) {
    echo "<a href=\"search.php?p=";
    echo $page - 1;
    if(isset($_GET['q']))
      echo "&q=" . $_GET['q'];
    if(isset($_GET['s']))
      echo "&s=" . $_GET['s'];
    echo "\"><</a>\n";
  }
  else {
    echo "<\n";
  }
  if($numpages != 0) {
    for($i = $numpages - 5, $numprinted = 0; $i <= $numpages && $numprinted <= 10; $i++, $numprinted++) {
      if($i < 0)
        $i = 0;
      if($i == $page)
        echo "$i\n";
      else {
        echo "<a href=\"search.php?p=$i";
        if(isset($_GET['q']))
          echo "&q=" . $_GET['q'];
        if(isset($_GET['s']))
          echo "&s=" . $_GET['s'];
        echo "\">$i</a>\n";
      }
    }
  }
  else {
    echo "0\n";
  }
  if($numpages > $page) {
    echo "<a href=\"search.php?p=";
    echo $page + 1;
    if(isset($_GET['q']))
      echo "&q=" . $_GET['q'];
    if(isset($_GET['s']))
      echo "&s=" . $_GET['s'];
    echo "\">></a>\n";
  }
  else {
    echo ">\n";
  }
  echo "</span>";
}
?>
</div>
</body>
</html>
