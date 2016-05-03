<?php

namespace Wame\PermissionModule\Models;

use Nette\Object;
use Kdyby\Doctrine\EntityManager;
use Wame\PermissionModule\Entities\PermissionEntity;
use Wame\PermissionModule\Repositories\PermissionRepository;

class PermissionLoader extends Object 
{
	/** @var PermissionObject */
	private $permission;

	/** @var EntityManager */
	/*
	 * ! WARNING !
	 * Chceme pouzivat pristup cez repository?
	 */
	private $entityManager;

	public function __construct(PermissionObject $permission, EntityManager $entityManager) 
	{
		$this->permission = $permission;
		$this->entityManager = $entityManager;
	}

	public function setupPermissions() 
	{
		$permissions = $this->entityManager->getRepository(PermissionEntity::class)->findBy(['status' => PermissionRepository::STATUS_ENABLED]);

		foreach ($permissions as $permission) {
			if ($permission->tag == PermissionRepository::TAG_ALLOW) {
				$this->permission->allow($permission->role, $permission->resource, $permission->action);
			} elseif ($permission->tag == PermissionRepository::TAG_OWN) {
				$this->permission->allow($permission->role, $permission->resource, $permission->action . PermissionObject::ACESS_OWN_CHAR);
			} elseif ($permission->tag == PermissionRepository::TAG_DENY) {
				$this->permission->deny($permission->role, $permission->resource, $permission->action);
			}
		}
	}

}
