<?php

namespace App\AdminModule\Presenters;

use Nette\Application\UI\Form;
use Wame\PermissionModule\Entities\RoleEntity;
use Wame\PermissionModule\Repositories\RoleRepository;
use Wame\PermissionModule\Vendor\Wame\AdminModule\Forms\RoleForm;
use Wame\PermissionModule\Vendor\Wame\AdminModule\Grids\RoleGrid;
use Wame\DataGridControl\IDataGridControlFactory;

class RolePresenter extends BasePresenter
{	
	/** @var RoleEntity */
	private $roleEntity;
	
	/** @var RoleRepository @inject */
	public $roleRepository;
	
	/** @var RoleForm @inject */
	public $roleForm;
    
    /** @var IDataGridControlFactory @inject */
	public $gridControl;
    
    /** @var RoleGrid @inject */
	public $roleGrid;
	
    
	public function startup() 
	{
		parent::startup();
		
		$this->roleEntity = $this->entityManager->getRepository(RoleEntity::class);
	}
    
    
    /** actions ***************************************************************/
    
    public function actionEdit()
    {
        if (!$this->user->isAllowed('role', 'edit')) {
			$this->flashMessage(_('To enter this section you have not sufficient privileges.'), 'danger');
			$this->redirect('parent');
		}
    }
    
    public function actionCreate()
    {
        if (!$this->user->isAllowed('role', 'add')) {
			$this->flashMessage(_('To enter this section you have not sufficient privileges.'), 'danger');
			$this->redirect('parent');
		}
    }
    
    
    /** handles ***************************************************************/
	
	public function handleDelete()
	{
		$role = $this->roleEntity->findOneBy(['id' => $this->id]);
		$role->status = RoleRepository::STATUS_BLOCKED;
		
		$this->flashMessage(_('Role has been successfully deleted'), 'success');
		$this->redirect(':Admin:Roles:', ['id' => null]);
	}

    
    /** renders ***************************************************************/
	
    public function renderDefault()
	{
		$this->template->siteTitle = _('User roles');
		$this->template->roleEntity = $this->roleEntity->findBy(['status' => RoleRepository::STATUS_ACTIVE]);
	}
    
    public function renderEdit()
    {
        $this->template->siteTitle = _('Edit user role');
    }
    
    public function renderCreate()
    {
        $this->template->siteTitle = _('Add user role');
    }
	
	public function renderDelete()
	{
		$this->template->siteTitle = _('Deleting role');
	}
    
    
    /** components ************************************************************/
    
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
    
    
    /**
	 * Create role grid component
	 * @param type $name
	 * @return type
	 */
	protected function createComponentRoleGrid()
	{
        $qb = $this->roleRepository->createQueryBuilder('a');
		$grid = $this->gridControl->create();
		$grid->setDataSource($qb);
		$grid->setProvider($this->roleGrid);
		
		return $grid;
	}
    
    
}
