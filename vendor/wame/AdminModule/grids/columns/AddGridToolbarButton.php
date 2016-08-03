<?php

namespace Wame\PermissionModule\Vendor\Wame\AdminModule\Grids\Columns;

class AddGridToolbarButton extends \Wame\DataGridControl\BaseGridColumn
{
	public function addColumn($grid)
    {
        $grid->addToolbarButton(":{$grid->presenter->getName()}:create", _('Create role'))
                ->setIcon('fa fa-plus')
                ->setClass('btn btn-success');
                
		return $grid;
	}
}