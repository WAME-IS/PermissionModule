<?php

namespace App\AdminModule\Presenters;

use Nette\Application\UI\Form;
use Wame\PermissionModule\Entities\RoleEntity;
use Wame\PermissionModule\Repositories\RoleRepository;
use Wame\PermissionModule\Vendor\Wame\AdminModule\Forms\RoleForm;

class RolePresenter extends BasePresenter
{	
	/** @var RoleEntity */
	private $roleEntity;
	
	/** @var RoleRepository @inject */
	public $roleRepository;
	
	/** @var RoleForm @inject */
	public $roleForm;
	
	public function startup() 
	{
		parent::startup();
		
		$this->roleEntity = $this->entityManager->getRepository(RoleEntity::class);
	}
	
	protected function createComponentRoleForm()
	{
		$form = $this->roleForm->create();
		$form->setRenderer(new \Tomaj\Form\Renderer\BootstrapVerticalRenderer);
		
		if ($this->id) {
			$defaults = $this->roleEntity->findOneBy(['id' => $this->id]);

			$form['name']->setDefaultValue($defaults->name);

			if ($defaults->inherit) {
				$form['inherit']->setDefaultValue($defaults->inherit->id);
			}
		}
		
		$form->onSuccess[] = [$this, 'roleFormSucceeded'];
		
		return $form;
	}
	
	public function roleFormSucceeded(Form $form, $values)
	{
		if ($this->id) {
			$this->roleRepository->setRole($this->id, $values);

			$this->flashMessage(_('The role was successfully update'), 'success');
		} else {
			$find = $this->roleEntity->countBy(['name' => $values['name'], 'status' => RoleRepository::STATUS_ACTIVE]);
			
			if ($find) {
				$this->flashMessage(_('Role with that name already exists'), 'warning');
				$this->redirect('this');
			}
			
			$this->roleRepository->addRole($values);

			$this->flashMessage(_('The role was created successfully'), 'success');
		}
		
		$this->redirect('this');
	}

	
	public function renderDefault()
	{
		if ($this->id) {
			$this->template->siteTitle = _('Edit user role');
		} else {
			$this->template->siteTitle = _('Add user role');
		}
	}
	
	
	public function renderDelete()
	{
		$this->template->siteTitle = _('Deleting role');
	}
	
	
	public function handleDelete()
	{
		$role = $this->roleEntity->findOneBy(['id' => $this->id]);
		$role->status = RoleRepository::STATUS_BLOCKED;
		
		$this->flashMessage(_('Role has been successfully deleted'), 'success');
		$this->redirect(':Admin:Roles:', ['id' => null]);
	}

}
