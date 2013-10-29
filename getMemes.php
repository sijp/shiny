<?php

require_once dirname(__FILE__)."/MemesHandler.php";

$handler=new MemesHandler();

$dict=$handler->getMemes();
$jsonable=array();
foreach ($record as $dict){
	array_append(	$jsonable,
			array(	"id"=>$record["id"],
				"description"=>$record["nmemeame"]));
}

echo json_encode($jsonable);
