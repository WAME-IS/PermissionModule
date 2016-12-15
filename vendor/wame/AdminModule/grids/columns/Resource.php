<?php

namespace Wame\PermissionModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridItem;

class Resource extends BaseGridItem
{
    /** {@inheritDoc} */
	public function render($grid) {
		$grid->addColumnText('resource', _('Resource'));
                
		return $grid;
	}
    
}