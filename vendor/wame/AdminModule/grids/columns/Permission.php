<?php

namespace Wame\PermissionModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridItem;
use Wame\PermissionModule\Repositories\PermissionRepository;
use Wame\PermissionModule\Entities\PermissionEntity;
use Wame\PermissionModule\Repositories\RoleRepository;

class Permission extends BaseGridItem
{
    const TAG_ALLOWED = 'a';
    const TAG_DENIED = 'd';
    
    
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
                    $data = $grid->getDataModel()->getDataSource()->getData();
                    $item = &$data[$id];
                    
                    $role = $this->roleRepository->get(['id' => $grid->getPresenter()->id]);
                    
                    $permission = $this->permissionRepository->get([
                        'resource' => $item['resource'], 
                        'action' => $item['action'], 
                        'role' => $role
                    ]);
                    
                    $tag = $newValue ? self::TAG_ALLOWED : self::TAG_DENIED;
                    
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
                    
                    $item['permission'] = $newValue;
                    $grid->setDataSource($data);
                    $grid->redrawItem($id);
                };
                
		return $grid;
	}
    
}