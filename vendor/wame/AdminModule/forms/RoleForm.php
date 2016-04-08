<?php

namespace Wame\PermissionModule\Vendor\Wame\AdminModule\Forms;

use Nette\Object;
use Kdyby\Doctrine\EntityManager;
use Wame\Core\Forms\FormFactory;
use Wame\PermissionModule\Entities\RoleEntity;
use Wame\PermissionModule\Repositories\RoleRepository;

class RoleForm extends Object
{	
	/** @var FormFactory */
	private $formFactory;

	/** @var RoleEntity */
	private $roleEntity;
	
	/** @var array */
	private $roleList;
	
	public function __construct(
		EntityManager $entityManager,
		FormFactory $formFactory
	) {
		$this->formFactory = $formFactory;
		
		$this->roleEntity = $entityManager->getRepository(RoleEntity::class);
		$this->roleList = $this->roleEntity->findPairs(['status' => RoleRepository::STATUS_ACTIVE], 'name');
	}

	public function create()
	{
		$form = $this->formFactory->createForm();
		
		$form->addText('name', _('Name'))
				->setRequired(_('Please enter role name'));

		$form->addSelect('inherit', _('Inherit by'), $this->roleList)
				->setPrompt('- ' . _('Select inherit role') . ' -');

		$form->addSubmit('submit', _('Submit'));
		
		return $form;
	}

}
