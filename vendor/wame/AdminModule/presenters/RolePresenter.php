<?php

namespace App\AdminModule\Presenters;

use Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters\AdminFormPresenter;
use Wame\PermissionModule\Entities\RoleEntity;
use Wame\PermissionModule\Repositories\RoleRepository;


class RolePresenter extends AdminFormPresenter
{
	/** @var RoleRepository @inject */
	public $repository;

	/** @var RoleEntity */
	protected $entity;

	/** @var int */
	private $countRoles;


    /** actions ***************************************************************/

    public function actionDefault()
    {
        if (!$this->user->isAllowed('role', 'default')) {
			$this->flashMessage(_('To enter this section you have not sufficient privileges.'), 'danger');
			$this->redirect('parent');
		}

        $this->countRoles = $this->repository->countBy([]);
    }


    public function actionCreate()
    {
        if (!$this->user->isAllowed('role', 'create')) {
			$this->flashMessage(_('To enter this section you have not sufficient privileges.'), 'danger');
			$this->redirect('parent');
		}
    }


    public function actionEdit()
    {
        if (!$this->user->isAllowed('role', 'edit')) {
			$this->flashMessage(_('To enter this section you have not sufficient privileges.'), 'danger');
			$this->redirect('parent');
		}

        $this->entity = $this->repository->get(['id' => $this->id]);
    }


    public function actionDelete()
    {
        if (!$this->user->isAllowed('role', 'delete')) {
			$this->flashMessage(_('To enter this section you have not sufficient privileges.'), 'danger');
			$this->redirect('parent');
		}

        $this->entity = $this->repository->get(['id' => $this->id]);
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
		$this->template->countRoles = $this->countRoles;
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
