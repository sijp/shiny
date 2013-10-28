<?php
require_once dirname(__FILE__) ."/ShinyMeme.php";

$memename=$_GET["memename"];
$title_top=$_GET["top_title"];
$title_bottom=$_GET["bottom_title"];
$meme=new ShinyMeme(dirname(__FILE__) . "/templates/$memename.png");
$meme->addText($title_top,0.05,0.1);
$meme->addText($title_bottom,0.85,0.1);
header('Content-Type: image/png');
$meme->draw()->writeToPng("php://output");

