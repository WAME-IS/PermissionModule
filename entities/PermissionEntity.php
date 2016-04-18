<?php

namespace Wame\PermissionModule\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="wame_permission")
 * @ORM\Entity
 */
class PermissionEntity extends \Wame\Core\Entities\BaseEntity 
{
    /**
     * @ORM\Column(name="id", type="integer", length=4, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

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
	
	/**
	 * @ORM\Column(name="status", type="integer", length=1, nullable=true)
	 */
	protected $status;

}
