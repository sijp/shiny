<?php

class BasicText{

	private $text;
	private $x;
	private $y;
	private $w;
	private $h;

	public function __construct($text){
		$this->text=$text;
	}

	public function setPosition($x,$y){
		$this->x=$x;
		$this->y=$y;
	}

	public function getPosition(){
		return array("x"=>$this->x,"y"=>$this->y);
	}

	public function setDimensions($width,$height){
		$this->w=$width;
		$this->h=$height;
	}

	public function getText(){
		return $this->text;
	}

	private function getFontSize($layout){
		$newsize=10;
		do{
			$desc=new PangoFontDescription("Impact,Maka, $newsize");
			$layout->setFontDescription($desc);
			$s=$layout->getPixelExtents();
			#print_r($s);
			$newsize+=8;
		}while ($s["ink"]["height"]<$this->h);
		$newsize=$newsize*80/100;
		return $newsize;
	}

	private function renderOnContext($layout,$context,$fontsize){
		$desc=new PangoFontDescription("Impact,Maka, $fontsize");
		$layout->setFontDescription($desc);
		$layout->setAlignment(PANGO_ALIGN_CENTER);
		$context->moveTo($this->x,$this->y);
		$layout->layoutPath($context);
	}

	public function annotate($context){
		#init layout with text
		$layout=new PangoLayout($context);
		$layout->setWidth($this->w*PANGO_SCALE);
		$layout->setMarkup($this->getText());

		#calcualte font size
		$newsize=$this->getFontSize($layout);
	
		#render black outline
		$this->renderOnContext($layout,$context,$newsize);
		$context->setSourceRGB(0,0,0);
		$context->setLineWidth(10);
		$context->setLineJoin(CAIRO_LINE_JOIN_ROUND);
		$context->stroke();
		
		#render white fill
		$this->renderOnContext($layout,$context,$newsize);
		$context->setSourceRGB(1,1,1);
		$context->fill();
	}
}

