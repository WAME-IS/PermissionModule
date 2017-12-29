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
        try {
            $roles = $this->entityManager->getRepository(RoleEntity::class)->findBy([]);

            if (count($roles)) {
                foreach ($roles as $role) {
                    $roleName = $role->getName();
                    $inheritBy = $role->getInherit() ? [$role->getInherit()->getName()] : null;
                    $permission->addRole($roleName, $inheritBy);
                }
            } else {
                $this->defaultRoles($permission);
            }
        } catch (\Exception $e) {
            $this->defaultRoles($permission);
        }
    }


    private function defaultRoles($permission)
    {
        $permission->addRole('guest');
        $permission->addRole('client', ['guest']);
        $permission->addRole('moderator', ['client']);
        $permission->addRole('admin', ['guest']);
    }

}
