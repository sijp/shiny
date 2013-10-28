<?php
require_once dirname(__FILE__)."/BasicText.php";

class ShinyMeme {

	private $img_src;
	private $textList;
	private $img;

	public function __construct($img){
		$this->img_src=$img;
		$this->img=CairoImageSurface::createFromPng($this->getImageSource());
		$this->textList=array();
	}

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

	public function getImageSource(){
		return $this->img_src;
	}

	public function draw(){
		$draw=new CairoContext($this->img);
		for ($i=0;$i<count($this->textList);$i++){
			$this->textList[$i]->annotate($draw);
		}
		return $this->img;
	}
}

