<?php
/*
 * returns a JSON formatted structure that represents
 * all the installed memes in the system.
 * new memes can be installed via uploadMeme.php
 */
require_once dirname(__FILE__)."/MemesHandler.php";

$handler=new MemesHandler();

$dict=$handler->getMemes();
$jsonable=array();
foreach ($dict as $record){
	array_push(	$jsonable,
			array(	"id"=>$record["id"],
				"description"=>$record["memename"]));
}
header("Content-Type: Application/json");
echo json_encode($jsonable);
