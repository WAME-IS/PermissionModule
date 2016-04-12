<?php

namespace Wame;

use Nette\DI\Container;
use Nette\Security\User;
use Wame\Core\Models\Plugin;
use Wame\PermissionModule\Models\PermissionObject;
use Wame\PermissionModule\Models\PermissionLoader;

class PermissionModule extends Plugin 
{
	/** @var PermissionObject */
	private $permission;
	
	/** @var PermissionLoader */
	private $permissionLoader;
	
	public function __construct(
		Container $container,
		PermissionObject $permission,
		PermissionLoader $permissionLoader
	) {
		$this->permission = $permission;
		$this->permissionLoader = $permissionLoader;
		
		$container->getService('plugin.loader')->onAfterStartPlugins[] = function() {
			$this->afterStartPlugins();
		};
	}
	
	public function onEnable() 
	{
		User::extensionMethod('isAllowedObject', function(User $user, $object, $resource, $privilege) {
			foreach ($user->getRoles() as $role) {
				if ($this->permission->isAllowedObject($object, $user, $role, $resource, $privilege)) {
					return TRUE;
				}
			}
			return FALSE;
		});
		
		$this->permission->addResource('permission');
		$this->permission->addResourceAction('permission', 'view');
		$this->permission->allow('admin', 'permission', 'view');
		$this->permission->addResourceAction('permission', 'add');
		$this->permission->allow('admin', 'permission', 'add');
		$this->permission->addResourceAction('permission', 'edit');
		$this->permission->allow('admin', 'permission', 'edit');
		$this->permission->addResourceAction('permission', 'delete');
		$this->permission->allow('admin', 'permission', 'delete');
		
		$this->permission->addResource('role');
		$this->permission->addResourceAction('role', 'view');
		$this->permission->allow('admin', 'role', 'view');
		$this->permission->addResourceAction('role', 'add');
		$this->permission->allow('admin', 'role', 'add');
		$this->permission->addResourceAction('role', 'edit');
		$this->permission->allow('admin', 'role', 'edit');
		$this->permission->addResourceAction('role', 'delete');
		$this->permission->allow('admin', 'role', 'delete');
	}
	
	public function afterStartPlugins() 
	{
		$this->permissionLoader->setupPermissions();
	}

}
