<?php

namespace Wame\PermissionModule\Repositories;

use Wame\PermissionModule\Entities\RoleEntity;

class RoleRepository extends \Wame\Core\Repositories\BaseRepository
{
	const STATUS_BLOCKED = 0;
	const STATUS_ACTIVE = 1;
	
	/** @var RoleEntity */
	private $roleEntity;
	
	
	public function __construct(
		\Nette\DI\Container $container, 
		\Kdyby\Doctrine\EntityManager $entityManager, 
		\h4kuna\Gettext\GettextSetup $translator, 
		\Nette\Security\User $user
	) {
		parent::__construct($container, $entityManager, $translator, $user, RoleEntity::class);
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
	
	
	/**
	 * Get roles by criteria
	 * 
	 * @param array $criteria
	 * @param string $orderBy
	 * @param int $limit
	 * @param int $offset
	 * @return RoleEntity
	 */
	public function getAll($criteria = [], $orderBy = null, $limit = null, $offset = null)
	{
		return $this->roleEntity->findBy($criteria, $orderBy, $limit, $offset);
	}
	
	
	/**
	 * Get pairs
	 * 
	 * @param array $criteria
	 * @param string $value
	 * @param array $orderBy
	 * @param string $key
	 * @return RoleEntity
	 */
	public function getPairs($criteria = [], $value = null, $orderBy = [], $key = null)
	{
		return $this->roleEntity->findPairs($criteria, $value, $orderBy, $key);
	}
	
	
	/**
	 * Return roles id => name
	 * 
	 * @param array $criteria
	 * @return array
	 */
	public function getRoles($criteria = ['status' => self::STATUS_ACTIVE])
	{
		return $this->getPairs($criteria, 'name', 'name', 'name');
	}
	
}