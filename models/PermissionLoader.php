<?php

namespace Wame\PermissionModule\Models;

use Nette\Object;
use Kdyby\Doctrine\EntityManager;
use Wame\PermissionModule\Repositories\PermissionRepository;
use Wame\PermissionModule\Models\PermissionObject;
use Wame\PermissionModule\Entities\PermissionEntity;

class PermissionLoader extends Object 
{
	/** @var EntityManager */
    private $entityManager;
    
    
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    

	public function setup(PermissionObject $permissionObject) 
	{
		$permissions = $this->entityManager->getRepository(PermissionEntity::class)->findBy([]);
        
		foreach ($permissions as $permission) {
			if ($permission->tag == PermissionRepository::TAG_ALLOW) {
				$permissionObject->allow($permission->role->getName(), $permission->resource, $permission->action);
			} elseif ($permission->tag == PermissionRepository::TAG_OWN) {
				$permissionObject->allow($permission->role->getName(), $permission->resource, $permission->action . PermissionObject::ACESS_OWN_CHAR);
			} elseif ($permission->tag == PermissionRepository::TAG_DENY) {
				$permissionObject->deny($permission->role->getName(), $permission->resource, $permission->action);
			}
		}
	}

}
