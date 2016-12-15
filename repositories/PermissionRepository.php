<?php

namespace Wame\PermissionModule\Repositories;

use Wame\Core\Repositories\BaseRepository;
use Wame\PermissionModule\Entities\PermissionEntity;

class PermissionRepository extends BaseRepository
{
	const STATUS_DISABLED = 0;
	const STATUS_ENABLED = 1;
	
	const TAG_ALLOW = 'a';
	const TAG_DENY = 'd';
	const TAG_NONE = 'n';
	const TAG_OWN = 'o';
    
    
    public function __construct()
    {
        parent::__construct(PermissionEntity::class);
    }
	
	public function getAllowedTags()
	{
		$return = [
			self::TAG_ALLOW => _('Allow'),
			self::TAG_DENY => _('Deny'),
			self::TAG_NONE => _('None'),
			self::TAG_OWN => _('Own')
		];
		
		return $return;
	}
    
    
    /**
     * Create permission
     * 
     * @param PermissionEntity $permissionEntity    permission
     * @return PermissionEntity
     */
    public function create($permissionEntity)
    {
        $this->entityManager->persist($permissionEntity);
        $this->entityManager->flush();
        
        return $permissionEntity;
    }
    
    /**
     * Update permission
     * 
     * @param PermissionEntity $permissionEntity    permission
     * @return PermissionEntity
     */
    public function update($permissionEntity)
    {
        return $permissionEntity;
    }
	
}