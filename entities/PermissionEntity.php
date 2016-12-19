<?php

namespace Wame\PermissionModule\Entities;

use Doctrine\ORM\Mapping as ORM;
use Wame\Core\Entities\BaseEntity;
use Wame\Core\Entities\Columns;

/**
 * @ORM\Table(name="wame_permission")
 * @ORM\Entity
 */
class PermissionEntity extends BaseEntity 
{
    use Columns\Identifier;
    use Columns\Status;
    use Columns\EditDate;
	use Columns\EditUser;
    
    
	/**
	 * @ORM\ManyToOne(targetEntity="RoleEntity")
	 * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
	 */
    protected $role;

	/**
	 * @ORM\Column(name="resource", type="string", length=30, nullable=false)
	 */
	protected $resource;

	/**
	 * @ORM\Column(name="action", type="string", length=30, nullable=false)
	 */
	protected $action;
	
	/**
	 * @ORM\Column(name="tag", type="string", length=1, nullable=false)
	 */
	protected $tag;

}
