<?php

namespace Wame\PermissionModule\Vendor\Wame\MenuModule\Components\MenuControl\AdminMenu;

use Nette\Application\LinkGenerator;
use Wame\MenuModule\Models\Item;

interface IAdminMenuItem
{
	/** @return AdminMenuItem */
	public function create();
}


class AdminMenuItem implements \Wame\MenuModule\Models\IMenuItem
{	
    /** @var LinkGenerator */
	private $linkGenerator;
	
	
	public function __construct(
		LinkGenerator $linkGenerator
	) {
		$this->linkGenerator = $linkGenerator;
	}
	
	
	public function addItem()
	{
		$item = new Item();
		$item->setName('user');
		
		$item->addNode($this->role(), 'role');
		
		return $item->getItem();
	}
	
	
	private function role()
	{
		$item = new Item();
		$item->setName('user-roles');
		$item->setTitle(_('Roles'));
		$item->setLink($this->linkGenerator->link('Admin:Role:', ['id' => null]));
		
		return $item->getItem();
	}

}
