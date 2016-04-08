<?php

namespace App\AdminModule\Presenters;

use Wame\PermissionModule\Entities\RoleEntity;
use Wame\PermissionModule\Repositories\RoleRepository;

class RolesPresenter extends BasePresenter
{	
	/** @var RoleEntity */
	private $roleEntity;
	
	public function startup() 
	{
		parent::startup();
		
		$this->roleEntity = $this->entityManager->getRepository(RoleEntity::class);
	}

	public function renderDefault()
	{
		$this->template->siteTitle = _('User roles');
		$this->template->roleEntity = $this->roleEntity->findBy(['status' => RoleRepository::STATUS_ACTIVE]);
	}

}
