<?php

require_once dirname(__FILE__)."/MemesHandler.php";

$handler=new MemesHandler();

print_r($handler->getMemes());
