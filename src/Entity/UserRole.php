<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 04/05/14
 * Time: 09:54
 */

namespace App\Entity;


use Symfony\Component\Security\Core\Role\Role;
//use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\ORM\Mapping as ORM;
use Serializable;

/**
 * Role
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class UserRole  extends Role implements Serializable {

    public function __construct($role)
    {
        parent::__construct($role);
        $this->role = $role;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, unique=true)
     */
    protected $role;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set name
     *
     * @param  string $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

//    /**
//     * Set role
//     *
//     * @param  string $role
//     * @return Role
//     */
//    public function setRole($role)
//    {
//        $this->role = $role;
//
//        return $this;
//    }

    /**
     * Serializes the content of the current Group object
     * @return string
     */
    public function serialize()
    {
        return \json_encode(
            array(
                $this->name,
                $this->role,
            )
        );
    }

    /**
     * Unserializes the given string in the current Group object
     * @param $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->name,
            $this->role
            ) = \json_decode($serialized);
    }

} 