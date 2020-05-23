<?php
namespace Zendvn\View\Helper;
use Zend\View\Helper\AbstractHelper;

class CmsLinkSort extends AbstractHelper {
	
	public function __invoke($name, $column, $ssFilter, $options = null){
	
		$order	= ($ssFilter['order'] == 'ASC') ? 'DESC' : 'ASC';
	
		$class	= 'sorting ' . $options['class'];
		if($ssFilter['order_by'] == $column){
			$class	= $options['class'] . ' sorting_' . strtolower($ssFilter['order']);
		}
	
		return sprintf('<th class="%s">
							<a href="#" onclick="javascript:sortList(\'%s\', \'%s\')">%s</a>
					   </th>', $class, $column, $order, $name);
	}
}