<?php


/*
 * handles the Database for storing the installed
 * memes. 
 */

class MemesHandler{
	private $dbhandler;
	
	/*
	 * opens a connection to the database. If the database was not initialized
	 * with the memes table, then creates it as well.
	 */
	
	public function __construct(){
		$this->dbhandler = new SQLite3("memes.db");
		$this->dbhandler->exec(	"CREATE TABLE IF NOT EXISTS ".
					"memes(id INTEGER PRIMARY KEY AUTOINCREMENT, ".
					"memename TEXT NOT NULL, ".
					"filename TEXT NOT NULL) ");
	}
	
	/*
	 * adds the meme with the image file $imgfile and Name(description) $name to the database
	 * on error, returns false, otherwise true.
	 */
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

	
	/*
	 * searches for an image file name whose meme id is $id.
	 * if no such meme exists, returns false otherwise returns the file name.
	 */
	public function getFileNameById($id){
		$stmt = $this->dbhandler->prepare("select filename FROM memes WHERE id=:id");
		$stmt->bindValue(":id",$id,SQLITE3_TEXT);
		$result=$stmt->execute();
		$filename=$result->fetchArray();
		if (!$filename)
			return false;
		return $filename["filename"];
	}
	
	/*
	 * returns an array with the id's and names(descriptions) of all memes
	 * from the databse (untouched records).
	 */
	
	public function getMemes(){
		$result = $this->dbhandler->query("SELECT id,memename FROM memes");
		$ret=array();
		while ($row = $result->fetchArray()){
			array_push($ret,$row);
		}
		return $ret;
	}
}
