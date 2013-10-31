<?php

/*
 *	This class is represents a text box that should be rendered on a Cairo Context
 *
 */

class BasicText{

	private $text;
	private $x;
	private $y;
	private $w;
	private $h;

	public function __construct($text){
		$this->text=$text;
	}

	/*
	 * setups the (x,y) coordinates of the text pox on the cairo context
	 */
	public function setPosition($x,$y){
		$this->x=$x;
		$this->y=$y;
	}
	
	/*
	 * returns an associative array which represents the coordinates of this text box
	 * "x"=>x coordinate , "y"=> y coordinate
	 */

	public function getPosition(){
		return array("x"=>$this->x,"y"=>$this->y);
	}
	
	/*
	 * sets the width and height of the text box.
	 */

	public function setDimensions($width,$height){
		$this->w=$width;
		$this->h=$height;
	}

	
	/*
	 * returns the text that would be rendered in the text box
	 */
	public function getText(){
		return $this->text;
	}
	
	/*
	 * this function returns the optimal font size to be rendered, so 
	 * the entire text would fit inside the text box dimensions.
	 */

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
	
	/*
	 * this function recieves a PangoLayout $layout, CairoContext $context and a $fontsize
	 * and uses the $layout to transform the text to a drawable path on $context
	 */

	private function renderOnContext($layout,$context,$fontsize){
		$desc=new PangoFontDescription("Impact,Maka, $fontsize");
		$layout->setFontDescription($desc);
		$layout->setAlignment(PANGO_ALIGN_CENTER);
		$context->moveTo($this->x,$this->y);
		$layout->layoutPath($context);
	}
	
	/*
	 * draws the text on top of the CairoContext $context
	 */

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

