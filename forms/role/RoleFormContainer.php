<?php

namespace Wame\PermissionModule\Forms;

use Wame\DynamicObject\Forms\BaseFormContainer;
use Wame\PermissionModule\Repositories\RoleRepository;

class RoleFormContainer extends BaseFormContainer
{
	/** @var array */
	private $roleList;
	
	/** @var RoleRepository @inject */
	public $roleRepository;
	
	public function injectServices(RoleRepository $roleRepository)
	{
		$this->roleRepository = $roleRepository;
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
	
}