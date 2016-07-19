<?php

namespace Wame\PermissionModule\Models;

class PermissionObject extends \Nette\Security\Permission 
{
	const ACESS_OWN_CHAR = '*';
	const STRICT_ACTIONS = true;

	/** @var array */
	private $resourceActions = [];

	public function __construct() 
	{
		/*
		 * ! WARNING !
		 * Nemaju byt role nacitane dynamicky?
		 */
		$this->addRole('guest');
		$this->addRole('client', ['guest']);
		$this->addRole('moderator', ['client']);
		$this->addRole('admin', ['moderator']);
	}

	public function isAllowedObject($object, $user, $role, $resource, $privilege) 
	{
		if (parent::isAllowed($role, $resource, $privilege)) {
			return true;
		}
		
		if (parent::isAllowed($role, $resource, $privilege . self::ACESS_OWN_CHAR)) {
			return $object->isAllowed($user);
		}
		
		return false;
	}

	public function addResource($resource, $parent = null) 
	{
		parent::addResource($resource, $parent);
		
		$this->resourceActions[$resource] = [];
	}

	public function addResourceAction($resource, $action) 
	{
		$this->resourceActions[$resource][] = $action;
	}

	public function getResourceActions($resource) 
	{
		if (isset($this->resourceActions[$resource])) {
			return $this->resourceActions[$resource];
		} else {
			throw new \Exception("Actions for resource \"$resource\" are undefined");
		}
	}

	protected function setRule($toAdd, $type, $roles, $resources, $privileges, $assertion = null) 
	{
		if (\Tracy\Debugger::isEnabled()) {
			if (is_array($privileges)) {
				foreach ($privileges as $privilege) {
					if (is_array($resources)) {
						foreach ($resources as $resource) {
							$this->checkActionValidity($resource, $privilege);
						}
					} else {
						$this->checkActionValidity($resources, $privilege);
					}
				}
			} else {
				if (is_array($resources)) {
					foreach ($resources as $resource) {
						$this->checkActionValidity($resource, $privileges);
					}
				} else {
					$this->checkActionValidity($resources, $privileges);
				}
			}
		}

		parent::setRule($toAdd, $type, $roles, $resources, $privileges, $assertion);
	}

	private function checkActionValidity($resource, $action) 
	{
		if (\Nette\Utils\Strings::endsWith($action, self::ACESS_OWN_CHAR)) {
			$action = substr($action, 0, -1);
		}

		if (!in_array($action, $this->getResourceActions($resource))) {
			throw new \Exception("Permission action \"$action\" is not defined for resource \"$resource\"");
		}
	}

}
