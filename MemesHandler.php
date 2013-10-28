<?php

class MemesHandler{
	private $dbhandler;
	
	public function __construct(){
		$this->dbhandler = new SQLite3("memes.db");
		$this->dbhandler->exec(	"CREATE TABLE IF NOT EXISTS ".
					"memes(id INTEGER PRIMARY KEY AUTOINCREMENT, ".
					"memename TEXT NOT NULL, ".
					"filename TEXT NOT NULL) ");
	}
	
	public function add($imgfile,$name){
		$stmt = $this->dbhandler->prepare("INSERT INTO memes(memename,filename) ".
						 "VALUES(:name,:imgfile)");
		$stmt->bindValue(":name",$name,SQLITE3_TEXT);
		$stmt->bindValue(":imgfile",$imgfile,SQLITE3_TEXT);
		$result=$stmt->execute();
		if (!$result)
			return false;
		return true;
	}
	
	public function getMemes(){
		$result = $this->dbhandler->query("SELECT id,memename FROM memes");
		$ret=array();
		while ($row = $result->fetchArray()){
			array_push($ret,$row);
		}
		return $ret;
	}
}
