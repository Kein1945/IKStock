<?php

namespace IK\StockBundle\Entity\Attribute;

use Doctrine\ORM\Mapping as ORM;
use IK\StockBundle\Model\Attribute\Provider as AttributeProvider;

/**
 * @ORM\Entity
 * @ORM\Table(name="attribute_category")
 */
class Category {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", name="required")
     */
    private $required;

    /**
     * @ORM\Column(type="attributeextensiontype", name="extension")
     */
    private $extension;

    /**
     * @ORM\ManyToOne(targetEntity="IK\StockBundle\Entity\Category", inversedBy="attributes")
     */
    private $category;

    public function getExtensionInstance(){
        $extension = AttributeProvider::getExtension($this->extension);
        $extension->setCategory($this);
        return $extension;
    }

    // Generated methods
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
     * @return Category
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

    /**
     * Set require
     *
     * @param boolean $required
     * @return Category
     */
    public function setRequired($required)
    {
        $this->required = $required;
    
        return $this;
    }

    /**
     * Get require
     *
     * @return boolean 
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Set category
     *
     * @param IK\StockBundle\Entity\Category $category
     * @return Category
     */
    public function setCategory(\IK\StockBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return IK\StockBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set extension
     *
     * @param attributeextensiontype $extension
     * @return Category
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    
        return $this;
    }

    /**
     * Get extension
     *
     * @return attributeextensiontype 
     */
    public function getExtension()
    {
        return $this->extension;
    }
}