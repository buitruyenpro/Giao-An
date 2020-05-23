<?php
namespace Zendvn\Filter;

use Zend\Filter\FilterInterface;

class RemoveCircumflex implements FilterInterface {

	
	public function filter($value){
		/*a Ã  áº£ Ã£ Ã¡ áº¡ Äƒ áº± áº³ áºµ áº¯ áº· Ã¢ áº§ áº© áº« áº¥ áº­ b c d Ä‘ e Ã¨ áº» áº½ Ã© áº¹ Ãª á»� á»ƒ á»… áº¿ á»‡ 
		f g h i Ã¬ á»‰ Ä© Ã­ á»‹ j k l m n o Ã² á»� Ãµ Ã³ á»� Ã´ á»“ á»• á»— á»‘ á»™ Æ¡ á»� á»Ÿ á»¡ á»› á»£ 
		p q r s t u Ã¹ á»§ Å© Ãº á»¥ Æ° á»« á»­ á»¯ á»© á»± v w x y á»³ á»· á»¹ Ã½ á»µ z*/
		
		$charaterA			= '#(Ã¡|Ã |áº£|Ã£|áº¡|Äƒ|áº¯|áº·|áº±|áº³|áºµ|Ã¢|áº¥|áº§|áº©|áº«|áº­|Ã�|Ã€|áº¢|Ãƒ|áº |Ä‚|áº®|áº¶|áº°|áº²|áº´|Ã‚|áº¤|áº¦|áº¨|áºª|áº¬)#imsU';
		$replaceCharaterA	= 'a';
		$value	= preg_replace($charaterA, $replaceCharaterA, $value);
		
		$charaterD 			= '#(Ä‘|Ä�)#imsU';
		$replaceCharaterD 	= 'd';
		$value = preg_replace($charaterD,$replaceCharaterD,$value);
		
		$charaterE 			= '#(Ã©|Ã¨|áº»|áº½|áº¹|Ãª|áº¿|á»�|á»ƒ|á»…|á»‡|Ã‰|Ãˆ|áºº|áº¼|áº¸|ÃŠ|áº¾|á»€|á»‚|á»„|á»†)#imsU';
		$replaceCharaterE 	= 'e';
		$value = preg_replace($charaterE,$replaceCharaterE,$value);
		
		$charaterI 			= '#(Ã­|Ã¬|á»‰|Ä©|á»‹|Ã�|ÃŒ|á»ˆ|Ä¨|á»Š)#imsU';
		$replaceCharaterI 	= 'i';
		$value = preg_replace($charaterI,$replaceCharaterI,$value);
		
		$charaterO = '#(Ã³|Ã²|á»�|Ãµ|á»�|Ã´|á»‘|á»“|á»•|á»—|á»™|Æ¡|á»›|á»�|á»Ÿ|á»¡|á»£|Ã“|Ã’|á»Ž|Ã•|á»Œ|Ã”|á»�|á»’|á»”|á»–|á»˜|Æ |á»š|á»œ|á»ž|á» |á»¢)#imsU';
		$replaceCharaterO = 'o';
		$value = preg_replace($charaterO,$replaceCharaterO,$value);
		
		$charaterU = '#(Ãº|Ã¹|á»§|Å©|á»¥|Æ°|á»©|á»«|á»­|á»¯|á»±|Ãš|Ã™|á»¦|Å¨|á»¤|Æ¯|á»¨|á»ª|á»¬|á»®|á»°)#imsU';
		$replaceCharaterU = 'u';
		$value = preg_replace($charaterU,$replaceCharaterU,$value);
		
		$charaterY = '#(Ã½|á»³|á»·|á»¹|á»µ|Ã�|á»²|á»¶|á»¸|á»´)#imsU';
		$replaceCharaterY = 'y';
		$value = preg_replace($charaterY,$replaceCharaterY,$value);
		
		return $value;
	}
}