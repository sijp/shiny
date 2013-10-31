<?php
require_once dirname(__FILE__)."/BasicText.php";


/*
 * A representation of a Meme, has a list of text elements (BasicText) and a image file.
 */

class ShinyMeme {

	private $img_src;
	private $textList;
	private $img;

	
	/*
	 * constructs a meme objects for the image file path $img
	 */
	public function __construct($img){
		$this->img_src=$img;
		$this->img=CairoImageSurface::createFromPng($this->getImageSource());
		$this->textList=array();
	}

	
	/*
	 * adds a text box with the text $txt, Vertical Position(y) $verticalPos
	 * and Height $height. The Horizontal Position(x) and width are calcualted
	 * automatically by the image properties.
	 */
	 
	public function addText($txt,$verticalPos,$height){
		$btext=new BasicText($txt);

		$x=$this->img->getWidth()*0.05;
		$y=$this->img->getHeight()*$verticalPos;
		$w=$this->img->getWidth()*0.9;
		$h=$this->img->getHeight()*$height;

		$btext->setPosition($x,$y);
		$btext->setDimensions($w,$h);
		array_push($this->textList,$btext);
	}
	
	/*
	 * returns the image file path 
	 */

	public function getImageSource(){
		return $this->img_src;
	}
	
	/*
	 * annotates all text elements on top of the image.
	 * and returns it. This method does not work on a copied context.
	 */

	public function draw(){
		$draw=new CairoContext($this->img);
		for ($i=0;$i<count($this->textList);$i++){
			$this->textList[$i]->annotate($draw);
		}
		return $this->img;
	}
}

