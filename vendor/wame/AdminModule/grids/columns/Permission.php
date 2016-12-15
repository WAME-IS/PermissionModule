<?php

namespace Wame\PermissionModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridItem;
use Wame\PermissionModule\Repositories\PermissionRepository;
use Wame\PermissionModule\Entities\PermissionEntity;
use Wame\PermissionModule\Repositories\RoleRepository;

class Permission extends BaseGridItem
{
    /** @var PermissionRepository */
    private $permissionRepository;
    
    /** @var RoleRepository */
    private $roleRepository;
    
    
    public function __construct(
        PermissionRepository $permissionRepository,
        RoleRepository $roleRepository
    ) {
        $this->permissionRepository = $permissionRepository;
        $this->roleRepository = $roleRepository;
    }
    
    
    /** {@inheritDoc} */
	public function render($grid)
    {
		$grid->addColumnStatus('permission', _('Permission'))
                ->addOption(1, _('Allowed'))
                    ->setIcon('check')
                    ->setClass('btn-success')
                    ->endOption()
                ->addOption(0, _('Denied'))
                    ->setIcon('close')
                    ->setClass('btn-danger')
                    ->endOption()
                ->onChange[] = function($id, $newValue) use ($grid) {
                    $item = $grid->getDataModel()->getDataSource()->getData()[$id];
                    
                    $role = $this->roleRepository->get(['id' => $grid->getPresenter()->id]);
                    $permission = $this->permissionRepository->get(['resource' => $item['resource'], 'action' => $item['action'], 'role' => $role]);
                    
                    $tag = $newValue ? 'a' : 'd';
                    
                    if($permission) {
                        $permission->setTag($tag);
                        
                        $this->permissionRepository->update($permission);
                    } else {
                        $permission = new PermissionEntity();
                        $permission->setRole($role);
                        $permission->setResource($item['resource']);
                        $permission->setAction($item['action']);
                        $permission->setTag($tag);
                        $permission->setStatus(PermissionRepository::STATUS_ENABLED);
                        
                        $this->permissionRepository->create($permission);
                    }
                };
                
		return $grid;
	}
    
}