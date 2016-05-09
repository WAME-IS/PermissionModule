<?php

namespace Wame\PermissionModule\Entities;

use Doctrine\ORM\Mapping as ORM;
use Wame\Core\Entities\Columns;

/**
 * @ORM\Table(name="wame_role")
 * @ORM\Entity
 */
class RoleEntity extends \Wame\Core\Entities\BaseEntity 
{
	use Columns\Status;

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
	 * @ORM\JoinColumn(name="inherit_id", referencedColumnName="id", nullable=true)
	 */
    protected $inherit;

}
