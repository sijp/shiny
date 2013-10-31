<?php

/*
 * recieves a file filename, the meme's name memename via POST.
 * it then saves the file in the templates directory and adds it to the databse.
 */
require_once dirname(__FILE__)."/MemesHandler.php";

if ($_FILES["filename"]["error"]>0) die("Fatal Error in file upload!");

move_uploaded_file(	$_FILES["filename"]["tmp_name"],
			dirname(__FILE__)."/templates/".$_FILES["filename"]["name"]);
$memehandler = new MemesHandler();
$memehandler->add($_FILES["filename"]["name"],$_POST["memename"]);
?>
<!doctype html>

<html>
	<head>
		<meta content='text/html; charset=utf-8' http-equiv='Content-Type'>
		<title> SHINY </title>
		
	</head>
	<body>
		File uploaded successfully<br/>
		<img src="templates/<?=$_FILES["filename"]["name"]?>" />
	</body>
</html>
