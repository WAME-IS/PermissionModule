<?php

namespace Wame\PermissionModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;

class InheritByGridColumn extends BaseGridColumn
{
	public function addColumn($grid) {
		$grid->addColumnText('inheritBy', _('Inherit by'), 'inherit.name')
                ->setSortable()
				->setFilterText();
                
		return $grid;
	}
    
}