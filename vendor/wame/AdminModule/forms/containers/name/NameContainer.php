<?php

namespace Wame\PermissionModule\Vendor\Wame\AdminModule\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\DynamicObject\Forms\Containers\BaseContainer;
use Wame\PermissionModule\Repositories\RoleRepository;


interface INameContainerFactory extends IBaseContainer
{
	/** @return NameContainer */
	public function create();
}


class NameContainer extends BaseContainer
{
    /** @var RoleRepository */
    private $roleRepository;


    public function __construct(
        RoleRepository $roleRepository
    ) {
        parent::__construct();

        $this->roleRepository = $roleRepository;
    }


    /** {@inheritDoc} */
    public function configure()
	{
		$this->addText('name', _('Name'))
				->setRequired(_('Please enter name'));
    }


    /** {@inheritDoc} */
	public function setDefaultValues($entity)
	{
        $this['name']->setDefaultValue($entity->getName());
	}


    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $find = $this->roleRepository->countBy(['name' => $values['name'], 'status' => RoleRepository::STATUS_ACTIVE]);

        if ($find > 0) {
            $form->addError(_('Role with that name already exists.'));
        }

        $form->getEntity()->setName($values['name']);
    }


    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $find = $this->roleRepository->countBy(['id !=' => $form->getEntity()->getId(), 'name' => $values['name'], 'status' => RoleRepository::STATUS_ACTIVE]);

        if ($find > 0) {
            $form->addError(_('Role with that name already exists.'));
        }

        $form->getEntity()->setName($values['name']);
    }

}