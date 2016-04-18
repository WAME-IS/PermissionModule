<?php

namespace Wame\PermissionModule\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="wame_role")
 * @ORM\Entity
 */
class RoleEntity extends \Wame\Core\Entities\BaseEntity 
{
    /**
     * @ORM\Column(name="id", type="integer", length=2, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

	/**
	 * @ORM\Column(name="name", type="string", length=30, nullable=false)
	 */
	protected $name;

	/**
	 * @ORM\ManyToOne(targetEntity="RoleEntity")
	 * @ORM\JoinColumn(name="inherit_id", referencedColumnName="id", nullable=false)
	 */
    protected $inherit;

	/**
	 * @ORM\Column(name="status", type="integer", length=1, nullable=true)
	 */
	protected $status;

}
