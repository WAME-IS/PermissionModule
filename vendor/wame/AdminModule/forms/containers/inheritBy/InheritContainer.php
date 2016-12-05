<?php

namespace Wame\PermissionModule\Vendor\Wame\AdminModule\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\DynamicObject\Forms\Containers\BaseContainer;
use Wame\PermissionModule\Repositories\RoleRepository;


interface IInheritContainerFactory extends IBaseContainer
{
    /** @return InheritContainer */
    public function create();
}


class InheritContainer extends BaseContainer
{
    /** @var RoleRepository */
    private $roleRepository;

    /** @var array */
    private $roleList;


   	public function __construct(
        \Nette\DI\Container $container,
		RoleRepository $roleRepository
	) {
		parent::__construct($container);

		$this->roleRepository = $roleRepository;
        $this->roleList = $roleRepository->getRoles();
	}


    /** {@inheritDoc} */
    public function configure()
    {
        $this->addSelect('inherit', _('Inherit by'), $this->roleList)
				->setPrompt('- ' . _('Select inherit role') . ' -');
    }


    /** {@inheritDoc} */
    public function setDefaultValues($entity, $langEntity = null)
    {
        if ($entity->getInherit()) {
            $this['inherit']->setDefaultValue($entity->getInherit()->getName());
        }
    }


    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $roleEntity = $this->roleRepository->get(['name' => $values['inherit']]);

        $form->getEntity()->setInherit($roleEntity);
    }


    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $roleEntity = $this->roleRepository->get(['name' => $values['inherit']]);

        $form->getEntity()->setInherit($roleEntity);
    }

}
