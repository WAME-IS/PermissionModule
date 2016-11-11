<?php

namespace App\AdminModule\Presenters;

use Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters\AdminFormPresenter;
use Wame\PermissionModule\Entities\RoleEntity;
use Wame\PermissionModule\Repositories\RoleRepository;
use Wame\PermissionModule\Models\PermissionObject;

class RolePresenter extends AdminFormPresenter
{
	/** @var RoleRepository @inject */
	public $repository;

    /** @var PermissionObject @inject */
    public $permissionObject;
    
	/** @var RoleEntity */
	protected $entity;


    /** actions ***************************************************************/

    public function actionShow()
    {
        $this->entity = $this->getEntityById();
    }
    
    
    public function actionDelete()
    {
        $this->entity = $this->getEntityById();
    }


    /** handles ***************************************************************/

	public function handleDelete()
	{
        $this->repository->changeStatus(['id' => $this->id], RoleRepository::STATUS_BLOCKED);

		$this->flashMessage(sprintf(_('Role %s has been successfully deleted'), $this->entity->getName()), 'success');
		$this->redirect(':Admin:Role:', ['id' => null]);
	}


    /** renders ***************************************************************/

    public function renderDefault()
	{
		$this->template->siteTitle = _('User roles');
		$this->template->count = $this->count;
	}
    
    
    public function renderShow()
    {
        $this->template->siteTitle = _('Show user permissions');
        $this->template->subTitle = $this->entity->getName();
        
        $this->template->entity = $this->entity;
        $this->template->permissionObject = $this->permissionObject;
    }


    public function renderCreate()
    {
        $this->template->siteTitle = _('Create user role');
    }


    public function renderEdit()
    {
        $this->template->siteTitle = _('Edit user role');
        $this->template->subTitle = $this->entity->getName();
    }


	public function renderDelete()
	{
		$this->template->siteTitle = _('Delete role');
        $this->template->subTitle = $this->entity->getName();
	}


    /** abstract methods ******************************************************/

    /** {@inheritdoc} */
    protected function getFormBuilderServiceAlias()
    {
        return 'Admin.RoleFormBuilder';
    }


    /** {@inheritdoc} */
    protected function getGridServiceAlias()
    {
        return 'Admin.RoleGrid';
    }

}
