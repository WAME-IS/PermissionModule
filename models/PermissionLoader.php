<?php

namespace Wame\PermissionModule\Models;

use Nette\Object;
use Wame\PermissionModule\Repositories\PermissionRepository;

class PermissionLoader extends Object 
{
	/** @var PermissionObject */
	private $permission;

    /** @var PermissionRepository */
    private $permissionRepository;
    
    
	public function __construct(PermissionObject $permission, PermissionRepository $permissionRepository) 
	{
		$this->permission = $permission;
		$this->permissionRepository = $permissionRepository;
	}

	public function setupPermissions() 
	{
		$permissions = $this->permissionRepository->find();
        
		foreach ($permissions as $permission) {
			if ($permission->tag == PermissionRepository::TAG_ALLOW) {
				$this->permission->allow($permission->role->getName(), $permission->resource, $permission->action);
			} elseif ($permission->tag == PermissionRepository::TAG_OWN) {
				$this->permission->allow($permission->role->getName(), $permission->resource, $permission->action . PermissionObject::ACESS_OWN_CHAR);
			} elseif ($permission->tag == PermissionRepository::TAG_DENY) {
				$this->permission->deny($permission->role->getName(), $permission->resource, $permission->action);
			}
		}
	}

}
