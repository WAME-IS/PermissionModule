<?php

namespace Wame\PermissionModule\Forms;

use Wame\DynamicObject\Forms\BaseFormContainer;
use Wame\PermissionModule\Repositories\RoleRepository;

interface IRoleFormContainerFactory
{
	/** @return RoleFormContainer */
	function create();
}


class RoleFormContainer extends BaseFormContainer
{
	/** @var array */
	private $roleList;

	
	public function __construct(RoleRepository $roleRepository) 
	{
		parent::__construct();
		
		$this->roleList = $roleRepository->getRoles();
	}

	
    public function render() 
	{
        $this->template->_form = $this->getForm();
        $this->template->render(__DIR__ . '/default.latte');
    }

	
    public function configure() 
	{
		$form = $this->getForm();

		$form->addSelect('role', _('Role'), $this->roleList)
				->setPrompt(_('- Select a role -'));
    }
	
	
	public function setDefaultValues($object)
	{
		$form = $this->getForm();

		$form['role']->setDefaultValue($object->userEntity->role);
	}
	
}