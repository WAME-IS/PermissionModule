<?php

namespace Wame\PermissionModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridItem;

class InheritByGridColumn extends BaseGridItem
{
    /** {@inheritDoc} */
	public function render($grid) {
		$grid->addColumnText('inheritBy', _('Inherit by'), 'inherit.name')
                ->setSortable()
				->setFilterText();
                
		return $grid;
	}
    
}