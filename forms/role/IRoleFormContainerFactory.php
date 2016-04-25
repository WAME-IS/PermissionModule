<?php

namespace Wame\PermissionModule\Forms;

interface IRoleFormContainerFactory
{
	/** @return RoleFormContainer */
	function create();
	
}