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
<body id="upload">
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
      <input id="searchbox" name="q" size="22" type="text"
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
  if(!(isset($_FILES['file']) && isset($_POST['tags']))) {
?>
<form enctype="multipart/form-data" action="upload.php" method="POST">
  <input type="hidden" name="MAX_FILE_SIZE" value=3000000 />
  File: <input name="file" type="file" /><br />
  Tags:<br /><textarea name="tags" rows="10" cols="40" /></textarea><br />
  <input type="submit" value="Upload" /><br />
</form>
<?php
  }
  else {
    if($_FILES['file']['error'] != 0) {
      if($_FILES['file']['error'] == 2)
        echo "File too big.";
      else
        echo "Error uploading file, try again.";
    }
    else {
      $allowed_filetypes = array(".gif", ".jpg", ".jpeg", ".png", ".PNG", ".JPG", ".JPEG", ".GIF");
      $name = $_FILES['file']['name'];
      $ext = substr($name, strpos($name, '.'), strlen($name) - 1);
      if(!in_array($ext, $allowed_filetypes))
        echo "Unsupported filetype";
      else {
        $tags = $_POST['tags'];
        echo "<br />\n";
        $filename = md5_file($_FILES['file']['tmp_name']) . "$ext";
        $result = mysql_query("SELECT `filename` FROM `minibooru` WHERE `filename` = '$filename'") or die(mysql_error());
        if(mysql_fetch_array($result))
          echo "Duplicate file entry detected\n";
        else {
          if(!(is_writable($imagedir) && is_writable("thumbs")))
            $filename = "";
          if($filename && $filename != "" && move_uploaded_file($_FILES['file']['tmp_name'], "$imagedir/$filename")) {
            list($width, $height, $type, $attr) = getimagesize("$imagedir/$filename");
            $newa = explode(' ', $tags);
            sort($newa);
            $tags = implode(" ", $newa);
            $query = "INSERT INTO `minibooru`
                      VALUES ( '$filename', ' $tags ', $width, $height, NOW() )";
            mysql_query($query) or die(mysql_error());
            $image = new Imagick("$imagedir/$filename");
            $image->thumbnailImage(200, 200, true);
            $image->writeImage("thumbs/$filename");
            echo "File uploaded and added to database successfully\n";
          }
          else {
            echo "Could not move file to $imagedir or create thumbnail in thumbs/";
          }
        }
      }
    }
  }
?>
</div>
</div>
</body>
</html>
