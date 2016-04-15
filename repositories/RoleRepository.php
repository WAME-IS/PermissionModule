<?php

namespace Wame\PermissionModule\Repositories;

use Wame\PermissionModule\Entities\RoleEntity;

class RoleRepository extends \Wame\Core\Repositories\BaseRepository
{
	const TABLE_NAME = 'role';
	
	const STATUS_BLOCKED = 0;
	const STATUS_ACTIVE = 1;
	
	/** @var RoleEntity */
	private $roleEntity;
	
	public function __construct(\Nette\DI\Container $container, \Kdyby\Doctrine\EntityManager $entityManager, \h4kuna\Gettext\GettextSetup $translator, \Nette\Security\User $user) {
		parent::__construct($container, $entityManager, $translator, $user);
		
		$this->roleEntity = $this->entityManager->getRepository(RoleEntity::class);
	}
	
	public function addRole($values)
	{
		$role = new RoleEntity();
		
		$role->name = $values['name'];
		$role->inherit = $this->roleEntity->findOneBy(['id' => $values['inherit']]);
		$role->status = self::STATUS_ACTIVE;
		
		$this->entityManager->persist($role);
	}
	
	public function setRole($roleId, $values)
	{
		$role = $this->roleEntity->findOneBy(['id' => $roleId]);
		
		$role->name = $values['name'];
		$role->inherit = $this->roleEntity->findOneBy(['id' => $values['inherit']]);
	}
	
}