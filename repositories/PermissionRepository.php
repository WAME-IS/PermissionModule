<?php

namespace Wame\PermissionModule\Repositories;

class PermissionRepository extends \Wame\Core\Repositories\BaseRepository
{
	const TABLE_NAME = 'permission';
	
	const STATUS_DISABLED = 0;
	const STATUS_ENABLED = 1;
	
	const TAG_ALLOW = 'a';
	const TAG_DENY = 'd';
	const TAG_NONE = 'n';
	const TAG_OWN = 'o';
	
	public function __construct(\Nette\DI\Container $container, \Kdyby\Doctrine\EntityManager $entityManager) {
		parent::__construct($container, $entityManager, self::TABLE_NAME);
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
	
}