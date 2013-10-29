<?php

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
