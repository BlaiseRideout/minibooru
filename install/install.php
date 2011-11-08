<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
<title>Minibooru install</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="favorite icon" href="../favicon.png" />
</title>
</head>
<body id="main">
<?php
  if(!(isset($_POST['title']) && isset($_POST['imagedir']) && isset($_POST['dbname']) && isset($_POST['uname']) && isset($_POST['upass']) && isset($_POST['dbhost']))) {
?>
<form method="post" action="install.php">
<table align="center">
  <tr>
    <td>Name of booru</td>
    <td><input name="title" type="text" size="30" value="My booru"></td>
    <td>The name of your booru</td>
  </tr>
  <tr>
    <td>Image directory</td>
    <td><input name="imagedir" type="text" size="30" value="images/"></td>
    <td>Directory your images are stored in, relative to the directory you installed minibooru to</td>
  </tr>
  <tr>
    <td>Database name</td>
    <td><input name="dbname" type="text" size="30" value="mybooru"></td>
    <td>The name of the database minibooru should use</td>
  </tr>
  <tr>
    <td>User name</td>
    <td><input name="uname" type="text" size="30" value="mybooru"></td>
    <td>The MySQL username that has access to your database</td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input name="upass" type="text" size="30" value="password"></td>
    <td>The password to the username above</td>
  </tr>
  <tr>
    <td>Database host</td>
    <td><input name="dbhost" type="text" size="30" value="localhost"></td>
    <td>Hostname to access your MySQL server</td>
  </tr>
</table>
<input type="submit" value="Continue" />
</form>
<?php
  }
  else {
    $title = $_POST['title'];
    $imagedir = $_POST['imagedir'];
    $host = $_POST['dbhost'];
    $dbname = $_POST['dbname'];
    $uname = $_POST['uname'];
    $pass = $_POST['upass'];
    $link = mysql_connect($host, $uname, $pass) or die("Couldn't connect to to mysql: " . mysql_error() . "<br />Double check your information and <a href=\"install.php\">re-enter</a> it.");
    mysql_select_db($dbname) or die("Couldn't select database $dbname. Double check your mysql information and <a href=\"install.php\">re-enter</a> it.");
    $query = "CREATE TABLE minibooru ( filename TEXT NOT NULL, tags TEXT NOT NULL, width INT UNSIGNED NOT NULL, height INT UNSIGNED NOT NULL, date DATETIME NOT NULL)";
    mysql_query($query) or die("Coludn't create table minibooru: " . mysql_error() .
      "<br />Double check your information and <a href=\"install.php\">re-enter</a> it.");
    mysql_close($link);
    if(!is_writable("../config.php")) {
?>
Couldn't write to config file. Paste the following into it or get write permissions:<br />
<textarea cols="30" rows="9">
<?php
  echo "<?php\n";
  echo "\$title = \"$title\";\n";
  echo "\$imagedir = \"$imagedir\";\n\n";

  echo "\$mysql_host = \"$host\";\n";
  echo "\$mysql_database = \"$dbname\";\n";
  echo "\$mysql_user = \"$uname\";\n";
  echo "\$mysql_password = \"$pass\";\n?>";
  echo "</textarea>\n<br />";
  echo "When finished, <a href=\"remove.php\">Click here</a>\n";
}
else {
  $conffile = fopen("../config.php", "w");
  fwrite($conffile, "<?php\n");
  fwrite($conffile, "\$title = \"$title\";\n");
  fwrite($conffile, "\$imagedir = \"$imagedir\";\n\n");
  fwrite($conffile, "\$mysql_host = \"$host\";\n");
  fwrite($conffile, "\$mysql_database = \"$dbname\";\n");
  fwrite($conffile, "\$mysql_user = \"$uname\";\n");
  fwrite($conffile, "\$mysql_password = \"$pass\";\n?>\n");
?>
Config file written. <a href="remove.php">Click here</a>
<?php
} }
?>
</body>
</html>
