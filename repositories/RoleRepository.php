<?php

namespace Wame\PermissionModule\Repositories;

use Wame\Core\Repositories\BaseRepository;
use Wame\PermissionModule\Entities\RoleEntity;

class RoleRepository extends BaseRepository
{
	const STATUS_BLOCKED = 0;
	const STATUS_ACTIVE = 1;
	
    
	/** @var RoleEntity */
	private $roleEntity;
	
	
	public function __construct()
    {
		parent::__construct(RoleEntity::class);
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
		$role->inherit = $this->findOneBy(['id' => $values['inherit']]);
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
		return $this->findBy($criteria, $orderBy, $limit, $offset);
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
		return $this->findPairs($criteria, $value, $orderBy, $key);
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