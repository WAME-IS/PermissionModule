<?php

namespace Wame\PermissionModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridItem;

class Action extends BaseGridItem
{
    /** {@inheritDoc} */
	public function render($grid) {
		$grid->addColumnText('action', _('Action'));
                
		return $grid;
	}
    
}