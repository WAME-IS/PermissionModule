<?php

namespace Wame\PermissionModule\Models;

use Kdyby\Doctrine\EntityManager;
use Wame\PermissionModule\Models\PermissionObject;
use Wame\PermissionModule\Entities\RoleEntity;

class RoleLoader
{
    use \Nette\SmartObject;
    
    
    /** @var EntityManager */
    private $entityManager;
    
    
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    
    /**
     * Setup roles
     * 
     * @param PermissionObject $permission
     */
    public function setup(PermissionObject $permission)
    {
        $roles = $this->entityManager->getRepository(RoleEntity::class)->findBy([]);
        
        foreach($roles as $role) {
            $roleName = $role->getName();
            $inheritBy = $role->getInherit() ? [$role->getInherit()->getName()] : null;
            $permission->addRole($roleName, $inheritBy);
        }
    }
    
}