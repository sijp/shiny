<?php
require_once dirname(__FILE__) ."/ShinyMeme.php";
require_once dirname(__FILE__) ."/MemesHandler.php";
$memeid=$_GET["memeid"];
$title_top=$_GET["top_title"];
$title_bottom=$_GET["bottom_title"];
$dbhandler=new MemesHandler();
$filename=$dbhandler->getFileNameById($memeid);


$meme=new ShinyMeme(dirname(__FILE__) . "/templates/$filename");
$meme->addText($title_top,0.05,0.1);
$meme->addText($title_bottom,0.85,0.1);
header('Content-Type: image/png');
$meme->draw()->writeToPng("php://output");

