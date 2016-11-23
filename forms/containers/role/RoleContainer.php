<?php

namespace Wame\PermissionModule\Forms\Containers;

use Wame\DynamicObject\Forms\Containers\BaseContainer;
use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\PermissionModule\Repositories\RoleRepository;

interface IRoleContainerFactory extends IBaseContainer
{
	/** @return RoleContainer */
	public function create();
}

class RoleContainer extends BaseContainer
{
    /** @var array */
	protected $roleList;


    public function __construct(\Nette\DI\Container $container, RoleRepository $roleRepository)
    {
        parent::__construct($container);

        $this->roleList = $roleRepository->getRoles();
    }
    

    /** {@inheritDoc} */
    public function configure()
	{
        $this->addSelect('role', _('Role'), $this->roleList);
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity = null)
	{
        $this['role']->setDefaultValue($entity->getRole());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $form->getEntity()->setRole($values['role']);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getEntity()->setRole($values['role']);
    }

}