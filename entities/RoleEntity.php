<?php

namespace Wame\PermissionModule\Entities;

use Doctrine\ORM\Mapping as ORM;
use Wame\Core\Entities\BaseEntity;
use Wame\Core\Entities\Columns;

/**
 * @ORM\Table(name="wame_role")
 * @ORM\Entity
 */
class RoleEntity extends BaseEntity
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


    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get inherit
     *
     * @return RoleEntity
     */
    public function getInherit()
    {
        return $this->inherit;
    }

    /**
     * Set inherit
     *
     * @param RoleEntity $inherit inherit
     * @return $this
     */
    public function setInherit(RoleEntity $inherit)
    {
        $this->inherit = $inherit;

        return $this;
    }

}
