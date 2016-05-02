<?php

namespace Wame\PermissionModule\Vendor\Wame\MenuModule\Components\MenuControl\AdminMenu;

use Wame\MenuModule\Models\Item;

class AdminMenuItem
{	
	/** @var \Nette\Application\LinkGenerator */
	private $linkGenerator;
	
	public function __construct($linkGenerator)
	{
		$this->linkGenerator = $linkGenerator;
	}
	
	public function addItem()
	{
		$item = new Item();
		$item->setName('user');
		
		$item->addNode($this->roles(), 'roles');
		
		return $item->getItem();
	}
	
	private function roles()
	{
		$item = new Item();
		$item->setName('user-roles');
		$item->setTitle(_('Roles'));
		$item->setLink($this->linkGenerator->link('Admin:Roles:', ['id' => null]));
		
		return $item->getItem();
	}

}
