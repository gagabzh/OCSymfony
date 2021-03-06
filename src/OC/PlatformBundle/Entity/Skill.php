<?php
/**
 * Created by PhpStorm.
 * User: bgarnier
 * Date: 13/02/2018
 * Time: 17:41
 */
namespace OC\PlatformBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


/**

 * @ORM\Entity

 * @ORM\Table(name="oc_skill")

 */

class Skill

{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;


    /**
     * @ORM\Column(name="name", type="string", length=255)
     */

    private $name;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Skill
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
}
