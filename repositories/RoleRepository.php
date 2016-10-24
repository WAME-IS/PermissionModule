<?php

namespace Wame\PermissionModule\Repositories;

use Wame\Core\Repositories\BaseRepository;
use Wame\PermissionModule\Entities\RoleEntity;


class RoleRepository extends BaseRepository
{
	const STATUS_BLOCKED = 0;
	const STATUS_ACTIVE = 1;


	public function __construct()
    {
		parent::__construct(RoleEntity::class);
	}


    /**
     * Create role
     *
     * @param RoleEntity $roleEntity
     */
	public function create($roleEntity)
	{
		$this->entityManager->persist($roleEntity);
	}


    /**
     * Update role
     *
     * @param RoleEntity $roleEntity
     * @return RoleEntity
     */
	public function update($roleEntity)
	{
		return $roleEntity;
	}


	/**
	 * Return role list
	 *
	 * @param array $criteria
	 * @return array
	 */
	public function getRoles($criteria = ['status' => self::STATUS_ACTIVE])
	{
		return $this->findPairs($criteria, 'name', ['name' => 'ASC'], 'name');
	}


    /**
     * Change status
     *
     * @param array $criteria
     * @param int $status
     */
    public function changeStatus($criteria = [], $status = self::STATUS_BLOCKED)
    {
        $entity = $this->get($criteria);
        $entity->setStatus($status);
    }

}